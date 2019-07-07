<?php
return [
    /* BASIC */
    # Datetime:
    'DAY' => 'Tag',
    'MONTH' => 'Monat',
    'YEAR' => 'Jahr',
    'TIME_PREFIX' => 'vor ',
    'TIME_NOW' => 'gerade eben',
    'TIME_SUFFIX' => '',
    'TIME_MONTHS' => [1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April', 5 => 'Mai', 6 => 'Juni', 7 => 'Juli',
    8 => 'August', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Dezember'],
    # General:
    'CONGRATS' => 'Herzlichen Glückwunsch',
    'LOADING' => 'Wird geladen...',
    'ADD_ENTRY' => 'Weiteren Eintrag hinzufügen',
    'ADMIN' => 'Administration',
    'SETTINGS' => 'Einstellungen',
    'COMPLETE_PROFILE' => 'Profil ausfüllen',
    'LOGOUT' => 'Ausloggen',
    'JOB_PLACEMENTS' => 'Vermittlungen',
    'AGENCIES' => 'Agenturen',
    'COUNTRIES' => 'Länder',
    'FULLSCREEN' => 'Vollbild',
    'YES' => 'Ja',
    'NO' => 'Nein',
    'PIMG' => 'Profilbild',
    'PHONE_NUMBER' => 'Handynummer',
    'PHONE_NUMBER_DESCRIPTION' => 'Wir können dich kostenlos über Jobangebote via SMS benachrichtigen.',
    'PHONE_NUMBER_COUNTRY_CODE' => 'Ländervorwahl',
    'PHONE_NUMBER_FULL' => 'Handynummer',
    'WORK' => 'Karriere',
    'OCCUPATION_TITLE' => 'Tätigkeit/Bezeichnung',
    'OCCUPATION_LOCATION' => 'Standort',
    'OCCUPATION_CURRENTLY' => 'Das ist meine aktuelle Tätigkeit',
    'OCCUPATION_COMPANY' => 'Firmenname',
    'OCCUPATION_POSITION' => 'Position',
    'OCCUPATION_TYPES' => ['Schüler','Auszubildender','Student','Angestellter','Selbstständig','Führungskraft','Arbeitslos'],
    'OCCUPATION_SINCE' => 'Seit (Monat/Jahr)',
    'OCCUPATION_TO' => 'Bis (Monat/Jahr)',
    'PLEASE_SELECT' => 'Bitte auswählen',
    'PRICE' => 'Preis',
    'PRICE_TOTAL' => 'Gesamtpreis',
    'NET_PRICE' => 'Nettopreis',
    'VAT' => 'Zzgl. 19% MwSt.',
    'ACCOUNT_NAME' => __('PROJECT').' Banking',
    'ACCOUNT_NR' => 'Kontonummer',
    'BANK_CODE' => 'Bankleitzahl',
    'REFERENCE_LINE' => 'Verwendungszweck',
    # Footer:
    'IMPRINT' => 'Impressum',
    'IMPRINT_LEGAL_NOTE' => __('PROJECT').' ist ein amerikanisches Unternehmen, das weltweit Dienstleistungen anbietet. 
    Wir bitten daher darum, rechtliche Angelegenheiten bei besonders dringlichen Fällen vorerst an 
    <u>legal@'.ROOT_SHORT.'</u> in englischer Sprache zu senden, damit wir die Anfrage ohne  
    Übersetzungsarbeit schneller bearbeiten können.',
    'MAIN_LEGAL_NOTE' => 'Rechtliche Hinweise sind in der Seitenleiste aufzufinden.',
    'DATA_PROTECTION' => 'Datenschutz',
    'AGB' => 'AGB',
    # Input:
    'INPUT_TEXT' => 'Text verfassen...',
    'INPUT_QUESTION' => 'Anfrage senden',
    'INPUT_TOPIC' => 'Thema eingeben...',
    'INPUT_TITLE' => 'Titel eingeben...',
    'INPUT_VISIBLE' => 'Eingabe sichtbar machen',
    'INPUT_INVISIBLE' => 'Eingabe unkenntlich machen',
    'INPUT_QUESTION_SURE' => 'Ich bin mir darüber bewusst, 
    dass bereits im Hilfecenter beantwortete Fragen nicht bearbeitet werden können.',
    # Button:
    'INPUT_SEND' => 'Absenden',
    # Messages:
    'MSG_LOGOUT' => 'Du wirst ausgeloggt...',

    /* GUARANTEE */
    'GUARANTEE_TITLE' => 'Unser Garantieversprechen',
    'GUARANTEE_TEXT' => 'Wir haben diese Seite eingerichtet, um transparent über unsere Garantien und Gewährleistungen unserer Dienstleistungen zu informieren.  
    Gleichzeitig kannst du hier auch deine Mitgliedschaft bei Unzufriedenheit kündigen und rund um die Uhr dein Geld zurückfordern.',
    'WHY_FEE_TITLE' => 'Warum wird eine Freischaltungsgebühr erhoben?',
    'WHY_FEE_TEXT' => function($v) { return
    'Wir möchten gerne darüber informieren, warum wir eine Freischaltungsgebühr für unsere Dienstleistungen erheben.<br /> 
    Jobsuchende wissen, dass es viel Aufwand ist und Stress mit sich bringt, sich um die geeignete Stelle zu kümmern.  
    Die erforderlichen Unterlagen (Lebenslauf, Bewerbungsanschreiben, Zeugnisse, etc.) zusammenzustellen,  
    geeignete Stellenangebote rauszusuchen sowie professionell mit Unternehmen und Arbeitgebern zu kommunizieren  
    ist meist mühsam und zeitintensiv.
    <strong>Wir ersparen dir diese Schritte komplett</strong>, da wir durch das <a href="'.ROOT.'signup">Ausfüllen vom Anmeldeformular</a> alle benötigten Daten individuell 
    verpacken und damit ein einzigartiges Profil erstellen. Zusätzlich wirst du 
    <strong>Jobangebote nach deinen Interessen erhalten und von unseren langjährigen Kontakten profitieren</strong>, 
    mit denen wir regelmäßig Kontakt pflegen.<br />               
    Wir haben uns für diese Dienstleistungen dazu entschlossen, die kleine Freischaltungsgebühr i.H.v. <span class="dib">'._n($v[0]).'</span> zu erheben,  
    die wir automatisch nach der erfolgreichen Job-Vermittlung an unsere Mitglieder zurückzahlen und auch <strong>jederzeit bei Unzufriedenheit über 
    unsere 100%-Geld-Zurück-Garantie zurücküberwiesen.</strong>'; },
    'JOB_CHANCE_TITLE' => 'Realistische Chancen zur Job-Vermittlung',
    'JOB_CHANCE_TEXT' => function($v) {
    return 'Wir möchten an dieser Stelle über die Chancen zur Job-Vermittlung aufklären und besonders auf 
    unsere <strong>100%-Geld-Zurück-Garantie auf Lebenszeit</strong> aufmerksam machen, 
    die wir für die kleine Freischaltungsgebühr i.H.v. '._n(PRICE).' anbieten.<br />
    <br />
    Wir sind stets bemüht, uns ausführlich mit deinem Profil 
    auseinanderzusetzen und dich so gut es geht zu unterstützen. Dass ein Unternehmen oder Auftraggeber genau dich aussucht 
    und dein Profil interessant findet, liegt jedoch leider nicht in unserer Macht und ist <strong>letztendlich eine jeweils firmen-interne Entscheidung</strong>, 
    selbst wenn sich unsere Vermittlungs-Experten für unsere Mitglieder mühevoll einsetzen. 
    Eine feste Job-Vermittlung kann somit allgemein nicht ausnahmslos garantiert werden, da sie <strong>von Profil zu Profil abhängig</strong> ist. 
    Der aktuelle Berufsmarkt ändert sich tagtäglich und freie Stellen können entweder schnell vergeben sein oder aber die 
    Voraussetzungen treffen nicht genau 
    auf das individuelle '.__('PROJECT').' Profil zu.<br /> 
    <br />
    <strong>Du kannst dich jedoch durch die vielfältigen Einstellungsmöglichkeiten und mit deinen Angaben im Profil erheblich hervorheben</strong>, 
    um mehr Aufmerksamkeit zu erhalten. 
    Wir können eine besonders hohe Erfolgsquote verzeichnen, wenn  
    deine Leidenschaft und dein Engangement für den Beruf '.__('JOB_AS').' in deinem Profil erkennbar ist. Dies ist mit einem 
    <strong>ausführlichen Testbericht, vollständig ausgefülltem Profil oder regelmäßiger Online-Präsenz</strong> (z.B. durch Streaming bei YouTube, Twitch, etc.) erreichbar.'; },
    'MONEY_BACK_TITLE' => '100% Geld-Zurück-Garantie',
    'MONEY_BACK_TEXT' => 'Wir sind davon überzeugt, dass ein guter Kundenservice in der heutigen Zeit das wichtigste Merkmal 
    einer guten Dienstleistung ist.
    Wir bieten daher <strong>allen Mitgliedern 
    eine Rückerstattung der Freischaltungsgebühr</strong> an, selbst wenn das Auftragsdatum  
    die gesetzliche 14-tägige Widerrufsfrist übersteigt.<br />
    <br />
    Das bedeutet, dass du <strong>zu jeder Zeit</strong> dein Geld zurückbekommst, wenn du nicht zufrieden sein solltest. 
    <strong>Das macht die '.__('PROJECT').' Erfahrungen als Mitglied komplett risikofrei und bedenkenlos.</strong><br />
    Du findest auf dieser Seite den Punkt "Mitgliedschaft kündigen" und den Button "Unwiderrufliche Löschung": Wenn du 
    diesen Button klickst, werden deine Daten komplett gelöscht und gleichzeitig auch die Rückerstattung 
    deiner gezahlten Freischaltungsgebühr veranlasst. 
    <span class="grey-normal f09 mt20 db">Die Rückerstattung kann je nach Zahlungsart bis zu 14 Werktage in Anspruch nehmen. 
    Eine PayPal-Zahlung nimmt nur bis zu maximal 2 Werktage in Anspruch. 
    In unseren <a href="'.ROOT.'termsofservice">Allgemeinen Geschäftsbedingungen</a> findest du alle weiteren Informationen dazu.
    </span>',
    'QUIT_MEMBERSHIP_TITLE' => 'Mitgliedschaft kündigen',
    'QUIT_MEMBERSHIP_TEXT' => 'Bei Kündigung deiner Mitgliedschaft werden <strong>alle Daten von dir permanent gelöscht</strong>. 
    Du wirst also für alle 
    Unternehmen und Interessenten aus unserer Datenbank entfernt und <strong>du kannst nicht mehr gefunden werden</strong>. Dies gilt auch für alle Partner-Netzwerke, 
    mit denen wir zusammenarbeiten.<br />
    Selbstverständlich erhältst du auch automatisch deine Freischaltungsgebühr zurück.',
    'QUIT_MEMBERSHIP_BUTTON' => 'Unwiderrufliche Löschung',

    /* ROOT */
    'BTN_ENTER_ADDRESS' => 'Adresse angeben',
    'REF_TITLE' => 'Mit Freunden zusammenarbeiten',
    'REF_EMPTY' => 'Die Namen deiner geworbenen Mitglieder würden hier aufgelistet werden.',
    'REF_INTRO_TEXT' => '
    Deine Empfehlung vergrößert nicht nur unsere Plattform,  
    sondern ermöglicht dir auch eine <u>Zusammenarbeit mit deinen Freunden</u>, für die wir uns zusätzlich einsetzen.',
    'REF_TEXT' => '
        Du verdienst <strong>'._n(5, true).' pro geworbenes Mitglied</strong>, 
        wenn du Freunde, Familie oder Bekannte wirbst, indem sie sich mit deinem persönlichen Werbelink
        <span class="dib fwB">'.ROOT_WWW.'/'.$_SESSION['uid'].'</span>
        bei uns anmelden und sich für die Vermittlung freischalten. 
    ',
    'PERSONAL_CODE' => 'Dein persönlicher Werbelink',
    'PERSONAL_FRIENDS' => 'Deine Empfehlungen',
    'SHARE' => 'Jetzt teilen',
    'EARNINGS' => 'Verdienst',
    'REFERRED' => 'Geworben',
    /* NAV */
    'NAV_REGISTER' => 'Anmeldung',
    'NAV_GUARANTEE' => 'Garantieversprechen',
    'NAV_NEWS' => 'Aktuelles',
    'NAV_RATINGS' => 'Bewertungen',
    'NAV_HELP' => 'Hilfecenter',
    /* FOOTER */
    '247_TITLE' => 'Wir sind für dich da',
    '247' => 'Wir sind rund um die Uhr für dich da! Verwende entweder unser <a href="'.ROOT.'help">Hilfecenter</a> oder 
    besuche unser Social Media:',

    'REFUND_TITLE' => '100% Geld-Zurück-Garantie',
    'REFUND_TEXT' => 'Wir garantieren dir eine Rückerstattung für jeglich anfallende Gebühren',

    /* VALIDATION */
    /* Messages */
    'OK_SUGGESTION' => 'Vielen Dank! Wir haben deinen Vorschlag erhalten.',
    'OK_ADD_NEWS' => 'Vielen Dank! Du hast die News erfolgreich eingereicht.',
    'OK_FOLLOW_YES' => 'Du folgst diesem Thema ab sofort.',
    'OK_FOLLOW_NO' => 'Du folgst diesem Thema nicht mehr.',
    'OK_BETA_PARTICIPATE_YES' => 'Wir versuchen dir einen freien Platz zu sichern.',
    'OK_BETA_PARTICIPATE_NO' => 'Wir haben dich wieder ausgetragen.',
    'OK_TOPIC_RATING_YES' => function($v) { return 'Dich interessiert '.$v[0].'.'; },
    'OK_TOPIC_RATING_NO' => function($v) { return 'Dich interessiert '.$v[0].' nicht.'; },
    /* --- Account --- */
    'INACTIVE_TITLE' => 'Bitte beachten',
    'INACTIVE_TEXT' => function($values) {
        if ($values[0] < 2) $reasons = __('INACTIVE_REASON'); else $reasons = __('INACTIVE_REASONS');
        return 'Wir können dich aus '.$reasons.' nicht freischalten:';
    },
    'INACTIVE_REASON' => 'folgendem Grund',
    'INACTIVE_REASONS' => 'folgenden Gründen',
    'REASON_COMPLETE' => 'Du hast deine Anmeldung noch nicht abgeschlossen',
    'REASON_ACTIVATE' => 'Dein Account wurde noch nicht aktiviert &ndash; <a href="#modal-activate">Jetzt aktivieren</a>',
    'REASON_PAYMENT' => 'Deine Teilnahme wurde noch nicht bestätigt',
    'REASON_USER_INFO' => 'Einige Angaben zur <a href="'.ROOT.'signup/2">Vervollständigung deines Profils</a> fehlen',
    'REASON_ADDRESS' => 'Du musst <a href="'.ROOT.'settings">deine Adresse angeben</a>, um Jobangebote in deiner Nähe zu erhalten<br />
    <span class="grey f09">Deine Adresse wird nicht öffentlich angezeigt.</span>',
    /* --- Admin --- */
    'VAL_ORDER_NOT_FOUND' => 'Die Auftragsnummer wurde nicht gefunden.',
    'VAL_ORDER_ALREADY_UNLOCKED' => function($x) {
        return 'Die Freischaltung hat bereits stattgefunden: '.timediff($x[0]).'. ('.$x[0].')';
    },
    /* API */
    'BALANCE_SHEET' => 'Bilanz',
    'RECORDS' => 'Rekorde',
    'RECORDS_LIFETIME' => 'Rekorde insgesamt',
    'MAX_DAILY_EARNING' => 'Tagesumsatz',
    'MAX_WEEKLY_EARNING' => 'Wochenumsatz',
    'MAX_MONTHLY_EARNING' => 'Monatsumsatz',
    'BEST_MONTH_LIFETIME' => 'Bester Monat',
    'CAL_WEEK' => 'KW',
    'SUM' => 'Summe',
    'DAILY' => 'Tägl.',
    /* --- NEWS --- */
    'META_NEWS_TITLE' => function($v) {
        return 'Werde '.$v[0].' '.__('JOB').' mit allen Neuigkeiten, Updates und Specials';
    },
    'META_NEWS_TITLE_BETA' => function($v) {
        return 'Freie Plätze zur '.$v[0].' Beta-Test Anmeldung: Release Demo inklusive Beta Key';
    },

    'TOPIC_TBA' => 'Unbekannt',
    'TOPIC_LIKE_RELEASED' => function($v) {
        return 'Willst du das Spiel <strong>'.$v['topic'].' kostenlos spielen</strong> und dafür Geld verdienen? 
        Werde jetzt '.__('JOB').' für Spiele wie <strong>'.$v['topic'].'</strong> oder andere beliebte Spiele deiner Wahl!';
    },
    'TOPIC_LIKE_UNRELEASED' => function($v) {
        return 'Willst du <strong>Zugang zum '.$v['topic'].' Beta-Test</strong> oder allgemein Spiele testen und dafür Geld verdienen? 
        Werde jetzt '.__('JOB').' für Spiele wie <strong>'.$v['topic'].'</strong> oder andere beliebte Spiele deiner Wahl!';
    },
    'TOPIC_LIKE_TBA' => function($v) {
        return 'Willst du das Spiel <strong>'.$v['topic'].' kostenlos spielen</strong>, sobald es erscheint oder allgemein Spiele testen und dafür Geld verdienen? 
        Werde jetzt '.__('JOB').' für Spiele wie <strong>'.$v['topic'].'</strong> oder andere beliebte Spiele deiner Wahl!';
    },
    'TOPIC_LIKE_COMPLETED' => function($v) {
        return 'Deine Jobangebote basieren auf Angaben deiner Interessen. 
        Interessierst du dich für <strong>'.$v['topic'].'</strong>? ';
    },
    'TOPIC_SIDEBAR_TITLE' => 'Zugang zu Neuveröffentlichungen',
    'TOPIC_SIDEBAR_TEXT' => function($v) {
        return 'Willst du Zugang zu bisher unveröffentlichten Spielen/DLCs, Beta-Tests oder kommenden Updates? 
        Werde jetzt Spieletester für Spiele wie '.$v['titles'].' oder andere beliebte Spiele deiner Wahl!';
    },
    'TOPIC_TOTAL_LIKES' => function($v) { return $v[0] . '% aller Mitglieder interessieren sich für '.$v[1].'.'; },
    'TOPIC_LIKE_TITLE' => function($v) { return 'Klicken, um Interesse für '.$v[0].' anzugeben'; },
    'TOPIC_DISLIKE_TITLE' => function($v) { return 'Klicken, um Desinteresse für '.$v[0].' anzugeben'; },

    'AUTHOR' => 'Autor',
    'SUGGESTION_COLLAPSE' => 'Thema vorschlagen',
    'SUGGESTION_ADD_NEWS' => 'News einreichen',
    'NEWS_EMPTY' => function($v) { return 'Es wurden keine kürzlich veröffentlichte Neuigkeiten zu '.$v[0].' gefunden. 
    Du kannst in Erwägung ziehen, 
    <a data-toggle="collapse" data-target="#addNews" class="suggestion">selbst eine News einzureichen</a>,  
    um hohe Anerkennung zu erhalten und tausende Leser zu erreichen. <strong>Besonders gut geschriebene News erhalten von uns 
    zusätzlich eine Auszeichnung</strong> und erhöhen deine Chancen auf begehrte Jobangebote '.__('JOB_AS').'.'; },
    'ADD_NEWS_DESCRIPTION' => function($v) { return 'Du hast hier die Möglichkeit eine <strong>News 
    zu '.$v[0].' einzureichen</strong>, 
    um hohe Anerkennung zu erhalten und tausende Leser zu erreichen. <strong>Besonders gut geschriebene News erhalten von uns 
    zusätzlich eine Auszeichnung</strong> und erhöhen deine Chancen auf begehrte Jobangebote '.__('JOB_AS').'.'; },
    'ADD_NEWS_CHECK' => 'Wir werden deine News prüfen und dich mit unserer Bewertung benachrichtigen, sofern die News sich für eine Veröffentlichung qualifiziert.',

    'SUGGESTION_DESCRIPTION' => 'Möchtest du ein Thema vorschlagen, das wir hier aufnehmen? 
    Trage dazu einfach deinen Vorschlag in das folgende Textfeld ein:',
    'SUGGESTION_CHECK' => 'Wir prüfen deinen Vorschlag und erstellen das Thema bei großer Nachfrage.',
    'HIGHLIGHT_BETATEST' => 'Freie Plätze für Beta-Test verfügbar',
    'RELEASED' => 'Veröffentlichung',
    'SUBSCRIBED_TOPICS' => 'Abonnierte Themen',
    'SUBSCRIBED_TOPICS_EMPTY' => 'Du folgst bisher keinen Themen.  
    Folge einem Thema, um die aktuellsten Neuigkeiten, Updates, Zugänge oder andere Specials zu erhalten.',
    'POPULAR_TOPICS' => 'Beliebte Themen',
    'READ_MORE' => 'Mehr lesen',

    'FOLLOW' => 'Folgen',
    'UNFOLLOW' => 'Nicht mehr folgen',
    'PARTICIPATE' => 'Freien Platz reservieren',
    'PARTICIPATE_NOTE_ST' => 'Die Reservierung gilt für einen freien Platz, um dir Zugang zum offiziellen Beta-Test zu sichern. 
    Wir bemühen uns, dir diesen Zugang zu ermöglichen, jedoch ist diese Vergabe vom Spielehersteller abhängig.',
    'WITHDRAW_PARTICIPATION' => 'Reservierung zurückziehen',
    /* SIGNUP */
    'ACCEPT_PRIVACY' => 'Ich akzeptiere die <a href="#modal-privacy">Datenschutzbestimmungen</a>.
    Alle Daten werden vertraulich behandelt und verschlüsselt übertragen.',
    'ACCEPT_TERMSOFSERVICE' => 'Ich akzeptiere die <a href="#modal-termsofservice">AGB</a>.
    Alle Daten werden vertraulich behandelt und verschlüsselt übertragen.',
    'ACCEPT_DELETION' => 'Ich bestätige hiermit, dass ich meine Mitgliedschaft zum sofortigen Zeitpunkt kündigen möchte.',
    'ACCEPT_DELETION_LIFETIME' => 'Mir ist bewusst, dass sämtliche Daten meines Accounts gelöscht und nicht wiederverwendet werden können 
    (dies schließt auch alle Partner-Netzwerke ein).',
    /* --- STEP 1 --- */
    'STEP1_TITLE' => 'Jetzt '.(__('JOB_AS')).' anmelden',
    'STEP1_TEXT' => 'Bitte fülle einfach das folgende Formular aus,
    um dich offiziell '.__('JOB_AS').' anzumelden und qualifizieren zu lassen. 
    Du kannst dich auch mit Facebook verbinden, um Zeit zu sparen:',
    'MR' => 'Herr',
    'MRS' => 'Frau',
    'EMAIL' => 'E-Mail Adresse',
    'EMAIL_REPEAT' => 'E-Mail Adresse bestätigen',
    'NEW_EMAIL' => 'Neue E-Mail Adresse',
    'NEW_EMAIL_REPEAT' => 'Neue E-Mail Adresse wiederholen',
    'PASS' => 'Passwort',
    'PASS_REPEAT' => 'Passwort bestätigen',
    'NEW_PASS' => 'Neues Passwort',
    'NEW_PASS_REPEAT' => 'Passwort bestätigen',
    'EMAIL_NOTE' => 'Bitte beachte, dass deine E-Mail Adresse für eine erfolgreiche Anmeldung korrekt sein muss.',
    /* --- STEP 2 || SETTINGS --- */
    'FEMALE' => 'Weiblich',
    'MALE' => 'Männlich',
    'PRENAME' => 'Vorname',
    'SURNAME' => 'Nachname',
    'BIRTHDATE' => 'Geburtsdatum',
    'STREET' => 'Straße',
    'HOUSENUMBER' => 'Hausnummer',
    'ZIP' => 'Postleitzahl',
    'CITY' => 'Stadt',
    'PROFILE_PREVIEW_NOTE' => 'Dies ist eine verkürzte Vorschau deines Profils. Bitte beachte, dass deine E-Mail Adresse korrekt sein muss. 
    Du kannst bei Bedarf <a href="'.ROOT.'signup/1">zum Anmeldeformular zurückspringen</a>, um deine Daten zu ändern.',
    'PERSONAL_DATA_CHANGE_NOTE' => 'Diese Daten sind nicht öffentlich einsehbar und werden ausschließlich unkenntlich angezeigt. 
    Bitte teile uns Änderungen deiner persönlichen Daten in einem Support-Ticket im <a href="'.ROOT.'help">Hilfecenter</a> mit.',
    'ADDRESS' => 'Adresse',
    'ADDRESS_NOTE' => 'Deine Adresse wird benötigt, um dir Jobangebote in deiner Nähe anzubieten.',
    'CHANGE_EMAIL' => 'E-Mail Adresse ändern',
    'OLD_PASS' => 'Altes Passwort',
    'CHANGE_PASS' => 'Passwort ändern',
    'CHARACTERISTICS' => 'Steckbrief',
    'CHARACTERISTICS_DESCRIPTION' => 'Alle Angaben zu deinem Profil bei '.__('PROJECT').'.',
    'PASS_TEXT' => 'Bitte lege ein neues Passwort fest, das du verwenden möchtest, um dich zukünftig einzuloggen.',
    'SELECT_PIMG' => 'Profilbild auswählen',
    'PIMG_TEXT' => 'Das äußere Erscheinungsbild ist bei der Vermittlung oft von Bedeutung. Daher empfehlen wir, dass du ein Profilbild von dir hochlädst. 
    Diese Angabe ist jedoch keine Pflicht.',
    'LANGUAGE_NAME' => 'Name der Sprache',
    'PASS_REQUEST' => 'Passwort Anfordern',
    'TEXTAREA_SELF_DESCRIPTION' => '
    <legend class="mt10 mb15">Selbstbeschreibung verfassen (optional)</legend>
    <p class="mb10">Schreibe in das folgende Textfeld ein paar Worte über dich, um dich selbst zu beschreiben, damit wir 
    dein Profil besser für dich bewerben und einen sympathischen Eindruck bei Interessenten hinterlassen können. 
    </p>
    <p class="f09 grey mt10">Hinweis: Diese Angabe ist optional. Wir empfehlen dir diese Angabe jedoch, um deine Vermittlungschancen zu erhöhen.</p>',
    'STEP_2_TEST_PLACEHOLDER' => 'Text verfassen...',
    'VAL_HAIR_COLOR' => 'Bitte gib an, welche Haarfarbe du hast.',
    'VAL_EYE_COLOR' => 'Bitte gib an, welche Augenfarbe du hast.',

    'PROGRESSION_TITLE' => function($v) { return $v[0] . '% ausgefüllt'; },
    'PROGRESSION_TEXT' => 'Du erhältst mehr Aufmerksamkeit und eine höhere Erfolgschance für Jobangebote, 
    wenn du dein Profil vollständig ausfüllst und um folgende Angaben erweiterst:',

    /* --- STEP 3 --- */
    'STEP3_TEXT_NOTE' => '
    * Wir erheben diese einmalige Zahlung als Garantie dafür, 
    dass unser Service in Anspruch genommen wird, um dir den begehrten Platz beim Beruf '.__('JOB_AS').' zu sichern und um Kosten 
    unserer Vermittlungs-Experten abzudecken, die sich dafür einsetzen, dir geeignete Jobangebote anzubieten.
    ',
    'QUALIFIED_TITLE' => 'Qualifizierung erfolgreich',
    'STEP3_BOX' => 'Wir nehmen <strong>nur einmalig</strong> eine kleine Servicegebühr zur Freischaltung deines Profils entgegen.<br class="visible-xs" /> 
    Der Betrag wird dir bei erfolgreicher Vermittlung <strong>vollständig zurückerstattet</strong>.<br />
    Zu unserem Service gehört die komplette Aushandlung von individuell zu dir passenden Jobangeboten  
    mit unseren erstklassigen Kontakten sowie  
    der professionelle Bewerbungsaufwand, den unsere Vermittlungs-Experten für dich übernehmen.*',
    'LAST_MONTH_TEXT' => function($values) {
    return 'Im letzten Monat haben wir <strong class="dib green">'.$values.' zufriedene Mitglieder</strong> 
    erfolgreich für '.__('PROJECT').' freischalten können, die auf unsere hochwertige Service-Qualität
    und seriösen Kontakte vertrauen, welche ohne unsere Empfehlung nicht oder nur schwer erreichbar wären.'; }
    ,
    'VAL_ORDER_APP_REQUIRED' => 'Du benötigst die 
    <a href="https://play.google.com/store/apps/details?id='.PACKAGE.'" target="_blank">'.__('PROJECT').' Android App</a> vom Google Play Store, 
    um eine In-App-Zahlung zu tätigen.',
    'VAL_ORDER_INITIALS_REQUIRED' => 'Die Projekt-Initialien sind erforderlich.',
    'EXAMPLE' => 'Beispiel',
    'EXAMPLE_TEXT' => 'So könnten deine Angebote aussehen. Du hast immer eine gute Übersicht und die freie Auswahl:',
];