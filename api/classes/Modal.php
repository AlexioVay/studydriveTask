<?php

class Modal {

    public function process($x) {
        $db = MysqliDb::getInstance();
        $output = null;
        $one = $x[1];
        $two = $x[2];
        $three = $x[3];
        #$four = $x[4];

        switch ($one):
            case 'termsofservice': case 'privacy':
                $doc = init::load('Docs');
                $output['html'] = $doc->output(['target' => $one]);
                $output['button'] = '<button class="btn btn-info close">OK</button>';
            break;
            case 'login':
                $output['html'] =
                '<div class="row">
                <fieldset>
                    <div class="col-sm-6">'.input('email').'</div>
                    <div class="col-sm-6">'.input('pass').'</div>
		        </fieldset>
                </div>
                <p class="f09 grey">'.__('LOST_INTRO').'</p>';
                $output['button'] = '<button class="async btn btn-info" data-form="#modalForm" data-task="login">'.__('LOGIN').'</button>';
                $output['jsr'] = '
                setTimeout(function() { 
                    $("body .popup input").each(function(i, v) {
                        $(this).next().addClass("filled");
                    });
                    $("body .popup:first input[type=email]").focus(); 
                }, 1000);
                ';
            break;
            case 'lost':
                $output['html'] =
                '<div class="row">
                    <fieldset>
                        <div class="col-sm-6">'.input('email').'</div>
                        <div class="col-sm-6">'.input('email_repeat').'</div>
                    </fieldset>
		        </div>';
                $output['button'] = '<button class="async btn btn-info" data-form="#modalForm" data-task="lost">'.__('PASS_REQUEST').'</button>';
                $output['jsr'] = '
                setTimeout(function() { 
                    $("body .popup:first input[name=email]").focus(); 
                }, 1000);
                ';
            break;
            case 'directdebit':
                $output['html'] = "Die Zahlung war erfolgreich.";
                $output['button'] = '<button class="btn btn-info" data-dismiss="modal">OK</button>';
            break;
            case 'verify':
                $output['html'] = "
                <div class='row'>
                    <fieldset>
                        <div class='col-sm-6'>
                            <i class='material-icons pass'>visibility_off</i>
                            ".input('new_pass')."
                        </div>
                        <div class='col-sm-6'>
                            <i class='material-icons pass'>visibility_off</i>
                            ".input('new_pass_repeat')."
                        </div>
                    </fieldset>
                </div>";
                $output['button'] = '<button class="async btn btn-info" data-form="#modalForm" data-task="verify">'.__('SAVE').'</button>';
                $output['jsr'] = '
                setTimeout(function() { 
                    $("body .popup input[name=new_pass]:first-child").focus(); 
                }, 1000);
                ';
            break;
            case 'activate':
                if ($_SESSION['uid']) $uid = $_SESSION['uid'];
                else $uid = $two;
                $code = $three;

                $db->where('uid', $uid);
                $acc = $db->getOne('users_activate', 'code');

                $output['stay'] = true;
                if ($x[2] == 'resend') {
                    $output['header'] = __('MODAL_ACTIVATE_RESEND');
                    $output['jsr'] .= "$('#modal-one .modal-footer').remove();";
                    if ($db->count > 0) {
                        $prename = $_SESSION['prename'];
                        $email = $_SESSION['email'];
                        $code = randnumb(10); # Aktivierungs-Code generieren
                        $db->where('uid', $uid);
                        $db->update('users_activate', ['code' => $code]);
                        $mail_array = array($prename, $uid, $code);
                        send_mail($email, 'activate', $mail_array);

                        $output['html'] = __('MODAL_ACTIVATE_RESEND_TEXT', [null]);
                        $output['hash'] = 'modal-success-3';
                    } else {
                        $output['hash'] = 'modal-activate';
                    }
                } else {
                    $inactive = true;
                    if ($db->count > 0) $inactive = false;
                    $output['html'] = __('MODAL_ACTIVATE_TEXT', [$inactive]);
                    if ($db->count > 0 && $acc['code'] == $code) {
                        // Success: Activate account
                        $db->where('uid', $uid);
                        $db->delete('users_activate');
                        $output['hash'] = 'modal-activate-success';
                    }
                }
            break;
            case 'payment':
                $db->where('uid', $_SESSION['uid']);
                $order = $db->getOne('orders', 'id');
                $output['arr']['purpose'] = $_SESSION['uid'] . " / " . $order['id'];
            break;
            case 'steampay':
                $output['button'] = '<button class="async btn btn-info" data-form="#modalForm" data-task="steampay">OK</button>';
            break;
        endswitch;
        $output['arr']['hashArr'] = $x;

        return $output;
    }

    public function create($id) {
        $body = null;
        $button = null;
        if ($id == "1" || $id = "2") {
            $button = '<a class="close btn btn-info">OK</a>';
        }
        $output = '
        <form id="modalForm">
            ' . $button . '
        </form>
        ';
        return $output;
    }
}