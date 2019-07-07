<?php
require 'guzzle/autoloader.php';
require 'gc/loader.php';
$price = PRICE;
#$access_token = GC_SANDBOX_TOKEN;
$access_token = GC_LIVE_TOKEN;
$client = new \GoCardlessPro\Client([
  'access_token' => $access_token,
  'environment' => \GoCardlessPro\Environment::LIVE
]);
// Create GoCardless Customer-Creation-Link
if (isset($_SESSION['uid'])) {
    if (!$db) $db = MysqliDb::getInstance();
    if (!$_GET['redirect_flow_id'] && $_SESSION['uid']) { // Get Mandate + Customer
        $db->where('uid = '.$_SESSION['uid'].' AND mandate IS NOT NULL AND customer IS NOT NULL');
        $customer = $db->getOne('orders', 'id, mandate, customer');
        if (empty($_SESSION['order_id'])) $_SESSION['order_id'] = $customer['id'];
    }

if (!$_GET['redirect_flow_id'] && !$customer['mandate'] && !$cancel_payment && !$cancel_subscription) {
    // External Redirect: Create New Customer
    $url = ROOT . '#modal-directdebit';

    if ($_SESSION['uid']) $sess_token = $_SESSION['uid']; else $sess_token = 1;
    $redirectFlow = $client->redirectFlows()->create(
    ["params" =>
        ["description" => ''.__('PAY_DD_DESCRIPTION').'',
        "session_token" => ''.$sess_token.'',
        "success_redirect_url" => ''.$url.'?closeIAB=1']
    ]);
    #print("ID: " . $redirectFlow->id . "<br />");
    $pay_url = $redirectFlow->redirect_url;
}

// Cancel Subscription
if (isset($order)) {
    if ($cancel_subscription && $order['payment_id']) {
        $client->subscriptions()->cancel($order['payment_id']);
    } elseif ($cancel_payment && $order['payment_id']) {
        $client->payments()->cancel($order['payment_id']);
    }
}
// SELECT Payment/Order Details
if ($_SESSION['order_id']) {
    $db = MysqliDb::getInstance();
    $db->where('id', $_SESSION['order_id']);
    $db->where('uid', $_SESSION['uid']);
    $result = $db->getOne('orders', 'price, status');
}

try {
    $gc = null;
    if ($customer['mandate'] && $customer['customer']) {
        $gc['mandate'] = $customer['mandate'];
        $gc['customer'] = $customer['customer'];
    } elseif ($_GET['redirect_flow_id']) {
        $redirectFlow = $client->redirectFlows()->complete($_GET['redirect_flow_id'], ["params" => ["session_token" => ''.$_SESSION['uid'].'']]);
        $gc['mandate'] = $redirectFlow->links->mandate;
        $gc['customer'] = $redirectFlow->links->customer;
    }
    if (!empty($customer['id'])) {
        $_SESSION['order_id'] = $customer['id'];
        $order_id = $customer['id'];
    } else if (!empty($_SESSION['order_id'])) {
        $order_id = $_SESSION['order_id'];
    }

    $mail_dd = false; // Send (if true) or don't send (if false) successful direct debit mail
    // Create Subscription
    if ($result['type'] == 'membership' && $result['status'] == 'Pending') {
        /*
        $subscription = $client->subscriptions()->create([
          "params" => [
            "amount" => $price * 100, // In Cents
            "currency" => "EUR",
            "interval_unit" => "monthly",
            #"day_of_month" => "".$day."",
            "links" => ["mandate" => "".$gc['mandate'].""],
            "metadata" => ["subscription_number" => "".$_SESSION['order_id']."", "uid" => "".$_SESSION['uid'].""]
          ],
          #"headers" => ["Idempotency-Key" => "".$_SESSION['uid']."-".$_SESSION['order_id'].""]
        ]);
        $gc['payment_status'] = $subscription->status;
        $gc['id'] = $subscription->id;

        // Assign Customer to Order
        $db->where('id', $_SESSION['order_id']);
        $db->update('orders',
        ['paid' => 0, 'mandate' => $gc['mandate'], 'customer' => $gc['customer'], 'txn_id' => $gc['id'], 'log' => $gc['payment_status']]);
        unset($_SESSION['order_id']);
        $GC_data['success'] = __('MODAL_ORDER');
        */
    } elseif ($result && $gc['customer'] && $gc['mandate']) {
        $payment = $client->payments()->create([
          "params" => [
            "amount" => $result['price'] * 100, // In Cents
            "currency" => "EUR",
            "links" => ["mandate" => "".$gc['mandate'].""],
            "metadata" => ["invoice_number" => "".$_SESSION['order_id'].""]
            ],
          #"headers" => ['Idempotency-Key' => ''.$_SESSION['uid'].'-'.$_SESSION['order_id'].'']
        ]);
        $paymentID = ''.$payment->id.'';
        $payment = $client->payments()->get($paymentID);
        $gc['payment_status'] = $payment->status;
        $gc['id'] = $paymentID; // payment_id OR txn_id

        if (!empty($order_id)) {
            // Assign Customer to Order
            $db->where('id', $order_id);
            $db->update('orders',
            ['payment_id' => $gc['id'], 'mandate' => $gc['mandate'], 'customer' => $gc['customer'],
            'txn_id' => $gc['id'], 'log' => $gc['payment_status'], 'date_updated' => $db->now(), 'status' => 'Pending']);
        }
        $GC_data['success'] = __('MODAL_ORDER');
        $mail_dd = true;
    }
    // Set Order to Paid + Completed
    # If Customer has already completed at least one order with

    if ($gc['payment_status'] == 'completed') {
        $db->where('id', $order_id);
        $db->update('orders', ['status' => 'Completed']);
        $mail_dd = true;
    } else {
        $GC_data['hash'] = '#modal-directdebit';
    }

    if ($mail_dd) {
        $mail_array = [$_SESSION['prename'], $price, $order_id];
        send_mail($_SESSION['email'], 'dd', $mail_array);
    }
    #pending_customer_approval: we’re waiting for the customer to approve this payment
    #pending_submission: the payment has been created, but not yet submitted to the banks
    #submitted: the payment has been submitted to the banks
    #confirmed: the payment has been confirmed as collected
    #paid_out: the payment has been included in a payout
    #cancelled: the payment has been cancelled#
    #customer_approval_denied: the customer has denied approval for the payment. You should contact the customer directly
    #failed: the payment failed to be processed. Note that payments can fail after being confirmed if the failure message is sent late by the banks.
    #charged_back: the payment has been charged back
} catch (Exception $e) {
    $error = ($e->getMessage());
    $gc['error'] = $error;
    $mail_array = ['Order ID: ' . $order_id, $error, $_SESSION['uid']];
    send_mail($_SESSION['email'], 'error', $mail_array);
}

if ($pay_url) $GC_data['external'] = $pay_url;

return $GC_data;

}
#$customers = $client->customers()->list()->records;
#print_r($customers);
#$subs = $client->subscriptions()->list();
#var_dump($subs);