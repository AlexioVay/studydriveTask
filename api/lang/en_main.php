<?php
return [
    /* BASIC */
    # Datetime:
    'DAY' => 'Day',
    'MONTH' => 'Month',
    'YEAR' => 'Year',
    'TIME_PREFIX' => '',
    'TIME_NOW' => 'just now',
    'TIME_SUFFIX' => 'ago',
    'TIME_MONTHS' => [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
    7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'],
    # General:
    'CONGRATS' => 'Herzlichen Glückwunsch',
    'LOADING' => 'Loading...',
    'ADD_ENTRY' => 'Add new entry',
    'ADMIN' => 'Administration',
    'SETTINGS' => 'Settings',
    'COMPLETE_PROFILE' => 'Complete Profile',
    'LOGOUT' => 'Logout',
    'JOB_PLACEMENTS' => 'Job Placements',
    'AGENCIES' => 'Agencies',
    'COUNTRIES' => 'Countries',
    'FULLSCREEN' => 'Fullscreen',
    'YES' => 'Ja',
    'NO' => 'Nein',
    'PIMG' => 'Profile Image',
    'PHONE_NUMBER' => 'Phone Number',
    'PHONE_NUMBER_DESCRIPTION' => 'You will receive a free notification about verified job offers via SMS.',
    'PHONE_NUMBER_COUNTRY_CODE' => 'Country Code',
    'PHONE_NUMBER_FULL' => 'Phone Number',
    'WORK' => 'Career',
    'OCCUPATION_TITLE' => 'Occupation',
    'OCCUPATION_LOCATION' => 'Location',
    'OCCUPATION_CURRENTLY' => 'I am currently in this position',
    'OCCUPATION_COMPANY' => 'Company Name',
    'OCCUPATION_POSITION' => 'Position',
    'OCCUPATION_TYPES' => ['Apprentice','School Student','University Student','Employee','Self employed','Executive','Not employed'],
    'OCCUPATION_SINCE' => 'Since (Month/Year)',
    'OCCUPATION_TO' => 'To (Month/Year)',
    'PLEASE_SELECT' => 'Please Select',
    'PRICE' => 'Price',
    'PRICE_TOTAL' => 'Gesamtpreis',
    'NET_PRICE' => 'Nettopreis',
    'VAT' => 'Zzgl. 19% MwSt.',
    'ACCOUNT_NAME' => __('PROJECT').' Banking',
    'ACCOUNT_NR' => 'Kontonummer',
    'BANK_CODE' => 'Bankleitzahl',
    'REFERENCE_LINE' => 'Verwendungszweck',
    # Footer:
    'IMPRINT' => 'Impressum',
    'IMPRINT_LEGAL_NOTE' => __('PROJECT').' is an American company that offers services worldwide. 
    We therefore request that legal matters in cases of particular urgency be addressed first to 
    <u>legal@'.ROOT_SHORT.'</u> in the English language, so that we can process the request without the delay of 
    required translations.',
    'MAIN_LEGAL_NOTE' => 'Legal information can be found at the side menu.',
    'DATA_PROTECTION' => 'Datenschutz',
    'AGB' => 'AGB',
    # Input:
    'INPUT_TEXT' => 'Write a text...',
    'INPUT_QUESTION' => 'Send Request',
    'INPUT_TOPIC' => 'Enter a topic...',
    'INPUT_TITLE' => 'Enter a title...',
    'INPUT_VISIBLE' => 'Show input',
    'INPUT_INVISIBLE' => 'Hide input',
    'INPUT_QUESTION_SURE' => 'I\'m aware that questions already answered in the Help Center cannot be processed.',
    # Button:
    'INPUT_SEND' => 'Send',
    # Messages:
    'MSG_LOGOUT' => 'Logging out...',

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
    'BTN_ENTER_ADDRESS' => 'Confirm address',
    'REF_TITLE' => 'Working with friends',
    'REF_EMPTY' => 'The names of your referrals would be displayed here.',
    'REF_INTRO_TEXT' => 'Your recommendation isn\'t just growing our community but also 
    allows you to <u>work together with your friends</u>. We support and take care of this with additional commitment.',
    'REF_TEXT' => '
        You earn <strong>'._n(5).' for each referral</strong> 
        when friends, family, or acquaintances are signing up with your personal referral link
        <span class="dib fwB">'.ROOT_WWW.'/'.$_SESSION['uid'].'</span>
        and unlock their account.
    ',
    'PERSONAL_CODE' => 'Your personal referral link',
    'PERSONAL_FRIENDS' => 'Your referrals',
    'SHARE' => 'Share now',
    'EARNINGS' => 'Earnings',
    'REFERRED' => 'Referred',
    /* NAV */
    'NAV_REGISTER' => 'Participate',
    'NAV_GUARANTEE' => 'Guarantee',
    'NAV_NEWS' => 'News',
    'NAV_RATINGS' => 'Ratings',
    'NAV_HELP' => 'Help Center',
    /* FOOTER */
    '247_TITLE' => 'Always there for you',
    '247' => 'You can contact us at any time! Please use our <a href="'.ROOT.'help">help center</a> or visit our social media:',

    /* VALIDATION */
    /* Messages */
    'OK_SUGGESTION' => 'Thank you! We have received your suggestion.',
    'OK_ADD_NEWS' => 'Thank you! We have received your news submission.',
    'OK_BETA_PARTICIPATE_YES' => 'We try to secure an invitation for you.',
    'OK_BETA_PARTICIPATE_NO' => 'We have removed you from the invitation request list.',
    'OK_TOPIC_RATING_YES' => function($v) { return 'You are interested in '.$v[0].'.'; },
    'OK_TOPIC_RATING_NO' => function($v) { return 'You are not interested in '.$v[0].'.'; },
    /* --- Account --- */
    'INACTIVE_TITLE' => 'Please note',
    'INACTIVE_TEXT' => function($values) {
        if ($values[0] < 2) $reasons = __('INACTIVE_REASON'); else $reasons = __('INACTIVE_REASONS');
        return 'We can\'t place you in a job '.__('JOB_AS').' because of '.$reasons.':';
    },
    'INACTIVE_REASON' => 'following reason',
    'INACTIVE_REASONS' => 'following reasons',
    'REASON_COMPLETE' => 'You didn\'t complete your registration',
    'REASON_ACTIVATE' => 'Your account hasn\'t been activated yet &ndash; <a href="#modal-activate">Activate now</a>',
    'REASON_PAYMENT' => 'Unlocking your account isn\'t completed yet',
    'REASON_USER_INFO' => 'You have some <a href="'.ROOT.'step/2">missing profile information</a>',
    'REASON_ADDRESS' => 'You need to <a href="'.ROOT.'settings">enter your address</a> to receive location based job offers<br />
    <span class="f09 grey">Your address will not be displayed publicly</span>',
    /* --- Admin --- */
    'VAL_ORDER_NOT_FOUND' => 'The order id havn\'t been found.',
    'VAL_ORDER_ALREADY_UNLOCKED' => 'This account was already unlocked.',
    /* API */
    'BALANCE_SHEET' => 'Balance Sheet',
    'RECORDS' => 'Records',
    'RECORDS_LIFETIME' => 'Lifetime Records',
    'MAX_DAILY_EARNING' => 'Daily',
    'MAX_WEEKLY_EARNING' => 'Weekly',
    'MAX_MONTHLY_EARNING' => 'Monthly',
    'BEST_MONTH_LIFETIME' => 'Best Month',
    'CAL_WEEK' => 'CW',
    'SUM' => 'Sum',
    'DAILY' => 'Daily',
    /* --- NEWS --- */
    'META_NEWS_TITLE' => function($v) {
        return 'Become a '.$v[0].' '.__('JOB').' and get all news, updates and specials now';
    },
    'META_NEWS_TITLE_BETA' => function($v) {
        return 'Gamers wanted for '.$v[0].' beta test demo download: Release inclusive beta key';
    },
    'TOPIC_TBA' => 'TBA',
    'TOPIC_LIKE_RELEASED' => function($v) {
        return 'Do you want to play '.$v['topic'].' for free and earn money for each game test? 
        Then you should consider becoming a '.__('JOB').' for games like '.$v['topic'].' or other popular games of your choice!';
    },
    'TOPIC_LIKE_UNRELEASED' => function($v) {
        return 'Do you want to get an invitation for the '.$v['topic'].' beta test or earn money for game tests in general? 
        Then you should consider becoming a '.__('JOB').' for games like '.$v['topic'].' or other popular games of your choice!';
    },
    'TOPIC_LIKE_COMPLETED' => function($v) {
        return 'You will receive optimized job offers based on the topics you follow. 
        Are you interested in '.$v['topic'].'?';
    },
    'TOPIC_LIKE_TBA' => function($v) {
        return 'Do you want to play '.$v['topic'].' for free when it gets released and earn money for each game test? 
        Then you should consider becoming a '.__('JOB').' for games like '.$v['topic'].' or other popular games of your choice!';
    },
    'TOPIC_SIDEBAR_TITLE' => 'Access Unpublished Games',
    'TOPIC_SIDEBAR_TEXT' => function($v) {
        return 'Do you want to access previously unreleased games/DLCs, beta tests or upcoming game updates?
        Become a game tester for games like '.$v[' titles'].' or other popular games of your choice!';
    },
    'TOPIC_TOTAL_LIKES' => function($v) { return $v[0] . '% of all users are interested in '.$v[1].'.'; },
    'TOPIC_LIKE_TITLE' => function($v) { return 'Click here to show your interest for '.$v[0].''; },
    'TOPIC_DISLIKE_TITLE' => function($v) { return 'Click here to show that you are not interested in '.$v[0].''; },

    'AUTHOR' => 'Author',
    'SUGGESTION_COLLAPSE' => 'Suggest topic',
    'SUGGESTION_ADD_NEWS' => 'Submit news',
    'NEWS_EMPTY' => function($v) { return 'There are no recent news about '.$v[0].'. You can consider to 
    <a data-toggle="collapse" data-target="#addNews" class="suggestion">send a news submission</a> 
    by yourself to receive a high reputation and reach thousands of readers. 
    <strong>Very well written news receive an award</strong> from us additionally. 
    This will also increase your chance to get job offers '.__('JOB_AS').' that are highly sought.'; },
    'ADD_NEWS_DESCRIPTION' => function($v) { return 'You have the opportunity to <strong>add a news post about '.$v[0].'</strong> 
    here to achieve high reputation and reach thousands of readers.  
    <strong>Very well written news receive an award</strong> from us additionally. 
    This will also increase your chance to get job offers '.__('JOB_AS').' that are highly sought.'; },
    'ADD_NEWS_CHECK' => 'We will check your news submission and inform you if this submission is rated as qualified to be published.',

    'SUGGESTION_DESCRIPTION' => 'Do you want to suggest a topic that we should list here?  
    Just enter your suggestion in the following text field:',
    'SUGGESTION_CHECK' => 'We will check your suggestion and create this topic when the demand is high.',
    'HIGHLIGHT_BETATEST' => 'Beta test invitations available',
    'RELEASED' => 'Release date',
    'SUBSCRIBED_TOPICS' => 'Subscribed Topics',
    'SUBSCRIBED_TOPICS_EMPTY' => 'You don\'t follow any topics yet. 
    Follow a topic to receive the latest news, updates, access options or other specials.',
    'POPULAR_TOPICS' => 'Popular Topics',
    'READ_MORE' => 'Read more',

    'FOLLOW' => 'Follow',
    'UNFOLLOW' => 'Unfollow',
    'PARTICIPATE' => 'Reserve a free place',
    'WITHDRAW_PARTICIPATION' => 'Withdraw Reservation',
    'PARTICIPATE_NOTE_ST' => 'The reservation is for the official beta test access.   
    We will do our best to secure you this access, but this decision depends on the game company.',
    /* SIGNUP */
    'ACCEPT_PRIVACY' => 'I confirm that I read the <a href="#modal-privacy">privacy policy</a> and accept them.
    All data will be sent confidentially and encrypted.',
    'ACCEPT_TERMSOFSERVICE' => 'I confirm that I read the <a href="#modal-termsofservice">Terms of service</a> and accept them.
    All data will be sent confidentially and encrypted.',
    /* --- STEP 1 --- */
    'STEP1_TITLE' => 'Sign Up '.ucwords(__('JOB_AS')).' Now',
    'STEP1_TEXT' => 'Please fill out the following form to get an official qualification 
    '.__('JOB_AS').' and to sign up.  
    You can also use the Facebook Login to save time:',
    'MR' => 'Herr',
    'MRS' => 'Frau',
    'EMAIL' => 'Email Address',
    'EMAIL_REPEAT' => 'Confirm Email Address',
    'NEW_EMAIL' => 'New email address',
    'NEW_EMAIL_REPEAT' => 'Repeat new email address',
    'PASS' => 'Password',
    'PASS_REPEAT' => 'Confirm Password',
    'NEW_PASS' => 'New Password',
    'NEW_PASS_REPEAT' => 'Confirm Password',
    'EMAIL_NOTE' => 'Please note that your email address needs to be valid for a successful registration.',
    /* --- STEP 2 || SETTINGS --- */
    'FEMALE' => 'Female',
    'MALE' => 'Male',
    'PRENAME' => 'Prename',
    'SURNAME' => 'Surname',
    'BIRTHDATE' => 'Birthdate',
    'STREET' => 'Street',
    'HOUSENUMBER' => 'House number',
    'ZIP' => 'Zip Code',
    'CITY' => 'City',
    'PROFILE_PREVIEW_NOTE' => 'This is a shortened profile preview. Please note that your email address has to be valid. 
    You can <a href="'.ROOT.'signup/1">jump back to the registration form</a> to change your data if you need to.',
    'PERSONAL_DATA_CHANGE_NOTE' => 'Your data can\'t be seen publicly and will be displayed unrecognizable. 
    Please inform us about any personal data change with a support ticket in our <a href="'.ROOT.'help">help center</a>.',
    'ADDRESS' => 'Address',
    'ADDRESS_NOTE' => 'Your address is required to offer you jobs near your area.',

    'OLD_PASS' => 'Old password',
    'PASS_TEXT' => 'Please set a new password that you want to use from now on.',

    'CHANGE_EMAIL' => 'Change email address',
    'CHANGE_PASS' => 'Change password',
    'CHARACTERISTICS' => 'Characteristics',
    'CHARACTERISTICS_DESCRIPTION' => 'Everything about your '.__('PROJECT').' profile.',
    'SELECT_PIMG' => 'Select Profile Image',
    'PIMG_TEXT' => 'Your appearance is often important for a job placement. 
    Therefore, we recommend that you upload a profile picture of yourself. 
    You can also do this after signing up.',
    'LANGUAGE_NAME' => 'Name of Sprache',
    'PASS_REQUEST' => 'Request Password',
    'TEXTAREA_SELF_DESCRIPTION' => '
    <legend class="mt10 mb15">Write a self-description (optional)</legend>
    <p class="mb10">Write a few words about you to describe yourself in the following text box. 
    This promotes your profile better and leaves a sympathetic impression.
    </p>
    <p class="f09 grey mt10">Note: This information is optional. 
    However, we recommend you to enter this information to increase your chance to receive job offers.</p>',
    'STEP_2_TEST_PLACEHOLDER' => 'Write a text...',
    'VAL_HAIR_COLOR' => 'Please enter what hair color you have.',
    'VAL_EYE_COLOR' => 'Please enter what eye color you have.',

    'PROGRESSION_TITLE' => function($v) { return $v[0] . '% completion'; },
    'PROGRESSION_TEXT' => 'You attract more attention and a higher chance to receive job offers if you  
    complete your profile and add the following information:',

    /* --- STEP 3 --- */
    'STEP3_TEXT_NOTE' => '
    * We collect this one-time payment as a guarantee, 
    that our service will be used to secure you the desired place in the profession '.__('JOB_AS').' and to pay the costs 
    of our job placement experts, who regularly seek suitable job offers for you.
    ',
    'QUALIFIED_TITLE' => 'Qualification successful',
    'STEP3_BOX' => 'We charge you <strong>only once</strong> with a small fee to unlock your profile.<br class="visible-xs" />
    You will receive a <u>complete refund</u> after your successful job placement.*<br />
    This service includes our completely individual and professional job application effort that our experts taking care of for you.*
    ',
    'LAST_MONTH_TEXT' => function($values) {
    return 'In the past month, we were able to unlock <strong class="dib green">'.$values.' satisfied members</strong> 
    for a job. Those members trust in our high service-quality and first-class contacts, 
    which would not be possible to be contacted without our recommendation 
    or through a very difficult way.'; }
    ,
    'VAL_ORDER_APP_REQUIRED' => 'You need to download the 
    <a href="https://play.google.com/store/apps/details?id='.PACKAGE.'" target="_blank">'.__('PROJECT').' Android App</a> on Google Play Store 
    to use In-App payment.',
    'VAL_ORDER_INITIALS_REQUIRED' => 'The project initials are required.',
    'EXAMPLE' => 'Example',
    'EXAMPLE_TEXT' => 'This is how your job openings could look like. You always have a good overview and a free choice:',
];