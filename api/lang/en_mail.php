<?php
return [
    'MAIL_MORE_INFO_TITLE' => function($x) { return __('PROJECT') . ' - Fragen zu deinem Profil'; },
    'MAIL_MORE_INFO' => function($x) {
        $output = '
Hallo '.$x[0].',
<br />
<br />
​vielen Dank für deine ​Anmeldung bei '.__('PROJECT').'.​ Wir würden gerne mehr über dich erfahren.
<br />
<br />';
        switch (INITIALS):
            case 'SJ':
$output .= '​Bitte beantworte uns folgende Frage ganz offen und ehrlich​:​<br />
<br />
<strong>​​Wie würdest du die ​Reihenfolge folgende​r​ Gründe, Schauspieler ​werden zu wollen, ​sortieren?​</strong><br />
​- Groß rauskommen und berühmt werden<br />
- Sich in eine Rolle hineinversetzen und sie ausleben<br /> 
- Hohe Bezahlung erhalten<br />
<br />
Wir möchten dich mit unserer Frage im Voraus besser einschätzen können und erfahren, wie viel Motivation oder Leidenschaft du mitbringst, um deine Ziele zu erreichen.
<br /><br /> 
Könntest du uns außerdem weitere Fotos, Videos oder andere Referenzen von dir oder von Projekten, bei denen du teilgenommen hast, zusenden?<br />
<br />
Wir freuen uns sehr über deine Rückmeldung und bedanken uns im Voraus für deine Bemühungen.';
            break;
        endswitch;

        return $output;
    },
    'MAIL_ORDER_TITLE' => function(array $values) {
        if ($values[2] == 'Pending') {
            $output = __('PROJECT') . " - Order details";
        } else {
            $output = __('PROJECT') .  " - Payment confirmation";
        }
        return $output;
    },
    'MAIL_ORDER' => function(array $values) {
        $purpose = "".$values[3]." / ".$values[5]."";
        if ($values[2] == 'Pending') {
            $status = "Receiving jobs is <u>not possible right now</u>, because we didn't receive your payment yet.<br />
            Your profile will be unlocked and visible to all relevant companies as soon as your payment has been confirmed.";
            // Case Bank Transfer
            if ($values[1] == 'bt')
            $status .= "<br /><br /> 
            <strong>You can also send your bank transfer receipt to payment@".ROOT_SHORT." to get unlocked immediately.</strong><br /><br />
            Please transfer <strong>"._n($values[4])."</strong> to the following bank account:<br /><br />
            <div style='border-top: 1px solid #cccccc;'>&nbsp;</div>
            ".banking($purpose,1)."";
            else if ($values[1] == 'steam')
            $status .= "<br /><br />
            Please enter a valid <strong>"._n(PRICE)."</strong> Steam Gift Card code <strong><u>within 14 days</u></strong>   
            on <a href='".ROOT."signup/3/#modal-steampay'>our payment site</a>. 
            You will also receive more information on this site that helps you finding stores selling Steam Gift Cards.<br />";
        } else {
            $status = "You have been unlocked successfully ".__('JOB_AS')." in our database.
            Your profile is now visible to all clients. 
            You will be notified instantly when you receive a new job offer.<br />";
        }

        $output = "Hello ".$values[0].",
        <br /><br />
        thank you for your order to be placed in a job ".__('JOB_AS')."!
        ".$status."
        <br />
        </p>
        ".order_calc($values[4])."
        <p>
        Your order number is <strong>".$values[5]."</strong>.
        Please provide this order number when you have any questions regarding your order for faster allocation 
        when contacting us.";

        return $output;
    },

    'MAIL_ACTIVATE_TITLE' => function(array $values) { return __('PROJECT') . ' - Your activation link'; },
    'MAIL_ACTIVATE' => function(array $values) { return 'Hello '.$values[0].',
	<br /><br />
	you have requested a new activation link to confirm your account. Please use this activation link:<br />
	<a href="'.ROOT.'#modal-activate-'.$values[1].'-'.$values[2].'">
	Please click here</a> '; },
    'MAIL_ACCEPT_TITLE' => function(array $values) { return __('PROJECT') . ' - Job offer confirmed'; },
    'MAIL_ACCEPT' => function(array $values) { return 'Hello '.$values[0].',
	<br /><br />
	this is a confirmation that you accepted the job offer of <strong>'.$values[1].'</strong>.   
	You can sit back and relax while we contact the company to give you more information and details soon.'; },
    'MAIL_DECLINE_TITLE' => function(array $values) { return __('PROJECT') . ' - Job offer declined'; },
    'MAIL_DECLINE' => function(array $values) { return 'Hallo '.$values[0].',
	<br /><br />
	this is a confirmation that you declined the job offer of <strong>'.$values[1].'</strong>.  
	We regret your decision and hope that you can tell us what you did not like about this job offer,
    so that we can improve our efforts to get a better job offer for you in the future.'; },
    'MAIL_REGISTER_TITLE' => function(array $values) { return __('PROJECT') . ' - Your registration'; },
    'MAIL_REGISTER' => function(array $values) { return 'Hello '.$values[0].',
	<br /><br />
	thank you for your registration at '.__('PROJECT').'!
	Please confirm your account with this link:
	<a href="#modal-activate-'.$values[1].'-'.$values[2].'">
	Please click here</a>'; },
    'MAIL_LOST_TITLE' => function(array $values) { return __('PROJECT') . ' - Password requested'; },
    'MAIL_LOST' => function(array $values) { return 'Hello '.$values[0].',
	<br /><br />
	you have requested your password for '.__('PROJECT').'. For safety purposes it is required to click this link
    to confirm your identity:
	<br />
	<a href="'.ROOT.'#modal-verify-'.$values[1].'-'.$values[2].'" target="_blank">Please click here</a>'; },
    'MAIL_DD_TITLE' => function(array $values) { return __('PROJECT') . ' - Order details'; },
    'MAIL_DD' => function(array $values) {
        $percent_value = $values[1]*0.19;
        $calc = $values[1]-$percent_value;

        $text = '
        Hello '.$values[0].',<br />
        <br />
        thank you for your order for our job placement service to receive job offers as a game tester.  
        We will deduct the '._n($values[1]).' service fee from your bank account within the next 1-3 business days.
        </p><br />
        <br />
        '.order_calc($values[1]).'
        <p>
        Your order number: <strong>'.$values[2].'</strong>.
        Please provide this order number if you have any questions regarding your order for faster allocation
        to process your issues when contacting us.<br />
        We wish you many job offers as a game tester!
        ';

        return $text;
    },
    'MAIL_ASK_TITLE' => function(array $values) { return __('PROJECT') . ' - Help Center Question'; },
    'MAIL_ASK' => function(array $values) {
        $text = '<u>Ticket ID #'.$values[3].'</u>   
        '.$values[0].' ('.$values[1].') asked this question:
        <p style="font-weight: bold">'.$values[2].'</p>
        ';
        return $text;
    },
    'MAIL_DUNNING_TITLE' => function(array $values) {
        $number = $values[0];
        $title = __('PROJECT') . ' - Payment reminder';
        switch ($number):
            case 2: case 3: case 4: $title = ($number - 1) . '. dunning letter - Invoice not paid'; break;
        endswitch;
        $output = $title;
        return $output;
    },
    'MAIL_DUNNING' => function(array $values) {
        $number = $values[0];
        $prename = $values[1];
        $surname = $values[2];
        $gender = $values[3];
        $date = $values[4];
        $time = $values[5];
        $ref = $values[6];
        $percent_value = PRICE * 0.19;
        $calc = PRICE - $percent_value;

        switch ($number):
            case 1:
                $date_end = date('d.m.Y', strtotime($date . " +14 days"));
                $text = 'send you the first dunning letter.';
            break;
            case 2:
                $date_end = date('d.m.Y', strtotime($date . " +28 days"));
                $text = 'send you the second dunning letter.';
            break;
            case 3:
                $date_end = date('d.m.Y', strtotime($date . " +28 days"));
                $text = 'send you the third dunning letter.';
            break;
            case 4:
                $date_end = date('d.m.Y', strtotime($date . " +28 days"));
                $text = 'initiate legal proceedings against you.';
            break;
        endswitch;
        $costs = null;
        $total = PRICE;
        if ($number > 1) {
            $text .= '
            With dispatch of our dunning you will receive additional dunning fees and default charges 
            (arrears in the amount of 4.12% according to § 288 par. 5 BGB).<br /><br />
            <strong>We will charge you the costs of the order and default interest additionally  
            if you do not comply with this payment date. 
            After expiration of the third dunning, we will take legal steps against you,
            which is why we urgently recommend to settle the bill.
            </strong>';
        }
        if ($number > 2) {
            $fee = PRICE * 0.0412;
            $total += 5;
            $total += $fee;
            $costs .= "
            <tr><td width='24%'><strong>Dunning fee:</strong></td><td width='76%'>"._n(5)."</td></tr>
            <tr><td width='24%'><strong>Default charges (4,12%):</strong></td><td width='76%'>"._n($fee)."</td></tr>";
        }

        $title = 'Mr.';
        if ($gender != 1) $title = 'Mrs.';
        if (!empty($surname) && !empty($prename)) {
            if (!empty($surname)) $title .= ' ' . $surname;
            else $title .= ' ' . $prename;
        } else {
            $title = 'Sir';
            if ($gender != 1) $title = 'Madam';
        }

        $output = "Dear ".$title.",
        <br /><br />
        You have placed an order for our job placement service as a game tester at <strong>".$date." (".$time.")</strong>. 
        You have made a legally binding purchase agreement (in accord with § 312j par. 2 BGB)   
        by clicking the button \"Pay Now\".
        So far we have not been able to determine your payment. <br />
        <br />
        Therefore, we kindly ask you to settle this invoice amounting "._n(PRICE)." until
        <strong><u>".$date_end."</u></strong> before we have to ".$text."
        <br /><br /><br />
        Please use the following bank account details to pay the invoice:        
        </p>
            <div style='border-top: 1px solid #cccccc; margin-top: 15px'>&nbsp;</div>        
            ".banking($ref, 1)."
            <br />
            ".order_calc($total)."
        <p>
        Please ignore this letter if you have already made the payment in the meantime.";

        return $output;
    },
    'MAIL_ERROR_TITLE' => function(array $values) { return __('PROJECT') . ' - Error occured'; },
    'MAIL_ERROR' => function(array $values) {
        $text = 'This error occured:<br />
        QUERY: '.$values[0].'<br />
        ERROR: '.$values[1].'<br />
        SESS_ID: '.$values[2].'<br />
        ADDRESS: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'        
        ';
        return $text;
    },
    'MAIL_STEAMPAY_TITLE' => function(array $values) { return __('PROJECT') . ' - Unlock with Steam gift card'; },
    'MAIL_STEAMPAY' => function(array $values) {
        $text = ''.$values[0].' ('.$values[1].') entered the following Steam gift card code:
        <p style="font-weight: bold">'.$values[2].'</p>
        ';

        return $text;
    },
    'MAIL_ASK_COPY_TITLE' => function(array $values) { return __('PROJECT') . ' - Your Help Center Question'; },
    'MAIL_ASK_COPY' => function(array $values) {
        $text = '
        Hello '.$values[0].',<br />
        <br /> 
        thank you for your question. You just asked this question (Ticket ID #'.$values[3].') in our Help Center:
        <br />
        <p style="font-weight: bold">'.$values[2].'</p>
        <br />
        Please note that we can\'t reply to questions that have already been answered in our Help Center. 
        We will process your request as quickly as possible. Due to a large volume of requests, this may take some time.     
        ';


        return $text;
    },
    'MAIL_EMAIL_CHANGED_TITLE' => function(array $values) { return 'Email address change successful'; },
    'MAIL_PASS_CHANGED_TITLE' => function(array $values) { return 'Password change successful'; },
    'MAIL_EMAIL_CHANGED' => function(array $values) {
        return 'Hello '.$values[0].',<br /><br />
	    you receive this email as a confirmation that you changed your email address. 
	    You can use your new email address to login from now on.<br /><br />
	    Please contact us immediately if you didn\'t request this change to protect your account.';
    },
    'MAIL_PASS_CHANGED' => function(array $values) {
        return 'Hello '.$values[0].',<br /><br />
	    you receive this email as a confirmation that you changed your password. 
	    You can use your new email address to login from now on.<br /><br />
	    Please contact us immediately if you didn\'t request this change to protect your account.';
    },
    'MAIL_NOTIFY_TITLE' => function(array $values) { return __('PROJECT') .  ' - Notification'; },
    'MAIL_NOTIFY' => function(array $values) {
        $output = null;
        if (is_array($values)) {
            foreach($values as $v) {
                $output .= $v . '<br />';
            }
        }
        return $output;
    },
    'MAIL_APPLICATION_TITLE' => function(array $values) {
        $profession = strtoupper($values[0]);
        return 'Bewerbungen als '.__('PROFESSION_'.$profession).'';
    },
    'MAIL_APPLICATION' => function(array $values) {
        $profession = strtoupper($values[0]);
        $job_ad = $values[1];
        $content = $values[2];

        $text = '
        <div>
        Sehr geehrte Damen und Herren,<br />
        <br /> 
        bezüglich Ihrer Stellenanzeige <strong>'.$job_ad.'</strong> möchten wir Ihnen gerne 
        folgende '.__('PROFESSION_'.$profession).' vorstellen 
        und freuen uns, wenn Sie diese Bewerbungen berücksichtigen.<br />
        <br />
        Wir haben diese Bewerberprofile manuell gründlich geprüft und sprechen hiermit unsere offizielle Empfehlung für diese aus. 
        Jeder Bewerber hat eine Leseprobe für Sie vorbereitet:<br />
        <br />
        <hr style="margin-bottom: 20px" />
        '.$content.'
        <hr style="margin-top: 20px" />
        <br />
        Ich danke Ihnen im Voraus für die Bearbeitung dieser Bewerbungen und freue mich über Ihre Rückmeldung.<br />
        <br /><br />
        Mit freundlichen Grüßen,<br />
        <br />
        '.__('SERVICE_NAMES')[0].'<br />
        '.__('PROJECT').' Personalabteilung</div>';

        return $text;
    },
    'MAIL_BYE_FORMAL' => '<br/>Kind regards,<br /><br />
	The '.$project.' Team<br />
	<a href="'.ROOT.'" target="_blank" style="font-family:Arial;color: #96b840; font-weight: bold; font-style: normal">'.ROOT_WWW.'</a>',
    'MAIL_BYE' => 'We hope you enjoy your stay on '.__('PROJECT').'!
	<br /><br />Kind regards,<br /><br />
	Your '.__('PROJECT').' Team<br />
	<a href="'.ROOT.'" target="_blank" style="font-family:Arial; color: #96b840; font-weight: bold; font-style: normal">'.ROOT_WWW.'</a>',
    'MAIL_ADRESS' => CONTACT_EMAIL,
    'MAIL_FOOTER_TEXT' => '
    International job placement service for premium job offers. This service has been established with technical solutions of the JobSpace24 network.<br />
    <a href="'.ROOT.'imprint/" target="_blank">Imprint</a> &middot;
    <a href="'.ROOT.'privacy/" target="_blank">Privacy Policy</a> &middot;
    <a href="'.ROOT.'termsofservice/" target="_blank">Terms of Service</a><br />
    ',
    'CODE_INFO' => 'If you haven\'t received a code you can <a href="#modal-lost">click here</a>,
    to get a new one by email.'
    ];