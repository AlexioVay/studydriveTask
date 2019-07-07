<?php
return [
    'MAIL_ACTIVATE_TITLE' => function(array $values) { return __('PROJECT') . ' - Neuer Bestätigungslink'; },
    'MAIL_ACTIVATE' => function(array $values) { return 'Hallo '.$values[0].',
	<br /><br />
	hiermit erhältst du einen neuen Bestätigungslink, um deinen Account freizuschalten:<br />
	<a href="'.ROOT.'#modal-activate-'.$values[1].'-'.$values[2].'">
	Bitte hier klicken</a> '; },
    'MAIL_ACCEPT_TITLE' => function(array $values) { return __('PROJECT') . ' - Bestätigung zur Job-Vermittlung'; },
    'MAIL_ACCEPT' => function(array $values) { return 'Hallo '.$values[0].',
	<br /><br />
	hiermit erhältst du die Bestätigung, das Jobangebot von <strong>'.$values[1].'</strong> angenommen zu haben. 
	Du kannst dich zurücklehnen und entspannen während wir uns mit dem Unternehmen in Verbindung setzen. 
	Du erhältst bald weitere Informationen.'; },
    'MAIL_DECLINE_TITLE' => function(array $values) { return __('PROJECT') . ' - Ablehnung der Job-Vermittlung'; },
    'MAIL_DECLINE' => function(array $values) { return 'Hallo '.$values[0].',
	<br /><br />
	hiermit erhältst du die Bestätigung, das Jobangebot von <strong>'.$values[1].'</strong> abgelehnt zu haben. 
	Wir bedauern deine Entscheidung und hoffen, dass du uns mitteilen kannst, 
	was dir an diesem Jobangebot nicht gefallen hat,  
	damit wir unsere Bemühungen um ein Jobangebot für dich in Zukunft verbessern können.'; },
    'MAIL_REGISTER_TITLE' => function(array $values) { return __('PROJECT') . ' - Deine Registrierung'; },
    'MAIL_REGISTER' => function(array $values) { return 'Hallo '.$values[0].',
	<br /><br />
	vielen Dank für deine Registrierung bei '.__('PROJECT').'!<br />
	Bitte bestätige deinen Account mit diesem Bestätigungslink:
	<a href="'.ROOT.'#modal-activate-'.$values[1].'-'.$values[2].'">
	Bitte hier klicken</a> '; },
    'MAIL_LOST_TITLE' => function(array $values) { return __('PROJECT') . ' - Passwort angefordert'; },
    'MAIL_LOST' => function(array $values) { return 'Hallo '.$values[0].',
	<br /><br />
	du hast dein Passwort für '.__('PROJECT').' angefordert. Aus Sicherheitsgründen ist es erforderlich,
	dass du auf den folgenden Link klickst,
	um deine Identität zu bestätigen:
	<br />
	<a href="'.ROOT.'#modal-verify-'.$values[1].'-'.$values[2].'" target="_blank">Bitte hier klicken</a>'; },
    'MAIL_DD_TITLE' => function(array $values) { return __('PROJECT') . ' - Auftragsbestätigung'; },
    'MAIL_DD' => function(array $values) {
        $percent_value = $values[1]*0.19;
        $calc = $values[1]-$percent_value;

        $text = '
        Hallo '.$values[0].',<br />
        <br />
        vielen Dank für deinen Auftrag als Spieletester vermittelt zu werden. Wir buchen die Vermittlungsgebühr in Höhe von 
        '._n($values[1]).' innerhalb der nächsten 1-3 Werktage von deinem Bankkonto ab.
        </p><br />
        <br />
        '.order_calc($values[1]).'
        <p>
        Deine Auftragsnummer lautet: <strong>'.$values[2].'</strong>.
        Bitte gib diese Auftragsnummer bei Fragen zu deinem Auftrag zur schnelleren Zuordnung und
        Bearbeitung immer an bzw. halte diese vor einer Kontaktaufnahme mit uns bereit.      
        ';

        return $text;
    },
    'MAIL_ASK_TITLE' => function(array $values) { return __('PROJECT') . ' - Frage von '.$values[0].' im Hilfecenter'; },
    'MAIL_ASK' => function(array $values) {
        $text = '<u>Ticket ID #'.$values[3].'</u>
        <br />
        '.$values[0].' ('.$values[1].') hat folgende Frage im Hilfecenter gestellt:
        <p style="font-weight: bold">'.$values[2].'</p>
        ';

        return $text;
    },
    'MAIL_DUNNING_TITLE' => function(array $values) {
        $number = $values[0];
        $title = __('PROJECT') . ' - Zahlungserinnerung';
        switch ($number):
            case 2: case 3: case 4: $title = ($number - 1) . '. Mahnung - Rechnung nicht bezahlt'; break;
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
                $text = 'Ihnen die erste Mahnung zusenden müssen.';
            break;
            case 2:
                $date_end = date('d.m.Y', strtotime($date . " +28 days"));
                $text = 'Ihnen die zweite Mahnung zusenden müssen.';
            break;
            case 3:
                $date_end = date('d.m.Y', strtotime($date . " +28 days"));
                $text = 'Ihnen die dritte Mahnung zusenden müssen.';
            break;
            case 4:
                $date_end = date('d.m.Y', strtotime($date . " +28 days"));
                $text = 'gerichtliche Schritte gegen Sie einleiten müssen.';
            break;
        endswitch;
        $costs = null;
        $total = PRICE;
        if ($number > 1) {
            $text .= '
            Mit Versand unserer Mahnungen werden Ihnen zusätzliche Mahngebühren und Verzugszinsen 
            (Verzugspauschale i.H.v. 4,12% gemäß § 288 Abs. 5 BGB) in Rechnung gestellt.<br /><br />
            <strong>Falls Sie diesen Zahlungstermin nicht einhalten, 
            werden wir Ihnen die Kosten des Mahnverfahrens und Verzugszinsen in Rechnung stellen. 
            Nach Fristablauf der 3. Mahnung werden wir gerichtliche Schritte gegen Sie einleiten,
            weshalb wir dringend eine zeitnahe Begleichung der Rechnung empfehlen.
            </strong>';
        }
        if ($number > 2) {
            $fee = PRICE * 0.0412;
            $total += 5;
            $total += $fee;
            $costs .= "
            <tr><td width='24%'><strong>Mahngebühren:</strong></td><td width='76%'>"._n(5)."</td></tr>
            <tr><td width='24%'><strong>Verzugszinsen (4,12%):</strong></td><td width='76%'>"._n($fee)."</td></tr>";
        }

        $title = 'geehrter Herr';
        if ($gender != 1) $title = 'geehrte Frau';
        if (!empty($surname) && !empty($prename)) {
            if (!empty($surname)) $title .= ' ' . $surname;
            else $title .= ' ' . $prename;
        } else {
            $title = 'geehrter Kunde';
            if ($gender != 1) $title = 'geehrte Kundin';
        }

        $output = "Sehr ".$title.",
        <br /><br />
        Sie haben am <strong>".$date." (".$time." Uhr)</strong> einen zahlungspflichtigen
        Auftrag zur Vermittlung als Spieletester bei uns aufgegeben und sind mit dem Klick
        auf die Schaltfläche \"Zahlen\" einen rechtskräftigen Kaufvertrag (gemäß § 312j Abs. 2 BGB) mit uns eingegangen. 
        Bisher haben wir Ihren Zahlungseingang jedoch nicht feststellen können.<br />
        <br />
        Wir bitten Sie daher darum, den offenen Rechnungsbetrag in Höhe von "._n(PRICE)." bis zum 
        <strong><u>".$date_end."</u></strong> zu begleichen, bevor wir ".$text."       
        <br /><br /><br />
        Bitte verwenden Sie die folgenden Kontodaten, um die Überweisung zu tätigen:
        </p>
            <div style='border-top: 1px solid #cccccc; margin-top: 15px'>&nbsp;</div>        
            ".banking($ref, 1)."
            <br />
            ".order_calc($total)."
        <p>
        Falls Sie die Zahlung zwischenzeitlich bereits veranlasst haben, bitten wir Sie, dieses Schreiben als gegendstandslos zu betrachten.";

        return $output;
    },
    'MAIL_ERROR_TITLE' => function(array $values) { return __('PROJECT') . ' - Fehler aufgetreten'; },
    'MAIL_ERROR' => function(array $values) {
        $text = 'Folgender Fehler ist aufgetreten:<br />
        QUERY: '.$values[0].'<br />
        ERROR: '.$values[1].'<br />
        SESS_ID: '.$values[2].'<br />
        ADDRESS: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'
        ';
        return $text;
    },
    'MAIL_STEAMPAY_TITLE' => function(array $values) { return __('PROJECT') . ' - Freischaltung durch Steamguthabenkarte'; },
    'MAIL_STEAMPAY' => function(array $values) {
        $text = ''.$values[0].' ('.$values[1].') hat folgenden Steamguthabenkarten-Code angegeben:
        <p style="font-weight: bold">'.$values[2].'</p>
        ';

        return $text;
    },

    'MAIL_ASK_COPY_TITLE' => function(array $values) { return __('PROJECT') . ' - Deine Frage im Hilfecenter'; },
    'MAIL_ASK_COPY' => function(array $values) {
        $text = '
        Hallo '.$values[0].',<br />
        <br /> 
        vielen Dank für deine Anfrage. Du hast soeben folgende Frage (Ticket ID #'.$values[3].') in unserem Hilfecenter gestellt:
        <br />
        <p style="font-weight: bold">'.$values[2].'</p>
        <br />
        Bitte beachte, dass wir bereits im Hilfecenter beantwortete Fragen nicht bearbeiten können. 
        Wir bemühen uns, deine Anfrage schnellstmöglich zu bearbeiten und bitten um Verständnis, 
        dass dies aufgrund vieler Anfragen ggf. etwas Zeit in Anspruch nimmt.
        ';

        return $text;
    },
    'MAIL_EMAIL_CHANGED_TITLE' => function(array $values) { return 'E-Mail Adresse erfolgreich geändert'; },
    'MAIL_EMAIL_CHANGED' => function(array $values) { return
    'Hallo '.$values[0].',<br /><br />
	du erhältst diese E-Mail, um dir zu bestätigen, dass die Änderung deiner E-Mail Adresse erfolgreich war.  
	Du kannst dich ab sofort mit deiner neuen E-Mail Adresse bei uns einloggen.';
    },
    'MAIL_PASS_CHANGED_TITLE' => function(array $values) { return 'Passwort erfolgreich geändert'; },
    'MAIL_PASS_CHANGED' => function(array $values) { return
    'Hallo '.$values[0].',<br /><br />
	du erhältst diese E-Mail, um dir zu bestätigen, dass die Änderung deines Passworts erfolgreich war.  
	Du kannst dich ab sofort mit deinem neuen Passwort bei uns einloggen.';
    },
    'MAIL_NOTIFY_TITLE' => function(array $values) { return __('PROJECT') .  ' - Benachrichtigung'; },
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
    'MAIL_BYE_FORMAL' => '<br/>Mit freundlichen Grüßen,<br /><br />
	Dein '.__('PROJECT').' Team<br />
	<a href="'.ROOT.'" target="_blank" style="font-family:Arial;color: #96b840; font-weight: bold; font-style: normal">'.ROOT_WWW.'</a>',
    'MAIL_BYE' => 'Wir wünschen dir weiterhin einen angenehmen Aufenthalt bei uns!
	<br /><br /><br />Herzliche Grüße,<br /><br />
	Dein '.__('PROJECT').' Team<br />
	<a href="'.ROOT.'" target="_blank" style="font-family:Arial;color: #96b840; font-weight: bold; font-style: normal">'.ROOT_WWW.'</a>',
    'MAIL_FOOTER_TEXT' => '
    Internationale Vermittlung von erstklassigen Jobangeboten unter Verwendung 
    technischer Lösungen und Schnittstellen vom globalen JobSpace24 Netzwerk.<br />
    <a href="'.ROOT.'imprint/" target="_blank">Impressum</a> &middot;
    <a href="'.ROOT.'privacy/" target="_blank">Datenschutzbestimmungen</a> &middot;
    <a href="'.ROOT.'termsofservice/" target="_blank">Allgemeine Geschäftsbedingungen</a><br />
    ',
    'MAIL_ADRESS' => CONTACT_EMAIL,
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
            $output = __('PROJECT') . " - Auftragsbestätigung";
        } else {
            $output = __('PROJECT') . " - Zahlungsbestätigung";
        }
        return $output;
    },
    'MAIL_ORDER' => function(array $values) {
        $purpose = "".$values[3]." / ".$values[5]."";
        if ($values[2] == 'Pending') {
            $status = "Die Vermittlung ist derzeit <em>noch nicht möglich</em>, da deine Zahlung noch nicht bestätigt wurde.
            Sobald dein Zahlungseingang festgestellt wird, wird dein Profil sofort für alle Auftraggeber freigeschaltet und deine Vermittlung aktiviert.";
            // Case Bank transfer:
            if ($values[1] == 'bt') $status .= "<br /><br />
            <strong>Eine sofortige Freischaltung ist auch durch Zusendung vom Überweisungsbeleg an zahlung@".ROOT_SHORT." möglich.</strong><br /><br /><br />
            Bitte überweise <strong><u>innerhalb von 14 Tagen</u></strong> den offenen Betrag in Höhe von 
            <strong>"._n($values[4])."</strong> auf folgendes Konto:<br />
            <br />
            <div style='border-top: 1px solid #cccccc;'>&nbsp;</div>
            ".banking($purpose,1)."";
            // Case SteamPay:
            if ($values[1] == 'steam') $status .= "
            <br /><br />
            Bitte trage <strong><u>innerhalb von 14 Tagen</u></strong> den gültigen Code einer Steam-Guthabenkarte 
            in Höhe von <strong>"._n(PRICE)."</strong>  
            auf <a href='".ROOT."signup/3/#modal-steampay'>unserer Zahlungsseite</a> ein. 
            Du erhältst auf dieser Seite ebenfalls weitere Informationen, wo du eine Steam-Guthabenkarte gegen Barzahlung 
            in vielen Geschäften erwerben kannst.<br />";
        } else {
            $status = "Du wurdest erfolgreich ".__('JOB_AS')." in die Datenbank eingetragen.
            Dein Profil ist ab sofort für alle Auftraggeber sichtbar. Du wirst bei einer erfolgreichen Vermittlung sofort benachrichtigt.<br />";
        }
        $percent_value = $values[4]*0.19;
        $calc = $values[4]-$percent_value;

        $output = "Hallo ".$values[0].",
        <br /><br />
        vielen Dank für deinen Auftrag zur Vermittlung ".__('JOB_AS').".
        ".$status."
        <br />
        </p>
        ".order_calc($values[4])."
        <p>
        Deine Auftragsnummer lautet: <strong>".$values[5]."</strong>.
        Bitte gib diese Auftragsnummer bei Fragen zu deinem Auftrag zur schnelleren Zuordnung und
        Bearbeitung immer an bzw. halte diese vor einer Kontaktaufnahme mit uns bereit.";

        return $output;
    }
];