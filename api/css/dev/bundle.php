<?php
$x = base64_decode($_GET['x']);
$y = $_GET['y'];
$z = $_GET['z'];
header("Content-type: text/css");
require_once '../../paths.php';
echo '@charset "utf-8";';

$params = null;
if (isset($z)) {
    $z = explode(',', $z);

    foreach ($z as $val) {
        $zEx = explode(':', $val);
        $key = $zEx[0];
        $value = $zEx[1];
        $params[$key] = $value;
    }
}

if (isset($y)) {
    // Load Page Relevant CSS:
    switch($y):
        case 'signup': case 'settings':
            if (($y == 'signup' && (isset($params['step']) && $params['step'] == 2)) || $y == 'settings')
                require_once '../account.min.css';
        break;
    endswitch;
}
// Load Default CSS:
if (LOCALHOST) {
    #require_once 'bootstrap.min.css';
    require_once 'default.css';
} else {
    require_once '../default.min.css';
}
// Load Project Custom CSS:
if (LOCALHOST) {
    require_once $x . 'css/dev/custom.css';
} else {
    require_once $x . 'css/custom.min.css';
}
?>
