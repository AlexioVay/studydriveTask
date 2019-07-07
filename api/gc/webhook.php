<?php /** @noinspection PhpUnhandledExceptionInspection */
require_once 'gocardless.php';

// Set Secret
$token = 'TgozcbbBNQQnjYtBro9jQTe8UNID-5HkhGntXY-q'; // jobservice.payment@gmail.com -> ST Webhook Secret
// Use this line to fetch the body of the HTTP request
$webhook = file_get_contents('php://input');
$webhook_array = json_decode($webhook, true);

// Security Calculation
if (!function_exists('getallheaders')) {
    function getallheaders() {
       $headers = '';
       foreach ($_SERVER as $name => $value) {
           if (substr($name, 0, 5) == 'HTTP_') {
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
           }
       }
       return $headers;
    }
}
$headers = getallheaders();
$provided_signature = $headers["Webhook-Signature"];
$calculated_signature = hash_hmac("sha256", $webhook, $token);

// Process Webhook
if ($webhook_array['events'] && $provided_signature == $calculated_signature) {
    require_once 'init.php';
    $webhook_valid = true;
    $mandate_id = $webhook_array['events'][0]['links']['mandate'];
    $payment_id = $webhook_array['events'][0]['links']['payment'];
    function queryLog($db) {
        $output = null;
        if (!empty($db->getLastQuery())) $output .= '
[SQL Query] 
' . $db->getLastQuery();
if (!empty($db->getLastError())) $output .= '
[SQL Error] 
' . $db->getLastError();
        return $output;
    }
    $i = 1;
    $log = null;
    $sql = null;
    $action = null;
    foreach ($webhook_array['events'] as $key => $val) {
        foreach ($webhook_array['events'][$key] as $innerKey => $innerVal) {
            if ($innerKey == 'action') {
                // + submitted, confirmed, active
                // - failed, cancelled
                $action[] = $innerVal;
            }
            if ($innerKey == 'links') {
                if ($innerVal['mandate'] && empty($mandate_id)) $mandate_id = $innerVal['mandate'];
                if ($innerVal['payment'] && empty($payment_id)) $payment_id = $innerVal['payment'];
            }
            /*if ($innerKey == 'details') {
                if ($innerVal['cause']) $cause = $innerVal['cause'];
            }
            // Maybe sometime relevant when working with 'cause' cases:
            // 'mandate_created', 'payment_created', 'mandate_submitted', 'payment_submitted', 'payment_cancelled'
            */
        }
    }

    if (!empty($payment_id) || !empty($mandate_id)) {
        if (!empty($payment_id)) {
            $db->where('o.payment_id', $payment_id);
            $db->join('users u', 'o.uid = u.id');
            $order = $db->getOne('orders o', 'o.id, o.uid, o.mandate, o.status, o.price, u.prename, u.surname');
            if (empty($mandate_id)) $mandate_id = $order['mandate'];
        } else if (!empty($mandate_id)) {
            $db->where('o.mandate', $mandate_id);
            $db->join('users u', 'o.uid = u.id');
            $order = $db->getOne('orders o', 'o.id, o.uid, o.payment_id, o.status, o.price, u.prename, u.surname');
            if (empty($payment_id)) $payment_id = $order['payment_id'];
        }
$log .= '
Order ID: '.$order['id'].'
User ID: '.$order['uid'].'
Payment ID: '.$payment_id.'
Mandate ID: '.$mandate_id.'
';

        if ($db->count > 0) {
            // Define Variables
            $id = $order['id'];
            $uid = $order['uid'];
            $prename = $order['prename'];
            $surname = $order['surname'];
            $price = $order['price'];
            $status = $order['status'];
$log .= '
Customer: '.$prename.' '.$surname.'
';
$sql .= queryLog($db);
            // Update Log
            if (!empty($log)) {
                $db->where('payment_id', $payment_id);
                $db->update('orders', ['log' => implode(', ', $action)]);
                $sql .= queryLog($db);
            }
            // Payment failed: Set status to 'Pending' again
            if (in_array('failed', $action) || in_array('cancelled', $action)) {
                $db->where('payment_id', $payment_id);
                $db->update('orders', ['status' => 'Failed']);
                $sql .= queryLog($db);
            } else if (in_array('confirmed', $action)) {
                $db->where('payment_id', $payment_id);
                $db->update('orders', ['status' => 'Completed']);
                $sql .= queryLog($db);
                // Send "successful order" email to customer
                $data = [$prename, "pp", 'Completed', $uid, $price, $id];
                send_mail($uid, 'order', $data);
            }
        }
    }
}

if ($webhook_valid == true) {
    // Send a success header
    header('HTTP/1.1 200 OK');
    // Mail
    $msg = wordwrap($log . $sql, 70);
    mail("alexiovay@gmail.com","Webhook.php Report (".$_SERVER['HTTP_HOST'].")", $msg);
} else {
    header('HTTP/1.1 403 Invalid signature');
}
if (!empty($log)) echo $log;
if (!empty($sql)) echo $sql;