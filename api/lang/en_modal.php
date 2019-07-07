<?php
return [
    'MODAL_ORDER_PLACED' => 'Your order has been placed successfully. We have sent you an order confirmation email. Please check your email inbox.',
    'MODAL_CHECK_INBOX' => 'Please check your email inbox to activate your account.',
    'MODAL_ACCOUNT_ACTIVATED' => 'Your account has been activated successfully.',
    'MODAL_PASSWORD_RECOVERY' => 'You received an email with an instruction to recover your password.',
    'MODAL_CHANGES_SAVED' => 'Your changes have been saved successfully.',
    'MODAL_PASSWORD_SAVED' => 'Your new password has been saved successfully.  
    You can <a href="#modal-login">login now</a> with your new credentials.',
    'S9' => 'Payment successful',

    'MODAL_ERROR_REGISTRATION' => "You have to <a href='".ROOT."signup/1'>sign up</a> to use that function. 
    You can <a href='#modal-login'>login here</a> if you already have an account.",
    'MODAL_ERROR_PAYPAL' => "An error occured as you\'ve sent your payment with PayPal. Please select another payment method if this error persists.",
    'MODAL_ERROR_ACCESS' => "You don\'t have access to this particular site.",
    'MODAL_ERROR_FACEBOOK' => "Your connection to our Facebook App hasn\'t been confirmed. Please repeat this step and confirm the connection to Facebook.",
    'MODAL_ERROR_OCCURED' => 'There is an error that occured performing this action. If this issue won\'t be resolved, 
    we would appreciate a detailed description how exactly this error occured.  
    Please send this description to <a href="mailto:'.CONTACT_EMAIL.'">'.CONTACT_EMAIL.'</a>. 
    This will help us finding and fixing this error.',

    'MODAL_SAVE' => 'Saving...',
    'MODAL_DELETING_ACCOUNT' => 'Deleting Account...',
    'MODAL_WE_REPLY_SOON' => 'Thank you! We will process your inquiry soon...',
    'MODAL_ERROR' => 'Error',
    'MODAL_VERIFY_DECLINE_OFFER' => 'Do you really want to decline this job offer?',
    'MODAL_PLEASE_WAIT' => 'Please wait...',
    'MODAL_LOGGING_IN' => 'Logging in...',
    'MODAL_VERIFY_QUEUE' => 'Your code will be checked.',
    'MODAL_TERMSOFSERVICE' => 'Terms of Service',

    'MODAL_ORDER_NOT_FOUND' => 'Either the order number was not found or the job placement is already completed.',
    'MODAL_PAYMENT' => 'Payment details',
    'MODAL_PAYMENT_TEXT' => function($x) {
        $hash = $x[0];

        $body = '
        <p>Your order to mediate '.__('JOB_AS').' has been successfully received by us.
        <br />
        As soon as we determine your payment, your participation will be confirmed immediately and the
        official mediation '.__('JOB_AS').' will be activated.<br />
        </p>
        <div class="box-green mt20 mb20">
        Tip: You can also send your bank transfer receipt to <a href="mailto:payment@'.ROOT_SHORT.'">payment@'.ROOT_SHORT.'</a> and get unlocked immediately.
        </div>   
        <p>     
        Please transfer the amount of <strong>'._n(PRICE).'</strong>
        to the following bank account <strong><u>within 14 days:</u></strong>
        </p>
        '.banking($hash['purpose']).'
        <p class="f09 grey">
        If you have questions about your order, please use one of our contact options to reach us.
        We will contact you as soon as possible.
        </p>';

        return $body;
    },
    'MODAL_LOCKED' => 'Login required',
    'MODAL_LOCKED_TEXT' => function($x) {
        $body = '
        <p>The page or function you want to open is restricted. 
        Please login or <a href="'.ROOT.'signup">sign up now</a> to receive access to this area.</p>';

        return $body;
    },
    'MODAL_DIRECTDEBIT' => 'Direct Debit Payment',
    'MODAL_DIRECTDEBIT_TEXT' => 'Thank you for your order. 
    We will deduct the service fee from your bank account within the next 1-3 business days. 
    Your account will be unlocked immediately when your payment has been confirmed.<br />
    You will receive an e-mail notification that your account is unlocked and you job placement is open.',
    'MODAL_STEAMPAY' => 'Payment with Steam Gift Card',
    'MODAL_STEAMPAY_TEXT' => function($x) {
        $body = '
        <p>The option to pay with a Steam gift card is valued by our customers, because Steam gift cards  
        are available in many stores with cash payment.<br />
        Simply enter your Steam gift card code in the following text box to unlock your account immediately:
        </p>
        <input class="mt15" type="text" name="code" placeholder="Code deiner Steam-Guthabenkarte" />
        <p class="mb5 mt10">
        Please note that the code has to be entered exactly like it is 
        displayed on your Steam gift card (including minus sign).
        </p>
        <div class="box-green mt20 mb20">
        Hint: Steam gift cards are available at DM, Rewe, MediaMarkt, GameStop or Saturn in Germany.
        <div class="pt10 pb15">
            <img src="'.ROOT.'img/dm.svg" width="30" height="30" class="mr5" />
            <img src="'.ROOT.'img/media_markt.svg" width="90" height="30" class="mr5" />
            <img src="'.ROOT.'img/rewe.svg" width="40" height="35" class="mr7" />
            <img src="'.ROOT.'img/rossmann.svg" width="80" height="38" class="mr7" />
            <img src="'.ROOT.'img/gamestop.svg" width="80" height="38" />
        </div>         
        <a href="https://support.steampowered.com/kb_article.php?ref=1193-wlxv-6514&l=german" target="_blank">Click here</a> to   
        get an overview of other stores in different countries that offer Steam gift cards.
        </div>
        <p class="f09 grey">
        If you have any questions, please use the contact option at our 
        <a href="'.ROOT.'help/">Help Center</a> to get in touch with us.  
        We will get back to you as soon as possible.
        </p>';

        return $body;
    },
    'MODAL_ACTIVATE' => 'Activation in progress...',
    'MODAL_ACTIVATE_TITLE' => 'Account Activation',
    'MODAL_ACTIVATE_RESEND' => 'Request Activation',
    'MODAL_ACTIVATE_SUCCESS' => 'Activation successful!',
    'MODAL_ACTIVATE_TEXT' => function($x) {
        return '
        <p class="mb10">
        Your activation link is invalid because either you already have been activated or your
        activation link is expired.
        </p>
        <p class="f09 grey-normal">
        You can <a href="#modal-activate-resend">resend a new activation link</a> anytime.
        </p>
        ';
    },

    'MODAL_EXAMPLE' => '100% Transparency',
    'MODAL_EXAMPLE_TEXT' => function($x) {
        return '
        <p class="mb10">
        This section serves as an example to show you how it would look like when you are receiving new job offerings with our help.
        </p>
        <p class="f09 grey">
        Please scroll down a little bit more to get a job position '.__('JOB_AS').'.
        </p>';
    },
    'MODAL_LOGIN' => __('PROJECT') .' Login',
    'MODAL_LOST' => 'Passwort zurücksetzen',
    'MODAL_VERIFY' => 'Neues Passwort setzen',
    'MODAL_SETTINGS' => 'Einstellungen',
    'MODAL_PRIVACY' => 'Privacy Policy'
];