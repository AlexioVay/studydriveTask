<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
// Init:
define('LOCALHOST', ((strpos($_SERVER['HTTP_REFERER'], 'localhost') !== false) || $_SERVER['HTTP_HOST'] == 'localhost') ? true : false);
define('XFILE', 1);
$data = $_POST['data'];
// Load project related init file:
$this_uri = $data['uri'];
if (empty($this_uri) && $_COOKIE['uri']) $this_uri = $_COOKIE['uri'];
if (LOCALHOST)
    require_once 'C:/xampp/htdocs/'.$data['project'].'/init.php';
else
    require_once '/www/htdocs/'.$data['root_username'].'/'.$data['project'].'/init.php';

if (!empty($data['session_id'])) {
    session_id($data['session_id']);
    session_start();
}
$cookies = null;
if (is_array($data['cookies'])) {
    $cookies = '<table class="table table-responsive f08" data-snap-ignore=\'true\'>';
    foreach ($data['cookies'] as $k => $x) {
        $cookies .= '<tr><td>' . $k . '</td><td class="pl10" width="60%"><strong>' . $x . '</strong></td></tr>';
    }
    $cookies .= '</table>';
}
$sess = null;
if (is_array($_SESSION)) {
    $sess = '<table class="table table-responsive f08" data-snap-ignore=\'true\'>';
    foreach ($_SESSION as $k => $x) {
        $sess .= '<tr><td>' . $k . '</td><td class="pl10" width="60%"><strong>' . $x . '</strong></td></tr>';
    }
    $sess .= '</table>';
}

// Prevent Duplicates:
$text = '
<strong>Error</strong>
<p class="robo mt5 f10">'.htmlspecialchars($data['errorText']).'</p>
<div class="row">
    <div class="col-sm-5"><strong>Session</strong><p class="mt5">'.$sess.'</p></div><div class="col-sm-5"><strong>Cookies</strong><p class="mt5">'.$cookies.'</p></div><div class="col-sm-2"><strong>Language</strong><p class="mt5">'.$data['lgc'].'</p></div>    
</div>';
$db->where('sessid', $data['session_id']);
$id = $db->getValue('errors', 'id');
$insert = ['uid' => $_SESSION['uid'], 'sessid' => $data['session_id'], 'log' => $text, 'uri' => $this_uri, 'dir' => $data['project'], 'date' => $db->now()];

if ($db->count < 1) {
    $id = $db->insert('errors', $insert);
    // Upload Screenshot:
    # Process:
    /*$img = $data['img'];
    $encodedData = str_replace(['data:image/jpeg;base64,', ' '], ['', '+'], $img);
    $img = base64_decode($encodedData);
    # Upload:
    $file = __DIR__ . '/upload/errors/' . $data['session_id'] . '.jpeg';
    file_put_contents($file, $img);
    */
} else {
    $db->where('id', $id);
    $db->update('errors', $insert);
}
# Send Email:
$email_data = $data;
#$email_data['img'] = null;
$email_data['errorText'] = $text;
send_mail('info@jobspace24.com', 'notify', $email_data);

$arr = [
    'id' => $id,
    'data' => $data,
    'result' => $db->getLastQuery()
];
$json = json_encode($arr);
print $json;