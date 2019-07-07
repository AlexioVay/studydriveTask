<?php
function fb_access($init_only = false) {
        $fb = null;
        if (empty(session_id())) session_start();
        require_once 'autoload.php';
        $fb = new Facebook\Facebook([
          'app_id' => FACEBOOK_APP_ID,
          'app_secret' => FACEBOOK_APP_SECRET,
          'default_graph_version' => 'v3.1',
        ]);

        if (!$init_only) {
            $Cookie = new Cookie($_COOKIE);
            $helper = $fb->getRedirectLoginHelper();
            $client = $fb->getOAuth2Client();
            $ref = ROOT;
            if ($Cookie->redirect) $ref = ROOT . $Cookie->redirect;
            $return['ref'] = $ref;

            if ($_SESSION['fb_token']) {
                $accessToken = $_SESSION['fb_token'];
            } elseif (empty($_GET['code'])) {
                // Define Redirect URL
                if (isset($_GET['ref']) && !empty($_GET['ref'])) {
                    $Cookie->redirect = $_GET['ref'] . "/";
                } else {
                    $Cookie->redirect = null;
                }
                $permissions = ['email']; #, 'user_birthday']; // Optional permissions
                $loginUrl = $helper->getLoginUrl(ROOT . 'signin-facebook', $permissions);
                header("Location: ".$loginUrl."");
                exit();
            } elseif (!empty($_GET['code'])) {
                $return['client'] = $client;
                $return['helper'] = $helper;
                // Retrieve AccessToken
                try {
                    $accessToken = $helper->getAccessToken(''.ROOT.'signin-facebook');
                    $accessToken = $client->getLongLivedAccessToken($accessToken);
                } catch(Exception $e) {
                    #echo $e;
                    #exit();
                    header("Location: ".$ref."#modal-error-facebook");
                    exit();
                }
            }
        }
        if (isset($accessToken) && !empty($accessToken)) {
            $fb_token = (string) $accessToken;
            $return['token'] = $fb_token;
            if (empty($_SESSION['fb_token'])) $_SESSION['fb_token'] = $fb_token;
        }
        $return['fb'] = $fb;

        return $return;
}
$access = fb_access();




try {
    $response = $access['fb']->get('/me?fields=gender,id,email,first_name,last_name,locale', $access['token']); // need to let birthday approve
    $user = (Array) $response->getGraphUser();
} catch (Exception $e) {
    #var_dump($e);
    #exit();
    header("Location: ".ROOT."signup#modal-error-facebook");
    exit();
}

if (isset($user) && is_array($user)) {
    $key = key($user);
    $user = $user[$key];
    $birthdate = null;
    if (isset($user['birthday'])) {
        $user['birthday'];
        $birthdate_cast = (Array) $user['birthday'];
        $birthdate = substr($birthdate_cast['date'], 0, 10);
    }
	// Get User Likes
	/*$request = new FacebookRequest($session, 'GET', '/'.$graphObject['id'].'/likes');
    $response = $request->execute();
    $graphObject = $response->getGraphObject()->asArray();
	var_dump($graphObject);
	exit();
	*/
    if ($user['gender'] == "male") $_SESSION['fb_gender'] = 1;
    else $_SESSION['fb_gender'] = 2;

	$_SESSION['fb'] = true;
	$_SESSION['fb_uid'] = $user['id'];
	$_SESSION['fb_email'] = $user['email'];
	$_SESSION['fb_prename'] = $user['first_name'];
	$_SESSION['fb_surname'] = $user['last_name'];
	$_SESSION['fb_bday'] = $birthdate;
	$_SESSION['fb_locale'] = $user['locale'];

    // Process Linked Account
    $email = false;
    if (empty($_SESSION['email'])) { // If NOT logged in, search assigned account
        $db = MysqliDb::getInstance();
        $db->where('fb_uid = '.$user['id'].'');
        $get_email = $db->getValue('users', 'email');
        if ($db->count > 0) { // linked account found
            $email = $get_email;
        }
    } elseif(isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $email = $_SESSION['email'];
    } else {
        $db = MysqliDb::getInstance();
        $db->where('fb_uid = '.$user['id'].'');
        $email = $db->getValue('users', 'email');
    }
    if (!empty($email)) {
        login($email);
    } else {
        $access['ref'] = ROOT . 'signup';
    }
}

header("Location: ".ROOT."signup");
exit();
?>