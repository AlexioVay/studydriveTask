<?php
/** @noinspection PhpUnhandledExceptionInspection */
// Routing
require_once ROOT_CMS_ABS . 'route/AltoRouter.php';
$router = new AltoRouter();
// Routes
/* @var AltoRouter() $router */
$js64 = base64_encode(ROOT_USERNAME.'/'.DIR);
if (LOCALHOST) {
    if (!defined('XFILE')) $router->setBasePath(DIR . '/');
    $js64 = base64_encode(DIR);
}

if (defined('XFILE')) {
    $path = str_replace(URI, '', $_SERVER['REQUEST_URI']);
    $path = substr($path, 1);
    $router->setBasePath($path);
}

$router->map('GET', '/', 'home', 'home');
$router->map('GET', '/guarantee', 'Guarantee', 'Guarantee');
$router->map('GET', '/news', 'news', 'news');
$router->map('GET', '/news/[*:topic]/[i:tid]', 'news', 'news_topic');
$router->map('GET', '/news/[*:topic]', 'news', 'news_details');
$router->map('GET', '/help', 'help', 'help');
$router->map('GET', '/imprint', 'imprint', 'imprint');
$router->map('GET', '/settings', 'settings', 'settings');
$router->map('GET', '/privacy', 'privacy', 'privacy');
$router->map('GET', '/termsofservice', 'termsofservice', 'termsofservice');
$router->map('GET', '/signin-facebook', 'fb', 'fb');
# Account
$router->map('GET', '/signup', 'signup', 'signup');
$router->map('GET', '/signup/[i:step]', 'signup', 'signup_step');
$router->map('GET', '/admin', 'admin', 'admin');
# User
$router->map('GET', '/user/[i:id]', 'user', 'user');
# Referal
$router->map('GET', '/[i:rid]', 'ref', 'user_ref');
$match = $router->match();

// More Constants:
define('ID', $match['params']['id']);

// Global $match Variables:
/** @var Init $init */
require_once 'classes/Init.php';
$init = new Init();
$startup = $init->startup();
$account = $init->account($startup['signup']);
$match['js'] = $js64;
$match['uri'] = URI;
$match['login'] = $account['login'];
$match['signup'] = $startup['signup'];
// In what $match['target'] should it be forbidden to save cookie stored input, because a SAVE button has to be clicked there:
$match['noCookieSave'] = ['settings'];

// $_GET Processes:
if (isset($_GET)) {
    if ($_GET['s'] == 'verify' && $_GET['set'] == 'password' && !$_SESSION['verify']) {
        header("Location: " . ROOT . "?s=verify");
        exit();
    }
    // Reload same page without query string:
    if (isset($_GET['lang']) && !empty($_GET['lang'])) {
        $full_path = explode('?', $_SERVER["REQUEST_URI"], 2)[0]; // Cut out lang
        header("Location: " . $full_path);
        exit();
    }
    // GoCardless:
    if (isset($_GET['redirect_flow_id']) && !empty($_GET['redirect_flow_id'])) {
        require_once 'gocardless.php';
        header("Location: " . ROOT . "#modal-directdebit");
        exit();
    }
    if (isset($_GET['xhrr']) && !empty($_GET['xhrr'])) {
        $init->XHRReturn($_GET['xhrr']);
    }
}

switch ($match['target']):
    default:
        $match['class'] = ucfirst($match['target']);
    break;
    /* - - -    H o m e    - - - */
    case '': case 'home': case 'ref':
        if ($match['target'] == 'ref') {
            $rid = $match['params']['rid'];
            $_SESSION['rid'] = $rid;
            header('Location: ' . ROOT);
            exit();
        }
        $header = null;
        switch (INITIALS):
            case 'ST': $header = 1; break;
            case 'SJ': case 'VM': $match['module'][] = 'sliderSwap'; break;
        endswitch;

        $nav = init::load('Navigation');
        $match['class'] = 'Home';

        // Assign Values:
        $match['signup_button'] = $account['signup_button'];
        $match['reasons'] = $startup['reasons'];
        $match['status'] = $init->status($match);
        $match['header'] = $header;
    break;
    /* - - -    S i g n U p    - - - */
    case 'signup': case 'settings':
        $this_step = $match['params']['step'];
        if ($match['target'] == 'settings') {
            if ($_SESSION['uid'] < 1) {
                header('Location: ' . ROOT);
                exit();
            }
            $match['module'][] = 'collapse';
            $match['module'][] = 'croppie';
            $match['subtarget'] = 'step2';
            $match['asideRegisterForm'] = false;
        } else if ($match['target'] == 'signup') {
            // Redirections:
            $redirect = false;
            if ($_SESSION['uid'] < 1 && $_SESSION['step'] < 2 && $this_step != 1) {
                $redirect = 'signup/1';
            } else if ($_SESSION['completed']) {
                $redirect = '';
            } else if ((isset($this_step) && isset($_SESSION['step'])) && $this_step > $_SESSION['step']) {
                $redirect = 'signup/' . $_SESSION['step'];
            }
            if ($redirect) {
                header('Location: ' . ROOT . $redirect);
                exit();
            }

            $step = 'step1';
            if ($this_step > 1) {
                if ($this_step == 2) {
                    $match['module'][] = 'croppie';
                    if (INITIALS == 'ST') $match['module'][] = 'collapseShowHide';
                } else if ($this_step == 3) {
                    $match['module'][] = 'scrollX';
                }
                $step = 'step'.$this_step;
            }

            $match['subtarget'] = $step;
        }
        $match['output'] = 'signup';
        $match['module'][] = 'account';
        $match['module'][] = 'sticky';
        $match['class'] = 'Account'; // Class to load
    break;
    /* - - -    N e w s    - - - */
    case 'news':
        if ($match['name'] == 'news') {
            // News Overview
            $match['limit'] = 3; // News Entry Limit per Topic
            if (IS_MOBILE)
                $match['clearRight'] = true;
        }
        $match['module'][] = 'sticky';
        $match['module'][] = 'collapse';
        $match['class'] = 'News';
    break;
    /* - - -    D o c s    - - - */
    case 'imprint': case 'privacy': case 'termsofservice': case 'help':
        switch ($match['target']):
            case 'privacy': case 'termsofservice': case 'imprint':
                $match['container'] = true;
                $match['nofollow'] = true;
            break;
        endswitch;

        $match['class'] = 'Docs';
    break;
    /* - - -    A d m i n    - - - */
    case 'admin':
        if (empty($_SESSION['admin'])) {
            header('Location: ' . ROOT . '#modal-error-access');
        } else {
            $match['module'][] = 'scrollX';
        }

        $match['class'] = 'Admin';
        $match['nofollow'] = true;
    break;
    case 'fb':
        include ROOT_CMS_ABS . 'fb-sdk/fb.php';
    break;
endswitch;