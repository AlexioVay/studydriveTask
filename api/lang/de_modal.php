<?php
return [
    'MODAL_ORDER_PLACED' => 'Deine Buchung ist erfolgreich bei uns eingegangen. Wir haben dir die Details an deine E-Mail-Adresse gesendet.',
    'MODAL_CHECK_INBOX' => 'Bitte überprüfe deinen E-Mail-Posteingang.',
    'MODAL_ACCOUNT_ACTIVATED' => 'Dein Account wurde erfolgreich aktiviert.',
    'MODAL_PASSWORD_RECOVERY' => 'Dir wurde zur Passwort-Wiederherstellung eine E-Mail zugeschickt.',
    'MODAL_CHANGES_SAVED' => 'Die Änderungen wurden erfolgreich gespeichert.',
    'MODAL_PASSWORD_SAVED' => 'Das neue Passwort wurde erfolgreich gespeichert.',
    'S9' => 'Zahlung erfolgreich', // Todo: Bezeichnung ändern, wenn man App updated

    'MODAL_ERROR_REGISTRATION' => "Nur angemeldete Mitglieder können diese Funktion nutzen. 
    <a href='".ROOT."signup/1'>Melde dich jetzt sekundenschnell an</a> oder <a href='#modal-login'>logge dich ein</a>, 
    falls du bereits einen Account besitzt.",
    'MODAL_ERROR_PAYPAL' => "Bei der Zahlung mit PayPal ist ein Fehler aufgetreten. Bitte versuche es erneut oder wähle eine andere Zahlungsmethode aus, falls der Fehler weiterhin auftreten sollte.",
    'MODAL_ERROR_ACCESS' => "Du hast keinen Zugang zu diesem Bereich, da du über keine Administrations-Rechte verfügst.",
    'MODAL_ERROR_FACEBOOK' => "Der Verbindung zu unserer Facebook App wurde nicht zugestimmt. Bitte wiederhole den Vorgang und stimme der Verbindung unserer Facebook App zu.",
    'MODAL_ERROR_OCCURED' => 'Ein unerwarteter Fehler ist aufgetreten. Sollte dieser Fehler bzw. diese Fehlermeldung erneut erscheinen, bitten wir dich darum, 
    eine genaue Beschreibung an <a href="mailto:'.CONTACT_EMAIL.'">'.CONTACT_EMAIL.'</a> zu senden, 
    wie dieser Fehler zustande kam. 
    Dies hilft uns den Fehler nachzuvollziehen und zu beheben.',

    'MODAL_TERMSOFSERVICE' => 'Allgemeine Geschäftsbedingungen',
    'MODAL_PRIVACY' => 'Datenschutzbestimmungen',
    'MODAL_LOGIN' => __('PROJECT') .' Login',
    'MODAL_LOST' => 'Passwort zurücksetzen',
    'MODAL_VERIFY' => 'Neues Passwort setzen',
    'MODAL_SETTINGS' => 'Einstellungen',
    'MODAL_SAVE' => 'Wird gespeichert...',
    'MODAL_DELETING_ACCOUNT' => 'Account wird gelöscht...',
    'MODAL_LOGGING_IN' => 'Du wirst eingeloggt...',
    'MODAL_WE_REPLY_SOON' => 'Vielen Dank! Wir werden deine Anfrage bearbeiten...',
    'MODAL_ERROR' => 'Fehler',
    'MODAL_VERIFY_DECLINE_OFFER' => 'Willst du dieses Jobangebot wirklich ablehnen?',
    'MODAL_PLEASE_WAIT' => 'Bitte warten...',
    'MODAL_VERIFY_QUEUE' => 'Dein Code wird überprüft.',
    'MODAL_ORDER_NOT_FOUND' => 'Auftragsnummer nicht gefunden oder bereits vermittelt.',
    'MODAL_PAYMENT' => 'Zahlungs-Informationen',
    'MODAL_PAYMENT_TEXT' => function($x) {
        $hash = $x[0];

        $body = '
        <p>Dein Auftrag zur Vermittlung '.__('JOB_AS').' ist erfolgreich bei uns eingegangen. Sobald wir deinen Zahlungseingang feststellen, wird deine Teilnahme sofort bestätigt und die
        offizielle Vermittlung '.__('JOB_AS').' freigegeben.
        </p>
        <div class="box-green mt20 mb20">
        Tipp: Sende deinen Überweisungsbeleg an <a href="mailto:zahlung@'.ROOT_SHORT.'">zahlung@'.ROOT_SHORT.'</a> zu, um sofort freigeschaltet zu werden.
        </div>
        <p>
        Bitte überweise <strong><u>innerhalb von 14 Tagen</u></strong> den offenen Betrag
        in Höhe von <strong>'._n(PRICE).'</strong>
        auf folgendes Bankkonto:
        </p>
        '.banking($hash['purpose']).'
        <p class="f09 grey">
        Solltest du Fragen zu deinem Auftrag haben, verwende bitte eine unserer Kontaktmöglichkeiten, um uns zu erreichen.
        Wir werden uns anschließend schnellstmöglich mit dir in Verbindung setzen.
        </p>';

        return $body;
    },
    'MODAL_STEAMPAY' => 'Zahlung mit Steam-Guthabenkarte',
    'MODAL_STEAMPAY_TEXT' => function($x) {
        $body = '
        <p>Die Zahlung mit Steam-Guthaben wird von unseren Mitgliedern besonders geschätzt, 
        da Steam-Guthabenkarten in vielen Geschäften gegen Barzahlung erworben werden können.<br />
        Bitte gib zur sofortigen Freischaltung deines Profils einfach den freigerubbelten Code deiner Steam-Guthabenkarte in das folgende Textfeld ein: 
        </p>
        <input class="mt15" type="text" name="code" placeholder="Code deiner Steam-Guthabenkarte" />
        <p class="mb5 mt10">
        Bitte beachte, dass der Code exakt so eingegeben werden muss, wie er auf deiner Steam-Guthabenkarte steht (inklusive Minuszeichen).
        </p>
        <div class="box-green mt20 mb20">
        Hinweis: Steam-Guthabenkarten sind in Deutschland z.B. bei DM, Rewe, MediaMarkt, GameStop oder Saturn erhältlich.
        <div class="pt10 pb15">
            <img src="'.ROOT.'img/dm.svg" width="30" height="30" class="mr5" />
            <img src="'.ROOT.'img/media_markt.svg" width="90" height="30" class="mr5" />
            <img src="'.ROOT.'img/rewe.svg" width="40" height="35" class="mr7" />
            <img src="'.ROOT.'img/rossmann.svg" width="80" height="38" class="mr7" />
            <img src="'.ROOT.'img/gamestop.svg" width="80" height="38" />
        </div>         
        <a href="https://support.steampowered.com/kb_article.php?ref=1193-wlxv-6514&l=german" target="_blank">Klicke hier</a>, um  
        über weitere Einkaufsmöglichkeiten der Steam-Guthabenkarte in anderen Ländern zu erfahren.
        </div>
        <p class="f09 grey">
        Solltest du Fragen zu deinem Auftrag haben, verwende bitte die Kontaktmöglichkeit im <a href="'.ROOT.'help/">Hilfecenter</a>, um uns zu erreichen.
        Wir werden uns anschließend schnellstmöglich mit dir in Verbindung setzen.
        </p>';

        return $body;
    },
    'MODAL_LOCKED' => 'Anmeldung erforderlich',
    'MODAL_LOCKED_TEXT' => function($x) {
        $body = '
        <p>Die Seite oder Funktion, die du aufrufen wolltest, ist nur für angemeldete Mitglieder sichtbar. 
        Bitte melde dich an oder <a href="'.ROOT.'signup">registriere dich jetzt</a>, 
        um Zugang zu diesem Bereich zu erhalten.</p>';

        return $body;
    },
    'MODAL_DIRECTDEBIT' => 'Lastschrift wird vorgenommen',
    'MODAL_DIRECTDEBIT_TEXT' => function($x) {
        $body = '
        <p>Vielen Dank für deinen Auftrag. Wir buchen die Vermittlungsgebühr innerhalb der 
        nächsten 1-3 Werktage von deinem Bankkonto ab.<br />
        Sobald wir deinen Zahlungseingang feststellen, 
        wirst du sofort '.__('JOB_AS').' freigeschaltet und darüber per E-Mail benachrichtigt.</p>';

        return $body;
    },
    'MODAL_ACTIVATE' => 'Aktivierung des Accounts',
    'MODAL_ACTIVATE_RESEND' => 'Aktivierung des Accounts anfordern',
    'MODAL_ACTIVATE_SUCCESS' => 'Aktivierung des Accounts erfolgreich!',
    'MODAL_ACTIVATE_TEXT' => function($x) {
        $text = 'Dein Account wurde bereits bestätigt.';
        if (!$x[0]) $text = 'Dein Bestätigungslink ist leider ungültig, da der Bestätigungslink abgelaufen ist.';
        $output = '<p class="mb10">'.$text.'</p>';

        if (!$x[0])
        $output .= '
        <p class="f09 grey-normal">
        Du kannst dir jederzeit einen <a href="#modal-activate-resend">neuen Bestätigungslink zusenden</a> lassen.
        </p>';

        return $output;
    },
    'MODAL_ACTIVATE_RESEND_TEXT' => function($x) {
        $output = '<p class="mb5">Dir wird ein neuer Bestätigungslink zugeschickt...</p>';

        return $output;
    },
    'MODAL_EXAMPLE' => '100% Transparenz',
    'MODAL_EXAMPLE_TEXT' => function($x) {
        return '
        <p class="mb10">
        Dieser Bereich soll dir nur beispielhaft aufzeigen, wie es aussehen würde,
        wenn du Jobangebote durch uns erhältst.
        </p>
        <p class="f09 grey">
        Bitte scrolle weiter runter, um dich '.__('JOB_AS').' vermitteln zu lassen.
        </p>';
    },
];