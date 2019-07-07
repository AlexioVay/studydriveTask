<?php /** @noinspection PhpIncludeInspection */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
// Init:
define('LOCALHOST', ((strpos($_SERVER['HTTP_REFERER'], 'localhost') !== false) || $_SERVER['HTTP_HOST'] == 'localhost') ? true : false);
define('XFILE', 1);
// Example link:
// <a class="ajax-(case)"
// data-task="(class),(function)"
// data-params="(array[0],array[1],array[2])"
// data-lang="validation" />

// Add Values
if ($_POST)
$data = $_POST['data'];
else if ($_GET)
$data = $_GET['data'];
if (is_array($data)) $data['timer'] = 2000;

if (isset($data['lgc']) && !empty($data['lgc'])){
    define('LGC', $data['lgc']);
    $lgc = $data['lgc'];
}

// Load project related init file:
$this_uri = $data['uri'];
if (empty($this_uri) && $_COOKIE['uri']) $this_uri = $_COOKIE['uri'];
if (LOCALHOST)
    require_once 'C:/xampp/htdocs/'.$data['project'].'/init.php';
else
    require_once '/www/htdocs/'.$data['root_username'].'/'.$data['project'].'/init.php';

// Init
if (isset($data['RID'])) define('RID', $data['RID']);
if (!empty($data['session_id'])) {
    session_id($data['session_id']);
    session_start();
}

// Async Functions
function escape($data) {
    $output = preg_replace("/\r?\n/", "\\n", addslashes($data));
    return $output;
}
function htmlspecialchars_array_modify (&$arr) {
    array_walk_recursive($arr, function(&$value) {
        if (is_string($value)) {
            if (strpos($value, '<3') !== false) $value = str_replace('<3', json_decode('"\uD83D\uDC96"'), $value);
            elseif (!is_numeric($value)) $value = addslashes(htmlspecialchars(strip_tags($value, '&')));
            else $value = htmlspecialchars(strip_tags($value, '&'));
            $value = trim($value);
        }
    });
    return $arr;
}
$data = htmlspecialchars_array_modify($data);

// implode arrays
if (isset($data['form']) && is_array($data['form'])) {
    foreach ($data['form'] as $key => $x) {
        if (is_array($x)) $data['form'][$key] = implode(',', $x);
    }
}

$lang = include ROOT_ABS . 'lang/'.LGC.'.php';
$lang += include ROOT_CMS_ABS . 'lang/'.LGC.'_main.php';
$lang += include ROOT_CMS_ABS . 'lang/'.LGC.'_validation.php';

// Create Modal:
/** @var Modal $modal */
require_once 'classes/Init.php';
$modal = init::load('Modal');
$lang += include ROOT_CMS_ABS . 'lang/'.LGC.'_modal.php';

$default_button_visible = false;
if ($data['hash']) {
    $z = null;
    $hash = explode('-', $data['hash']);
    $hashStr = strtoupper($hash[1]);
    $json = null;
    $json['html'] = null;

    if ($hash[1] == 'error') {
        $search = strtoupper($hash[2]);
        if ($hash[3]) $search .= '_'.strtoupper($hash[3]);

        $json['error'][] = __('MODAL_ERROR_'.$search);
    } else if ($hash[1] == 'success') {
        if ($hash[2] == '9' && defined('PACKAGE') && APP) {
            $db->where('uid', $_SESSION['uid']);
            $db->update('orders',
                ['date_updated' => $db->now(), 'date_confirmed' => $db->now(), 'status' => 'Completed']);
            $data = [$_SESSION['prename'], 'pp', 'Completed', $_SESSION['uid'], PRICE, $_SESSION['order_id']];
            send_mail($_SESSION['email'], 'order', $data);
        }
        $search = strtoupper($hash[2]);
        if ($hash[3]) $search .= '_'.strtoupper($hash[3]);

        $json['success'] = __('MODAL_'.$search);
        $json['reload'] = true;
    } else {
        $function = 'MODAL_'.$hashStr.'_TEXT';
        $z = $modal->process($hash);

        // Special Case Modal Scrolls: (Like scroll exactly to "Review" section)
        /*if ($hash[2] == 'review') {
            $z['jsr'] .= "modalDialog = $('#one .modal-header').height() + 100;";
            if (!IS_MOBILE) {
                $z['jsr'] .= "modalDialog = +($('#one .modal-dialog').offset().top) + modalDialog;";
            }
            $z['jsr'] .= "
            ".$init->jsTimeout("$('#projectLink').click();", 1500)."
            ".$init->jsTimeout("
            console.warn(modalDialog);
            $('.modal-body').animate({
                scrollTop: $('#reviewAnchor').offset().top - modalDialog
            }, 'fast');
            ", 1550);
        }*/
        $content = null;
        if ($hash[2] == 'success') {
            $json['success'] = __('MODAL_' . $hashStr . '_SUCCESS');
            $z['html'] = null;
        } else if (!$z['hash']) {
            $z['header'] = __('MODAL_' . $hashStr);

            if (!empty($lang[$function])) {
                $content = __($function, [$z['arr']]);
            } else if (empty($content) && $z['html']) {
                $content = $z['html'];
            }
            $class = null;
            $json['html'] .= '<div'.$class.'>' . $content . '</div>';
            if ($z['button'])
                $json['button'] = $z['button'];
            else
                $json['button'] = '<button class="btn btn-info close">OK</button>';

            if ($z['jsr']) $json['jsr'] = $z['jsr'];
        }
        if ($z['header']) {
            $full_width = null;
            if ($hash[1] == 'privacy' || $hash[1] == 'termsofservice')
                $full_width = '<a href="' . ROOT . $hash[1] . '" target="_blank" class="fullscreen">' . __('FULLSCREEN') . '<i class="material-icons">launch</i></a>';

            $z['jsr'] .= $init->jsTimeout("$('.popup:first .body').before('<div class=\'header faded in\'><h2>" . $z['header'] . "</h2><span class=\'close\'>x</span>" . $full_width . "</div>');", 500);
        }

        // Assign z to json
        if (isset($z) && is_array($z)) {
            if ($z['arr']) unset($z['arr']);
            foreach ($z as $k => $x) {
                if ($k == 'html' && !empty($json['html'])) continue;
                $json[$k] = $x;
            }
        }
    }
} elseif ($data['task']) {
    require_once ROOT_CMS_ABS . 'classes/Async.php';

    $task = $data['task'][0];
    $async = new Async();
    $json = $async->$task($data);
}

// - - - Modal/PopUp Process:
$json['modalType'] = null;

if (!isset($json['hide'])) {
    $default_button = '<button class=\'btn btn-info close\'>OK</button>';
    if ($json['success']) {
        $json['modalType'] = 'success';
        $json['html'] .= "<i class='material-icons ok'>check_circle</i><p>".$json['success']."</p>";
    } else if ($json['error']) {
        $json['modalType'] = 'error';
        if ($json['error']) {
            $title = __('MODAL_ERROR');
            $arr = $json['error'];
            $json['jsr'] .= $init->jsTimeout('
            $(".popup:first .body").before("<div class=\'header faded in\'><h2>'.$title.'</h2><span class=\'close\'>x</span></div>");
            $(".popup:first .body").after("<div class=\'footer faded in\'>'.$default_button.'</div>");', 700);

            $json['html'] .= "<ul>";
            if (count($arr) > 0) {
                foreach ($arr as $val) {
                    $json['html'] .= "<li class='square'>" . $val . "</li>";
                }
            }
            $json['html'] .= "</ul>";
        }
    }
    if (empty($json['html'])) {
        $json['modalType'] = 'success';
        $json['html'] = '<i class="material-icons ok">check_circle</i><p>' . __('MODAL_PLEASE_WAIT') . '</p>';
    }

    // Add Custom Button/s:
    if ($json['button'])
        $json['jsr'] .= $init->jsTimeout("$('.popup:first .body').after('<div class=\"footer faded in\">" . $json['button'] . "</div>');", 500);
}


/**
 *      @var $json['redirect'] --- redirects at same host
 *      @var $json['external'] --- redirects to external URI
 */
if ($json['reload'] || $json['hash'] || $json['stay'] || $json['redirect'] || $json['external']) {
    $x = null;
    if ($json['external']) {
        $x = $json['external'];
    } else {
        if (!$json['reload'] && $json['redirect']) {
            $uri = $json['redirect'];
        } elseif ($json['reload'] || $json['stay']) {
            if (!LOCALHOST) $uri = $data['uri'];
        }
    }
    if ($json['hash']) $uri .= $json['hash'];
    if (!$json['external']) {
        if (LOCALHOST) {
            $x = 'http://localhost/'.DIR.'/';
        } else {
            $x = ROOT;
        }
    }
    if (isset($uri)) $x .= $uri;
    if ($json['stay'] && $json['hash']) {
        $json['preventClose'] = true;
        $json['jsr'] .= $json['jsr'] . "
        ".$init->jsTimeout('window.location.hash = "'.$json['hash'].'";', 2000)."
        ";
    } elseif (!$json['stay']) {
        $json['jsr'] .= "
        $('main').append(\"<meta http-equiv='refresh' content='2; url=".$x."'>\");
        ".$init->jsTimeout('window.location.href = "'.$x.'";', 1500)."
        ";
    }
}

/* Check for cookies that needs to be saved */
$cookie = null;
if (defined('COOKIESAVE')) {
    $cookie = unserialize(COOKIESAVE);
}

$arr = [
    'data' => $data,
    'cookie' => $cookie,
    'hide' => $json['hide'],
    'modalType' => $json['modalType'],
    'jsr' => $json['jsr'], // jsr = JavaScript Return
    'uid' => $_SESSION['uid'],
    'success' => $json['success'],
    'error' => $json['error'],
    'html' => $json['html']
];
$json = json_encode($arr);

print $json;