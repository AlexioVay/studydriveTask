<?php

class Docs {

    public function output($data) {
        $target = $data['target'];
        $output = $this->$target($data);

        return $output;
    }

    private function help($data) {
        $output =
        '<div class="container">
            <div class="row">
                <div class="col-sm-7 pt40 pb30">
                    <h2><i class="material-icons md-20 green mr10">info</i> '.__('PROJECT').' '. __('QA_INTRO_TITLE') .'</h2>
                    <p>'.__('QA_INTRO').'
                    </p>
                </div>
                <div class="col-sm-5 pt40 pb30">
                    <form id="askForm">
                        <fieldset>
                            '.input('question').'
                            '.check('question_sure', 'checkbox').'
                            <button data-form="#askForm" data-task="ask" class="async mt15 btn btn-info">'. __('QA_ASK_FORM_BUTTON') .'</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="gt"></div>
        <div class="container pt40 pb40">
            <h2 id="faq" class="f13">'. __('QA_FAQ_TITLE') .'</h2><br />';

        $qa = null;
        $qa_box = null;
        $i = 1;
        foreach (__('QA') as $x) {
            foreach($x as $q => $a) {
                $qa .= '<div id="Q'.$i.'" class="pt15"><p class="f11 fwB">'.$q.'</p>'.$a.'</div>';
                $qa_box .= '<li class="square"><a href="#Q'.$i.'">'.$q.'</a></li>';
                $i++;
            }
        }

            $qa_output = null;
            if (IS_MOBILE) {
                $qa_output = '
                <div class="pt15 pb15">'.$qa_box.'</div>
                <div class="pb20">'.$qa.'</div>
                ';
            } else {
                $qa_output = '
                <div class="row">
                    <div class="col-sm-8 pt20 pb20">
                    '.$qa.'
                    </div>
                    <div class="col-sm-4">
                        <div class="box-green mt25">
                            <ul>'.$qa_box.'</ul>
                        </div>
                    </div>
                </div>';
            }
        $output .= $qa_output.'
        </div>';

        return $output;
    }

    public function termsofservice($data) {
        $output = null;
        $container = false;
        if ($data['container']) $container = true;
        if ($container) $output .= '<div class="container pt40 pb40"><h1>Allgemeine Geschäftsbedingungen</h1>';

        $output .= '
        <div>
            <u><h3>Präambel</h3></u>
            <P class="p3 ft1">'.__('PROJECT').', Geschäftsführer '.CONTACT_NAMES.' (im Folgenden: '.__('PROJECT').') betreiben unter der Internetseite '.ROOT_WWW.' die <NOBR>Online-Plattform</NOBR> "'.__('PROJECT').'". Natürliche Personen auf der Suche nach kurzfristigen Jobs haben darauf die Möglichkeit, nach den folgenden Richtlinien ein Profil zu erstellen und zu pflegen, um Jobangebote durch '.__('PROJECT').' an ihre <NOBR>E-Mail-Adresse</NOBR> zu erhalten.</P>
            <u><h3 class="mt20">§ 1 Allgemeines</h3></u>
            <P class="p5 ft1">Diese Geschäftsbedingungen gelten für die Inanspruchnahme der durch '.__('PROJECT').' unter '.ROOT_WWW.' betriebenen Plattform '.__('PROJECT').'. Wenn nicht ausdrücklich schriftlich etwas anderes vereinbart wurde, erkennt der Nutzer diese Bedingungen mit der Registrierung auf der Plattform an.</P>
            <u><h3 class="mt20">§ 2 Anmeldung, Registrierung, Profil, Pflichten des Nutzers, Rechteeinräumung</h3></u>
            <h3 class="mt20">§ 2.1 Registrierung</h3>
            <P class="p3 ft1">Für die Nutzung der Plattform '.__('PROJECT').' ist die Registrierung eine zwingende Voraussetzung. Die Registrierung erfolgt durch das Eintragen der Daten im Registrierungsprozess, der hier beginnt: https://'.ROOT_WWW.'/signup.</P>
            <h3 class="mt20">§ 2.2 Bestätigung der <NOBR>E-Mailadresse</NOBR></h3>
            <P class="p5 ft3">Nach der Registrierung erhält der Nutzer automatisch eine <NOBR>E-Mail</NOBR> an die von ihm angegebene <NOBR>E-Mail-</NOBR> Adresse mit einem Bestätigungslink bzw. Bestätigungs-Code und ist verpflichtet, durch den angegebenen Link seine <NOBR>E-Mailadresse</NOBR> zu bestätigen.</P>
            <h3 class="mt20">§ 2.3 Vergabe eines Anmeldepasswortes</h3>
            <P class="p3 ft1">Bei der Registrierung wählt der Nutzer ein Passwort zur Anmeldung auf der Plattform. Er verpflichtet sich, sein eingegebenes Passwort vertraulich zu behandeln und nicht an Dritte zu kommunizieren.</P>
            <h3 class="mt20">§ 2.4 Verwaltung des Profils</h3>
            <P class="p5 ft3">Über die bei der Registrierung angemeldeten Anmeldedaten <NOBR>(E-Mailadresse</NOBR> und Passwort) hat der Nutzer die Möglichkeit, die Angaben in seinem Profil zu vervollständigen, zu ändern und anzupassen.</P>
            <h3 class="mt20">§ 2.5 Wahrheitsgemäße und aktuelle Angaben</h3>
            <P class="p3 ft3">Der Nutzer verpflichtet sich während der Nutzung der Plattform '.__('PROJECT').' ausschließlich wahrheitsgemäße Angaben zu machen. Dies betrifft sämtliche Daten, die er in seinem Profil angibt.</P>
            <P class="p10 ft3">Ändern sich Angaben, beispielsweise auf Grund eines Umzugs an eine neue Adresse, ist der Nutzer verpflichtet, die entsprechenden Angaben in seinem Profil anzupassen.</P>
            <P class="p11 ft4">Die Nutzung von '.__('PROJECT').' ist ausschließlich nach Maßgabe der Präambel dieser Geschäftsbedingungen bestimmt. Jede Nutzung für oder im Zusammenhang mit darüber hinaus gehenden Zwecken ist nicht erlaubt, es sei denn, dass '.__('PROJECT').' eine solche Nutzung zuvor ausdrücklich und schriftlich erlaubt hat. Dazu gehören Werbung, Preisausschreiben, Verlosungen, Inserate und jedes Sammeln von Identitäts- oder Kontaktdaten anderer registrierter Personen über den Zweck von '.__('PROJECT').' hinaus.</P>
            <P class="mt20 p12 ft0">Insbesondere folgendes ist nicht gestattet:</P>
            <ul>
                <li class="square">Inhalte, die pornografisch, anstößig, obszön, verleumderisch oder rassistisch sind, dürfen nicht eingestellt werden.</li>
                <li class="square">Verstöße gegen Jugendschutzgesetze oder gegen das Datenschutzrecht</li>
                <li class="square">Beleidigende oder verleumderische Inhalte.</li>
                <li class="square">Inhalte, die gesetzlich geschützt oder an denen eine andere Person Rechte haben, z.B. ein Urheberrecht, dies gilt insbesondere für Profilbilder, dürfen nicht auf die Platform hochgeladen werden. Dies gilt nicht, wenn der Rechteinhaber ausdrücklich zugestimmt hat.</li>
                <li class="square">Viren, Trojaner und anderen schädlichen Dateien dürfen nicht hochgeladen werden.</li>
                <li class="square">'.__('PROJECT').' ist berechtigt, den Account vorübergehend oder dauerhaft zu sperren, wenn tatsächliche Anhaltspunkte vorliegen, dass gegen die Geschäftsbedingungen oder geltendes Recht verstoßen wurde. Im Fall einer vorübergehenden oder dauerhaften Sperrung sperrt '.__('PROJECT').' die Zugangsberechtigung und benachrichtigt den Nutzer darüber per <NOBR>E-Mail.</NOBR> Im Fall einer vorübergehenden Sperrung reaktiviert '.__('PROJECT').' nach Ablauf der Sperrzeit die Zugangsberechtigung und benachrichtigt den Nutzer darüber ebenfalls per <NOBR>E-Mail.</NOBR> Nutzer, die dauerhaft gesperrt sind, sind von der Nutzung von '.__('PROJECT').' dauerhaft ausgeschlossen; ihnen ist es nicht gestattet, sich erneut anzumelden.</li>
            </ul>
            <h3 class="mt20">§ 2.6 Personenbezogene Daten des Nutzers</h3>
            <P class="p5 ft4">Personenbezogene Daten des Nutzers werden von '.__('PROJECT').' vertraulich behandelt und 
            ohne dessen Zustimmung nicht an Dritte weitergegeben. 
            Die Veröffentlichung einiger eingegebener Daten ist mit Ausnahme der Anschrift möglich, 
            sofern der Nutzer dies wünscht und in seinem Profil bzw. bei der Anmeldung entsprechend einstellt. 
            Dazu gehören folgende Daten:</P>
            <ul>
                <li class="square">Vor- und Nachname</li>
                <li class="square">E-Mail-Adresse</li>
                <li class="square">Anschrift</li>
                <li class="square">Geburtsdatum</li>
                <li class="square">Kenntnisse und bisherige Arbeitserfahrungen</li>
            </ul>
            <br />
            Die Kontaktdaten des Nutzers, die '.__('PROJECT').' für die eigene Nutzung benötigt, um beispielsweise Jobangebote in der Nähe des Nutzers anbieten zu können, 
            wird '.__('PROJECT').' nicht veröffentlichen. Nach Zustimmung des Nutzers können seine Kontaktdaten (<NOBR>E-Mail-Adresse)</NOBR> an einen Auftraggeber weitergeleitet werden.</P>
            <P class="mt20 p19 ft3">Weitere Informationen zum Umgang mit personenbezogenen Daten finden sich in der Datenschutzerklärung, abrufbar unter '.ROOT_WWW.'/privacy.</P>
            <h3 class="mt20">§ 2.7 Erklärungen an den Nutzer</h3>
            <P class="p5 ft4">Sind Erklärungen an den Nutzer abzugeben, ist '.__('PROJECT').' berechtigt, diese per <NOBR>E-Mail</NOBR> an den Nutzer wirksam zuzustellen. Eine Ausnahme bilden hier Mitteilungen, die per Gesetz eine strengere Form erfordern.</P>
            <h3 class="mt20">§ 2.8 Rechteeinräumung</h3>
            <P class="p5 ft4">'.__('PROJECT').' erhält für die Dauer, für die Inhalte hochgeladen bleiben, an diesen Inhalten ein unentgeltliches und übertragbares Nutzungsrecht und ist berechtigt, Sicherungskopien davon zu erstellen. Das ist notwendig, damit '.__('PROJECT').' die Inhalte speichern, veröffentlichen und öffentlich zugänglich machen kann, also die Inhalte überhaupt erst anzeigen kann. '.__('PROJECT').' erhält in diesem Zusammenhang das Recht, die Inhalte zu bearbeiten und zu vervielfältigen, soweit das technisch notwendig ist. '.__('PROJECT').' ist gestattet, dritten die entgeltliche Nutzungsrechte an diesen Inhalten einräumen.</P>
            <u><h3 class="mt20">§ 3 Leistungen</h3></u>
            <h3 class="mt20">3.1 Jobangebote</h3>
            <P class="p3 ft3">
            Nach Abschluss der Registrierung erhält der Nutzer per <NOBR>E-Mail</NOBR> oder auf der Startseite verfügbare Jobangebote durch '.__('PROJECT').',  
            wenn ein Interessent an einer Vermittlung mit dem Nutzer als '.__('PROJECT').' interessiert ist. 
            Er hat dann die Möglichkeit, für diese Jobangebote direkt durch Klick auf eine Schaltfläche zu- oder abzusagen. 
            Eine Garantie zur Vermittlung als '.__('PROJECT').' besteht wie bei allen Stellenmärkten nicht, 
            da dies von den Auftraggebern und der aktuellen Auftragslage 
            abhängig ist - jedoch nicht von der '.__('PROJECT').'-Plattform. 
            '.__('PROJECT').' bemüht sich um die Vorstellung des Nutzers bei potentiellen Jobangeboten, 
            um ihn als '.__('PROJECT').' vermitteln zu können. Zudem wird der Nutzer entlastet, 
            indem er sich dadurch die Zeit und die Mühe einer Bewerbung sowie die Recherche nach Jobangeboten spart.
            </P>
            <h3 class="mt20">§ 3.2 Zusagen zu Jobangeboten</h3>
            <P class="p3 ft4">
            Die Jobangebote stellen aus Sicht von '.__('PROJECT').' lediglich eine unverbindliche Verfügbarkeitsabfrage an die Nutzer dar. 
            Sagt ein Nutzer zu einem Jobangebot zu, hat dies für ihn bindende Wirkung. 
            Er erhält umgehend die Bestätigung, für das Jobangebot zugesagt zu haben. 
            In dieser Bestätigung ist ein Termin genannt, bis zu welchem Datum die Zusage bindend ist. 
            Der Nutzer verpflichtet sich, sich für das jeweilige Jobangebot bis zum genannten Termin verfügbar zu halten. 
            '.__('PROJECT').' wird dem Nutzer bis zu diesem Termin eine Rückmeldung geben, ob seine Zusage erfolgreich war und die Vermittlung 
            zustande kommt oder das Angebot mittlerweile nicht mehr gültig ist.
            </P>
            <h3 class="mt20">§ 3.3 Zusendung von Jobangeboten</h3>
            <P class="p5 ft3">
            Der Nutzer hat die Möglichkeit, die Zusendung von Jobangeboten in seinem <NOBR>Login-Bereich</NOBR> zu unterbinden und 
            wird dann bis auf Weiteres keine Jobangebote mehr erhalten.</P>
            <h3 class="mt20">§ 3.4 Vorbereitung des Einsatzes</h3>
            <P class="p3 ft1">
            Hat ein Nutzer ein Jobangebot angenommen und wurde der Einsatz von '.__('PROJECT').' bestätigt, 
            erhält der Nutzer von '.__('PROJECT').' alle benötigten Informationen für den Einsatz. 
            Außerdem erhält er einen Arbeitsvertrag, welchen er unterschrieben wieder in seinen Account hochladen muss.  
            Aus Datenschutzgründen wird dieser Arbeitsvertrag 14 Tage nach dem Hochladen gelöscht.
            </P>
            <h3 class="mt20">§ 3.5 Individuelle Optimierungsvorschläge für den Nutzer</h3>
            <P class="p3 ft1">
            Der Nutzer hat bei der Registrierung optional die Möglichkeit einen Testbericht zu verfassen, 
            um seine redaktionellen und journalistischen Fähigkeiten zu präsentieren. 
            Testberichte sind Hauptbestandteil der Arbeit als '.__('PROJECT').' oder -redakteur. 
            '.__('PROJECT').' prüft regelmäßig die Testberichte der Nutzer und alle anderen Angaben des Nutzers, um eine Einschätzung  
            zu einer erfolgreichen Vermittlungschance abgeben zu können. Diese Einschätzungen und Optimierungsvorschläge sind jederzeit für 
            den Nutzer im eingeloggten Zustand auf der Startseite einsehbar.
            </P>
            <u><h3 class="mt20">§ 4 Kosten der Nutzung von '.__('PROJECT').'</h3></u>
            <P class="p23 ft3">Für alle unter §3 beschriebenen Leistungen von '.__('PROJECT').', die dem Nutzer die Möglichkeit der Job-Vermittlung als '.__('PROJECT').' anbieten, wird eine einmalige Zahlung i.H.v. '._n(PRICE).' erhoben, die bei erfolgreicher Vermittlung vollständig zurückerstattet wird.
            Diese Gebühr unterstützt die Prävention des Missbrauchs der '.__('PROJECT').'-Plattform bei der Job-Vermittlung und deckt gleichzeitig die Kosten für die unter §3 beschriebenen Leistungen ab. 
            Missbrauch der '.__('PROJECT').'-Plattform zeichnet sich in der Form ab, dass bei der Registrierung jeweils Angaben vom Nutzer gemacht werden könnten,   
            die nicht der Wahrheit entsprechen und somit Bemühungen seitens '.__('PROJECT').' eingespart werden können.<br />
            Wie bei allen Job-Vermittlungen kann eine Vermittlung nicht garantiert werden und ist vom jeweiligen Nutzer-Profil sowie dem aktuellen Stellenmarkt abhängig. 
            Es wird daher stetig darauf hingewiesen, dass insbesondere die Angaben zu einem beispielhaften Testbericht (dritter Schritt bei der Anmeldung) ausführlich und überzeugend sein sollen. 
            So können die redaktionellen und journalistischen Fähigkeiten des Nutzers im Voraus geprüft werden. Diese sind ausschlaggebend für die Ausübung des Berufes.</P>
            <u><h3 class="mt20">§ 5 Abmeldung</h3></u>
            <P class="p0 ft0">Der Nutzer hat jederzeit die Möglichkeit, sich wieder von '.__('PROJECT').' abzumelden. Die schnellste Möglichkeit dafür, ist eine formlose E-Mail mit dem Stichwort "Abmeldung" an die E-Mail Adresse "info@'.ROOT_SHORT.'". Diese Abmeldung ist aus Sicherheitsgründen jedoch nur möglich, wenn sie von der bei der Anmeldung verwendeten E-Mail Adresse des Nutzers an '.__('PROJECT').' gesendet wurde.</P>
            <u><h3 class="mt20">§6 Haftung</h3></u>
            <h3 class="mt20">§6.1 Vorsatz und Garantiegründe</h3>
            <P class="p0 ft0">'.__('PROJECT').' haftet bei Vorsatz oder aus Garantiegründen unbeschränkt.</P>
            <h3 class="mt20">§ 6.2 Grobe Fahrlässigkeit</h3>
            <P class="p5 ft3">Bei grober Fahrlässigkeit ist die Haftung auf den typischen, bei Vertragsabschluss vorhersehbaren Schaden beschränkt.</P>
            <h3 class="mt20">§ 6.3 Einfache Fahrlässigkeit</h3>
            <P class="p3 ft1">Die Haftung bei einfacher Fahrlässigkeit ist ausgeschlossen, es sei denn, dadurch wird eine vertragswesentliche Pflicht nicht erfüllt, auf die der Vertragspartner vertraut. Dann ist die Haftung von '.__('PROJECT').' auf den typischen, bei Vertragsabschluss vorhersehbaren Schaden beschränkt.</P>
            <h3 class="mt20">§ 6.4 Persönliche Haftung der Mitarbeiter</h3>
            <P class="p26 ft3">Wenn die Haftung für '.__('PROJECT').' ausgeschlossen / beschränkt ist, gilt dies ah für die persönliche Haftung der Mitarbeiter, Vertreter und Erfüllungsgehilfen.</P>
            <u><h3 class="mt20">§ 7 Datenschutz</P></h3></u>
            <P class="p3 ft4">'.__('PROJECT').' beachtet alle datenschutzrechtlichen Vorgaben, vor allem diejenigen des Bundesdatenschutzgesetzes und des Telemediengesetzes. Da die Erhebung personenbezogener Daten untrennbar mit dem Betrieb einer <NOBR>Online-Plattform</NOBR> verbunden ist, finden sich unter dem Punkt Datenschutz eine genauere Erklärung, wie personenbezogene Daten durch '.__('PROJECT').' verarbeitet werden.</P>
            <u><h3 class="mt20">§ 8 Schlussbestimmungen</h3></u>
            <h3 class="mt20">§ 8.1 Gerichtsstand</h3>
            <P class="p26 ft3">Es gilt das Recht der Bundesrepublik Deutschland, wobei der Erfüllungsort und der Gerichtsstand für alle Streitigkeiten aus und im Zusammenhang mit '.__('PROJECT').'.EU ist.</P>
            <h3 class="mt20">§ 8.2 Änderungsvorbehalt</h3>
            <P class="p5 ft4">'.__('PROJECT').' hat das Recht, diese Geschäftsbedingungen mit Zustimmung und unter vorheriger Ankündigung des Nutzers zu ändern, wenn die aktuelle Rechtslage oder nachträglich auftretende rechtliche Rahmenbedingungen dies erfordern. '.__('PROJECT').' geht davon aus, dass der Nutzer die geänderten Bedingungen akzeptiert, wenn er nicht innerhalb von zwei (2) Wochen nach der schriftlichen Information per <NOBR>E-Mail</NOBR> widerspricht.</P>
            
            <u><h3 class="mt20">§ 9 Widerrufsbelehrung</h3></u>
            <h3 class="mt20">§ 9.1 Widerrufsrecht</h3>
            <p>Sie haben das Recht, binnen vierzehn Tagen ohne Angabe von Gründen den Kaufvertrag zu widerrufen. Die Widerrufsfrist beträgt vierzehn Tage ab dem Tag an dem der Auftrag aufgegeben wurde. Um Ihr Widerrufsrecht auszuüben, müssen Sie uns  mittels einer eindeutigen Erklärung (z.B. ein mit der Post versandter Brief, Telefax oder E-Mail) über Ihren Entschluss, diesen Vertrag zu widerrufen, informieren. Zur Wahrung der Widerrufsfrist reicht es aus, dass Sie die Mitteilung über die Ausübung des Widerrufsrechts vor Ablauf der Widerrufsfrist absenden.</p>
            
            <h3 class="mt20">§ 9.2 Folgen des Widerrufs</h3>
            <p>Wenn Sie den Kaufvertrag widerrufen, haben wir Ihnen alle Zahlungen, die wir von Ihnen erhalten haben, unverzüglich und spätestens binnen vierzehn Tagen ab dem Tag zurückzuzahlen, an dem die Mitteilung über Ihren Widerruf dieses Vertrags bei uns eingegangen ist. Für diese Rückzahlung verwenden wir dasselbe Zahlungsmittel, das Sie bei der ursprünglichen Transaktion eingesetzt haben, es sei denn, mit Ihnen wurde ausdrücklich etwas anderes vereinbart; in keinem Fall werden Ihnen wegen dieser Rückzahlung Entgelte berechnet.</p>
            </div>
        </div>';

        return $output;
    }

    private function privacy($data = null) {
        $address = str_replace(', ', '<br />', CONTACT_ADDRESS);
        $output = null;
        $container = false;
        if ($data['container']) $container = true;

        if ($container) $output .= '<div class="container pt40 pb40"><h1>Datenschutzbestimmungen</h1>';

        $output .= '<div class="gdpr">
        
        <p>Diese Datenschutzerklärung klärt Sie über die Art, den Umfang und Zweck der Verarbeitung von personenbezogenen Daten (nachfolgend kurz „Daten“) im Rahmen der Erbringung unserer Leistungen sowie innerhalb unseres Onlineangebotes und der mit ihm verbundenen Webseiten, Funktionen und Inhalte sowie externen Onlinepräsenzen, wie z.B. unser Social Media Profile auf (nachfolgend gemeinsam bezeichnet als „Onlineangebot“). Im Hinblick auf die verwendeten Begrifflichkeiten, wie z.B. „Verarbeitung“ oder „Verantwortlicher“ verweisen wir auf die Definitionen im Art. 4 der Datenschutzgrundverordnung (DSGVO). <br>
        
        </p><h3 id="dsg-general-controller">Verantwortlicher</h3><p><span class="tsmcontroller">'. ROOT_SHORT .'<br>
        '. $address .'
        <br><br />
        E-Mail:<br>
        <a href="'. CONTACT_EMAIL .'">'. CONTACT_EMAIL .'</a><br>
        <br>
        Vertreten durch:<br>
        '. CONTACT_NAMES .'<br>
        <br>
        Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:<br>
        '. CONTACT_NAMES .'<br>
        '. $address .'
        <br><br />
        Link zum Impressum:<br />
        <a href="'. ROOT .'imprint">'. ROOT .'imprint</a><br>
        <br />
        Datenschutzbeauftragte:<br />
        '. CONTACT_GDPR .'
        <br />
        </span>
        </p>
        
        <h3 id="dsg-general-datatype">Arten der verarbeiteten Daten</h3><p>-	Bestandsdaten (z.B., Personen-Stammdaten, Namen oder Adressen).<br>
        -	Kontaktdaten (z.B., E-Mail, Telefonnummern).<br>
        -	Inhaltsdaten (z.B., Texteingaben, Fotografien, Videos).<br>
        -	Nutzungsdaten (z.B., besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).<br>
        -	Meta-/Kommunikationsdaten (z.B., Geräte-Informationen, IP-Adressen).</p><h3 id="dsg-general-datasubjects">Kategorien betroffener Personen</h3><p>Besucher und Nutzer des Onlineangebotes (Nachfolgend bezeichnen wir die betroffenen Personen zusammenfassend auch als „Nutzer“).<br>
        </p><h3 id="dsg-general-purpose">Zweck der Verarbeitung</h3><p>-	Zurverfügungstellung des Onlineangebotes, seiner Funktionen und  Inhalte.<br>
        -	Beantwortung von Kontaktanfragen und Kommunikation mit Nutzern.<br>
        -	Sicherheitsmaßnahmen.<br>
        -	Reichweitenmessung/Marketing<br>
        <span class="tsmcom"></span></p><h3 id="dsg-general-terms">Verwendete Begrifflichkeiten </h3><p>„Personenbezogene Daten“ sind alle Informationen, die sich auf eine identifizierte oder identifizierbare natürliche Person (im Folgenden „betroffene Person“) beziehen; als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer Online-Kennung (z.B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden kann, die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen oder sozialen Identität dieser natürlichen Person sind.<br>
        <br>
        „Verarbeitung“ ist jeder mit oder ohne Hilfe automatisierter Verfahren ausgeführte Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten.<br>
        <br>
        „Pseudonymisierung“ die Verarbeitung personenbezogener Daten in einer Weise, dass die personenbezogenen Daten ohne Hinzuziehung zusätzlicher Informationen nicht mehr einer spezifischen betroffenen Person zugeordnet werden können, sofern diese zusätzlichen Informationen gesondert aufbewahrt werden und technischen und organisatorischen Maßnahmen unterliegen, die gewährleisten, dass die personenbezogenen Daten nicht einer identifizierten oder identifizierbaren natürlichen Person zugewiesen werden.<br>
        <br>
        „Profiling“ jede Art der automatisierten Verarbeitung personenbezogener Daten, die darin besteht, dass diese personenbezogenen Daten verwendet werden, um bestimmte persönliche Aspekte, die sich auf eine natürliche Person beziehen, zu bewerten, insbesondere um Aspekte bezüglich Arbeitsleistung, wirtschaftliche Lage, Gesundheit, persönliche Vorlieben, Interessen, Zuverlässigkeit, Verhalten, Aufenthaltsort oder Ortswechsel dieser natürlichen Person zu analysieren oder vorherzusagen.<br>
        <br>
        Als „Verantwortlicher“ wird die natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet.<br>
        <br>
        „Auftragsverarbeiter“ eine natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die personenbezogene Daten im Auftrag des Verantwortlichen verarbeitet.<br>
        </p><h3 id="dsg-general-legalbasis">Maßgebliche Rechtsgrundlagen</h3><p>Nach Maßgabe des Art. 13 DSGVO teilen wir Ihnen die Rechtsgrundlagen unserer Datenverarbeitungen mit.  Für Nutzer aus dem Geltungsbereich der Datenschutzgrundverordnung (DSGVO), d.h. der EU und des EWG gilt, sofern die Rechtsgrundlage in der Datenschutzerklärung nicht genannt wird, Folgendes: <br>
        Die Rechtsgrundlage für die Einholung von Einwilligungen ist Art. 6 Abs. 1 lit. a und Art. 7 DSGVO;<br>
        Die Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer Leistungen und Durchführung vertraglicher Maßnahmen sowie Beantwortung von Anfragen ist Art. 6 Abs. 1 lit. b DSGVO;<br>
        Die Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer rechtlichen Verpflichtungen ist Art. 6 Abs. 1 lit. c DSGVO;<br>
        Für den Fall, dass lebenswichtige Interessen der betroffenen Person oder einer anderen natürlichen Person eine Verarbeitung personenbezogener Daten erforderlich machen, dient Art. 6 Abs. 1 lit. d DSGVO als Rechtsgrundlage.<br>
        Die Rechtsgrundlage für die erforderliche Verarbeitung zur Wahrnehmung einer Aufgabe, die im öffentlichen Interesse liegt oder in Ausübung öffentlicher Gewalt erfolgt, die dem Verantwortlichen übertragen wurde ist Art. 6 Abs. 1 lit. e DSGVO. <br>
        Die Rechtsgrundlage für die Verarbeitung zur Wahrung unserer berechtigten Interessen ist Art. 6 Abs. 1 lit. f DSGVO. <br>
        Die Verarbeitung von Daten zu anderen Zwecken als denen, zu denen sie ehoben wurden, bestimmt sich nach den Vorgaben des Art 6 Abs. 4 DSGVO. <br>
        Die Verarbeitung von besonderen Kategorien von Daten (entsprechend Art. 9 Abs. 1 DSGVO) bestimmt sich nach den Vorgaben des Art. 9 Abs. 2 DSGVO. <br>
        </p><h3 id="dsg-general-securitymeasures">Sicherheitsmaßnahmen</h3><p>Wir treffen nach Maßgabe der gesetzlichen Vorgabenunter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeit und Schwere des Risikos für die Rechte und Freiheiten natürlicher Personen, geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten.<br>
        <br>
        Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen Zugangs zu den Daten, als auch des sie betreffenden Zugriffs, der Eingabe, Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, Löschung von Daten und Reaktion auf Gefährdung der Daten gewährleisten. Ferner berücksichtigen wir den Schutz personenbezogener Daten bereits bei der Entwicklung, bzw. Auswahl von Hardware, Software sowie Verfahren, entsprechend dem Prinzip des Datenschutzes durch Technikgestaltung und durch datenschutzfreundliche Voreinstellungen.<br>
        </p><h3 id="dsg-general-coprocessing">Zusammenarbeit mit Auftragsverarbeitern, gemeinsam Verantwortlichen und Dritten</h3><p>Sofern wir im Rahmen unserer Verarbeitung Daten gegenüber anderen Personen und Unternehmen (Auftragsverarbeitern, gemeinsam Verantwortlichen oder Dritten) offenbaren, sie an diese übermitteln oder ihnen sonst Zugriff auf die Daten gewähren, erfolgt dies nur auf Grundlage einer gesetzlichen Erlaubnis (z.B. wenn eine Übermittlung der Daten an Dritte, wie an Zahlungsdienstleister, zur Vertragserfüllung erforderlich ist), Nutzer eingewilligt haben, eine rechtliche Verpflichtung dies vorsieht oder auf Grundlage unserer berechtigten Interessen (z.B. beim Einsatz von Beauftragten, Webhostern, etc.). <br>
        <br>
        Sofern wir Daten anderen Unternehmen unserer Unternehmensgruppe offenbaren, übermitteln oder ihnen sonst den Zugriff gewähren, erfolgt dies insbesondere zu administrativen Zwecken als berechtigtes Interesse und darüberhinausgehend auf einer den gesetzlichen Vorgaben entsprechenden Grundlage. <br>
        </p><h3 id="dsg-general-thirdparty">Übermittlungen in Drittländer</h3><p>Sofern wir Daten in einem Drittland (d.h. außerhalb der Europäischen Union (EU), des Europäischen Wirtschaftsraums (EWR) oder der Schweizer Eidgenossenschaft) verarbeiten oder dies im Rahmen der Inanspruchnahme von Diensten Dritter oder Offenlegung, bzw. Übermittlung von Daten an andere Personen oder Unternehmen geschieht, erfolgt dies nur, wenn es zur Erfüllung unserer (vor)vertraglichen Pflichten, auf Grundlage Ihrer Einwilligung, aufgrund einer rechtlichen Verpflichtung oder auf Grundlage unserer berechtigten Interessen geschieht. Vorbehaltlich gesetzlicher oder vertraglicher Erlaubnisse, verarbeiten oder lassen wir die Daten in einem Drittland nur beim Vorliegen der gesetzlichen Voraussetzungen. D.h. die Verarbeitung erfolgt z.B. auf Grundlage besonderer Garantien, wie der offiziell anerkannten Feststellung eines der EU entsprechenden Datenschutzniveaus (z.B. für die USA durch das „Privacy Shield“) oder Beachtung offiziell anerkannter spezieller vertraglicher Verpflichtungen.</p><h3 id="dsg-general-rightssubject">Rechte der betroffenen Personen</h3><p>Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere Informationen und Kopie der Daten entsprechend den gesetzlichen Vorgaben.<br>
        <br>
        Sie haben entsprechend. den gesetzlichen Vorgaben das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.<br>
        <br>
        Sie haben nach Maßgabe der gesetzlichen Vorgaben das Recht zu verlangen, dass betreffende Daten unverzüglich gelöscht werden, bzw. alternativ nach Maßgabe der gesetzlichen Vorgaben eine Einschränkung der Verarbeitung der Daten zu verlangen.<br>
        <br>
        Sie haben das Recht zu verlangen, dass die Sie betreffenden Daten, die Sie uns bereitgestellt haben nach Maßgabe der gesetzlichen Vorgaben zu erhalten und deren Übermittlung an andere Verantwortliche zu fordern. <br>
        <br>
        Sie haben ferner nach Maßgabe der gesetzlichen Vorgaben das Recht, eine Beschwerde bei der zuständigen Aufsichtsbehörde einzureichen.<br>
        </p><h3 id="dsg-general-revokeconsent">Widerrufsrecht</h3><p>Sie haben das Recht, erteilte Einwilligungen mit Wirkung für die Zukunft zu widerrufen.</p><h3 id="dsg-general-object">Widerspruchsrecht</h3><p><strong>Sie können der künftigen Verarbeitung der Sie betreffenden Daten nach Maßgabe der gesetzlichen Vorgaben jederzeit widersprechen. Der Widerspruch kann insbesondere gegen die Verarbeitung für Zwecke der Direktwerbung erfolgen.</strong></p><h3 id="dsg-general-cookies">Cookies und Widerspruchsrecht bei Direktwerbung</h3><p>Als „Cookies“ werden kleine Dateien bezeichnet, die auf Rechnern der Nutzer gespeichert werden. Innerhalb der Cookies können unterschiedliche Angaben gespeichert werden. Ein Cookie dient primär dazu, die Angaben zu einem Nutzer (bzw. dem Gerät auf dem das Cookie gespeichert ist) während oder auch nach seinem Besuch innerhalb eines Onlineangebotes zu speichern. Als temporäre Cookies, bzw. „Session-Cookies“ oder „transiente Cookies“, werden Cookies bezeichnet, die gelöscht werden, nachdem ein Nutzer ein Onlineangebot verlässt und seinen Browser schließt. In einem solchen Cookie kann z.B. der Inhalt eines Warenkorbs in einem Onlineshop oder ein Login-Status gespeichert werden. Als „permanent“ oder „persistent“ werden Cookies bezeichnet, die auch nach dem Schließen des Browsers gespeichert bleiben. So kann z.B. der Login-Status gespeichert werden, wenn die Nutzer diese nach mehreren Tagen aufsuchen. Ebenso können in einem solchen Cookie die Interessen der Nutzer gespeichert werden, die für Reichweitenmessung oder Marketingzwecke verwendet werden. Als „Third-Party-Cookie“ werden Cookies bezeichnet, die von anderen Anbietern als dem Verantwortlichen, der das Onlineangebot betreibt, angeboten werden (andernfalls, wenn es nur dessen Cookies sind spricht man von „First-Party Cookies“).<br>
        <br>
        Wir können temporäre und permanente Cookies einsetzen und klären hierüber im Rahmen unserer Datenschutzerklärung auf.<br>
        <br>
        Falls die Nutzer nicht möchten, dass Cookies auf ihrem Rechner gespeichert werden, werden sie gebeten die entsprechende Option in den Systemeinstellungen ihres Browsers zu deaktivieren. Gespeicherte Cookies können in den Systemeinstellungen des Browsers gelöscht werden. Der Ausschluss von Cookies kann zu Funktionseinschränkungen dieses Onlineangebotes führen.<br>
        <br>
        Ein genereller Widerspruch gegen den Einsatz der zu Zwecken des Onlinemarketing eingesetzten Cookies kann bei einer Vielzahl der Dienste, vor allem im Fall des Trackings, über die US-amerikanische Seite <a href="http://www.aboutads.info/choices/">http://www.aboutads.info/choices/</a> oder die EU-Seite <a href="http://www.youronlinechoices.com/">http://www.youronlinechoices.com/</a> erklärt werden. Des Weiteren kann die Speicherung von Cookies mittels deren Abschaltung in den Einstellungen des Browsers erreicht werden. Bitte beachten Sie, dass dann gegebenenfalls nicht alle Funktionen dieses Onlineangebotes genutzt werden können.</p><h3 id="dsg-general-erasure">Löschung von Daten</h3><p>Die von uns verarbeiteten Daten werden nach Maßgabe der gesetzlichen Vorgaben gelöscht oder in ihrer Verarbeitung eingeschränkt. Sofern nicht im Rahmen dieser Datenschutzerklärung ausdrücklich angegeben, werden die bei uns gespeicherten Daten gelöscht, sobald sie für ihre Zweckbestimmung nicht mehr erforderlich sind und der Löschung keine gesetzlichen Aufbewahrungspflichten entgegenstehen. <br>
        <br>
        Sofern die Daten nicht gelöscht werden, weil sie für andere und gesetzlich zulässige Zwecke erforderlich sind, wird deren Verarbeitung eingeschränkt. D.h. die Daten werden gesperrt und nicht für andere Zwecke verarbeitet. Das gilt z.B. für Daten, die aus handels- oder steuerrechtlichen Gründen aufbewahrt werden müssen.</p><h3 id="dsg-general-changes">Änderungen und Aktualisierungen der Datenschutzerklärung</h3><p>Wir bitten Sie sich regelmäßig über den Inhalt unserer Datenschutzerklärung zu informieren. Wir passen die Datenschutzerklärung an, sobald die Änderungen der von uns durchgeführten Datenverarbeitungen dies erforderlich machen. Wir informieren Sie, sobald durch die Änderungen eine Mitwirkungshandlung Ihrerseits (z.B. Einwilligung) oder eine sonstige individuelle Benachrichtigung erforderlich wird.</p><p></p><h3 id="dsg-commercialpurpose">Geschäftsbezogene Verarbeitung</h3><p></p><p><span class="ts-muster-content">Zusätzlich verarbeiten wir<br>
        -	Vertragsdaten (z.B., Vertragsgegenstand, Laufzeit, Kundenkategorie).<br>
        -	Zahlungsdaten (z.B., Bankverbindung, Zahlungshistorie)<br>
        von unseren Kunden, Interessenten und Geschäftspartner zwecks Erbringung vertraglicher Leistungen, Service und Kundenpflege, Marketing, Werbung und Marktforschung.</span></p><p></p><h3 id="dsg-services-contractualservices">Vertragliche Leistungen</h3><p></p><p><span class="ts-muster-content">Wir verarbeiten die Daten unserer Vertragspartner und Interessenten sowie anderer Auftraggeber, Kunden, Mandanten, Klienten oder Vertragspartner (einheitlich bezeichnet als „Vertragspartner“) entsprechend Art. 6 Abs. 1 lit. b. DSGVO, um ihnen gegenüber unsere vertraglichen oder vorvertraglichen Leistungen zu erbringen. Die hierbei verarbeiteten Daten, die Art, der Umfang und der Zweck und die Erforderlichkeit ihrer Verarbeitung, bestimmen sich nach dem zugrundeliegenden Vertragsverhältnis. <br>
        <br>
        Zu den verarbeiteten Daten gehören die Stammdaten unserer Vertragspartner (z.B., Namen und Adressen), Kontaktdaten (z.B. E-Mailadressen und Telefonnummern) sowie Vertragsdaten (z.B., in Anspruch genommene Leistungen, Vertragsinhalte, vertragliche Kommunikation, Namen von Kontaktpersonen) und Zahlungsdaten (z.B.,  Bankverbindungen, Zahlungshistorie). <br>
        <br>
        Besondere Kategorien personenbezogener Daten verarbeiten wir grundsätzlich nicht, außer wenn diese Bestandteile einer beauftragten oder vertragsgemäßen Verarbeitung sind. <br>
        <br>
        Wir verarbeiten Daten, die zur Begründung und Erfüllung der vertraglichen Leistungen erforderlich sind und weisen auf die Erforderlichkeit ihrer Angabe, sofern diese für die Vertragspartner nicht evident ist, hin. Eine Offenlegung an externe Personen oder Unternehmen erfolgt nur, wenn sie im Rahmen eines Vertrags erforderlich ist. Bei der Verarbeitung der uns im Rahmen eines Auftrags überlassenen Daten, handeln wir entsprechend den Weisungen der Auftraggeber sowie der gesetzlichen Vorgaben. <br>
        <br>
        Im Rahmen der Inanspruchnahme unserer Onlinedienste, können wir die IP-Adresse und den Zeitpunkt der jeweiligen Nutzerhandlung speichern. Die Speicherung erfolgt auf Grundlage unserer berechtigten Interessen, als auch der Interessen der Nutzer am Schutz vor Missbrauch und sonstiger unbefugter Nutzung. Eine Weitergabe dieser Daten an Dritte erfolgt grundsätzlich nicht, außer sie ist zur Verfolgung unserer Ansprüche gem. Art. 6 Abs. 1 lit. f. DSGVO erforderlich oder es besteht hierzu eine gesetzliche Verpflichtung gem. Art. 6 Abs. 1 lit. c. DSGVO.<br>
        <br>
        Die Löschung der Daten erfolgt, wenn die Daten zur Erfüllung vertraglicher oder gesetzlicher Fürsorgepflichten sowie für den Umgang mit etwaigen Gewährleistungs- und vergleichbaren Pflichten nicht mehr erforderlich sind, wobei die Erforderlichkeit der Aufbewahrung der Daten alle drei Jahre überprüft wird; im Übrigen gelten die gesetzlichen Aufbewahrungspflichten.<br>
        </span></p><p></p><h3 id="dsg-services-payment">Externe Zahlungsdienstleister</h3><p></p><p><span class="ts-muster-content">Wir setzen externe Zahlungsdienstleister ein, über deren Plattformen die Nutzer und wir Zahlungstransaktionen vornehmen können (z.B., jeweils mit Link zur Datenschutzerklärung, Paypal (https://www.paypal.com/de/webapps/mpp/ua/privacy-full), Klarna (https://www.klarna.com/de/datenschutz/), Skrill (https://www.skrill.com/de/fusszeile/datenschutzrichtlinie/), Giropay (https://www.giropay.de/rechtliches/datenschutz-agb/), Visa (https://www.visa.de/datenschutz), Mastercard (https://www.mastercard.de/de-de/datenschutz.html), American Express (https://www.americanexpress.com/de/content/privacy-policy-statement.html)<br>
        <br>
        Im Rahmen der Erfüllung von&nbsp;Verträgen setzen wir die Zahlungsdienstleister auf Grundlage des Art. 6 Abs. 1 lit. b. DSGVO ein. Im Übrigen setzen wir externe&nbsp;Zahlungsdienstleister auf Grundlage unserer berechtigten Interessen gem. Art. 6 Abs. 1 lit. f. DSGVO ein, um unseren Nutzern effektive und sichere Zahlungsmöglichkeit zu bieten.<br>
        <br>
        Zu den, durch die Zahlungsdienstleister verarbeiteten Daten gehören Bestandsdaten, wie z.B. der Name und die Adresse, Bankdaten, wie z.B. Kontonummern oder Kreditkartennummern, Passwörter, TANs und Prüfsummen sowie die Vertrags-, Summen und empfängerbezogenen Angaben. Die Angaben sind erforderlich, um die Transaktionen durchzuführen. Die eingegebenen Daten werden jedoch nur durch die Zahlungsdienstleister verarbeitet und bei diesen gespeichert. D.h. wir erhalten keine konto- oder kreditkartenbezogenen Informationen, sondern lediglich Informationen mit Bestätigung oder Negativbeauskunftung der Zahlung.&nbsp;Unter Umständen werden die Daten seitens der Zahlungsdienstleister an Wirtschaftsauskunfteien übermittelt. Diese Übermittlung bezweckt die Identitäts- und Bonitätsprüfung. Hierzu verweisen wir auf die AGB und Datenschutzhinweise der&nbsp;Zahlungsdienstleister.<br>
        <br>
        Für die Zahlungsgeschäfte gelten die Geschäftsbedingungen und die Datenschutzhinweise der jeweiligen Zahlungsdienstleister, welche innerhalb der jeweiligen Webseiten, bzw. Transaktionsapplikationen abrufbar sind. Wir verweisen auf diese ebenfalls zwecks weiterer Informationen und Geltendmachung von Widerrufs-, Auskunfts- und anderen Betroffenenrechten.</span></p><p></p><h3 id="dsg-administration">Administration, Finanzbuchhaltung, Büroorganisation, Kontaktverwaltung</h3><p></p><p><span class="ts-muster-content">Wir verarbeiten Daten im Rahmen von Verwaltungsaufgaben sowie Organisation unseres Betriebs, Finanzbuchhaltung und Befolgung der gesetzlichen Pflichten, wie z.B. der Archivierung. Hierbei verarbeiten wir dieselben Daten, die wir im Rahmen der Erbringung unserer vertraglichen Leistungen verarbeiten. Die Verarbeitungsgrundlagen sind Art. 6 Abs. 1 lit. c. DSGVO, Art. 6 Abs. 1 lit. f. DSGVO. Von der Verarbeitung sind Kunden, Interessenten, Geschäftspartner und Websitebesucher betroffen. Der Zweck und unser Interesse an der Verarbeitung liegt in der Administration, Finanzbuchhaltung, Büroorganisation, Archivierung von Daten, also Aufgaben die der Aufrechterhaltung unserer Geschäftstätigkeiten, Wahrnehmung unserer Aufgaben und Erbringung unserer Leistungen dienen. Die Löschung der Daten im Hinblick auf vertragliche Leistungen und die vertragliche Kommunikation entspricht den, bei diesen Verarbeitungstätigkeiten genannten Angaben.<br>
        <br>
        Wir offenbaren oder übermitteln hierbei Daten an die Finanzverwaltung, Berater, wie z.B., Steuerberater oder Wirtschaftsprüfer sowie weitere Gebührenstellen und Zahlungsdienstleister.<br>
        <br>
        Ferner speichern wir auf Grundlage unserer betriebswirtschaftlichen Interessen Angaben zu Lieferanten, Veranstaltern und sonstigen Geschäftspartnern, z.B. zwecks späterer Kontaktaufnahme. Diese mehrheitlich unternehmensbezogenen Daten, speichern wir grundsätzlich dauerhaft.<br>
        </span></p><p></p><h3 id="dsg-businessanalysis">Betriebswirtschaftliche Analysen und Marktforschung</h3><p></p><p><span class="ts-muster-content">Um unser Geschäft wirtschaftlich betreiben, Markttendenzen, Wünsche der Vertragspartner und Nutzer erkennen zu können, analysieren wir die uns vorliegenden Daten zu Geschäftsvorgängen, Verträgen, Anfragen, etc. Wir verarbeiten dabei Bestandsdaten, Kommunikationsdaten, Vertragsdaten, Zahlungsdaten, Nutzungsdaten, Metadaten auf Grundlage des Art. 6 Abs. 1 lit. f. DSGVO, wobei zu den betroffenen Personen Vertragspartner, Interessenten, Kunden, Besucher und Nutzer unseres Onlineangebotes gehören. <br>
        <br>
        Die Analysen erfolgen zum Zweck betriebswirtschaftlicher Auswertungen, des Marketings und der Marktforschung. Dabei können wir die Profile der registrierten Nutzer mit Angaben, z.B. zu deren in Anspruch genommenen Leistungen, berücksichtigen. Die Analysen dienen uns zur Steigerung der Nutzerfreundlichkeit, der Optimierung unseres Angebotes und der Betriebswirtschaftlichkeit. Die Analysen dienen alleine uns und werden nicht extern offenbart, sofern es sich nicht um anonyme Analysen mit zusammengefassten Werten handelt. <br>
        <br>
        Sofern diese Analysen oder Profile personenbezogen sind, werden sie mit Kündigung der Nutzer gelöscht oder anonymisiert, sonst nach zwei Jahren ab Vertragsschluss. Im Übrigen werden die gesamtbetriebswirtschaftlichen Analysen und allgemeine Tendenzbestimmungen nach Möglichkeit anonym erstellt.<br>
        </span></p><p></p><h3 id="dsg-affiliate-amazon">Amazon-Partnerprogramm</h3><p></p><p><span class="ts-muster-content">Wir sind auf Grundlage unserer berechtigten Interessen (d.h. Interesse am wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) Teilnehmer des Partnerprogramms von Amazon EU, das zur Bereitstellung eines Mediums für Websites konzipiert wurde, mittels dessen durch die Platzierung von Werbeanzeigen und Links zu Amazon.de Werbekostenerstattung verdient werden kann (sog. Affiliate-System). D.h. als Amazon-Partner verdienen wir an qualifizierten Käufen.<br>
        <br>
        Amazon setzt Cookies ein, um die Herkunft der Bestellungen nachvollziehen zu können. Unter anderem kann Amazon erkennen, dass Sie den Partnerlink auf dieser Website geklickt und anschließend ein Produkt bei Amazon erworben haben.<br>
        <br>
        Weitere Informationen zur Datennutzung durch Amazon und Widerspruchsmöglichkeiten erhalten Sie in der Datenschutzerklärung des Unternehmens: <a target="_blank" href="https://www.amazon.de/gp/help/customer/display.html?nodeId=201909010">https://www.amazon.de/gp/help/customer/display.html?nodeId=201909010</a>.<br>
        <br>
        Hinweis: Amazon und das Amazon-Logo sind Warenzeichen von Amazon.com, Inc. oder eines seiner verbundenen Unternehmen.</span></p><p></p><h3 id="dsg-job-candidate">Datenschutzhinweise im Bewerbungsverfahren</h3><p></p><p><span class="ts-muster-content">Wir verarbeiten die Bewerberdaten nur zum Zweck und im Rahmen des Bewerbungsverfahrens im Einklang mit den gesetzlichen Vorgaben. Die Verarbeitung der Bewerberdaten erfolgt zur Erfüllung unserer (vor)vertraglichen Verpflichtungen im Rahmen des Bewerbungsverfahrens im Sinne des Art. 6 Abs. 1 lit. b. DSGVO  Art. 6 Abs. 1 lit. f. DSGVO sofern die Datenverarbeitung z.B. im Rahmen von rechtlichen Verfahren für uns erforderlich wird (in Deutschland gilt zusätzlich § 26 BDSG).<br>
        <br>
        Das Bewerbungsverfahren setzt voraus, dass Bewerber uns die Bewerberdaten mitteilen. Die notwendigen Bewerberdaten sind, sofern wir ein Onlineformular anbieten gekennzeichnet, ergeben sich sonst aus den Stellenbeschreibungen und grundsätzlich gehören dazu die Angaben zur Person, Post- und Kontaktadressen und die zur Bewerbung gehörenden Unterlagen, wie Anschreiben, Lebenslauf und die Zeugnisse. Daneben können uns Bewerber freiwillig zusätzliche Informationen mitteilen.<br>
        <br>
        Mit der Übermittlung der Bewerbung an uns, erklären sich die Bewerber mit der Verarbeitung ihrer Daten zu Zwecken des Bewerbungsverfahrens entsprechend der in dieser Datenschutzerklärung dargelegten Art und Umfang einverstanden.<br>
        <br>
        Soweit im Rahmen des Bewerbungsverfahrens freiwillig besondere Kategorien von personenbezogenen Daten im Sinne des Art. 9 Abs. 1 DSGVO mitgeteilt werden, erfolgt deren Verarbeitung zusätzlich nach Art. 9 Abs. 2 lit. b DSGVO (z.B. Gesundheitsdaten, wie z.B. Schwerbehinderteneigenschaft oder ethnische Herkunft). Soweit im Rahmen des Bewerbungsverfahrens besondere Kategorien von personenbezogenen Daten im Sinne des Art. 9 Abs. 1 DSGVO bei Bewerbern angefragt werden, erfolgt deren Verarbeitung zusätzlich nach Art. 9 Abs. 2 lit. a DSGVO (z.B. Gesundheitsdaten, wenn diese für die Berufsausübung erforderlich sind).<br>
        <br>
        Sofern zur Verfügung gestellt, können uns Bewerber ihre Bewerbungen mittels eines Onlineformulars auf unserer Website übermitteln. Die Daten werden entsprechend dem Stand der Technik verschlüsselt an uns übertragen.<br>
        Ferner können Bewerber uns ihre Bewerbungen via E-Mail übermitteln. Hierbei bitten wir jedoch zu beachten, dass E-Mails grundsätzlich nicht verschlüsselt versendet werden und die Bewerber selbst für die Verschlüsselung sorgen müssen. Wir können daher für den Übertragungsweg der Bewerbung zwischen dem Absender und dem Empfang auf unserem Server keine Verantwortung übernehmen und empfehlen daher eher ein Online-Formular oder den postalischen Versand zu nutzen. Denn statt der Bewerbung über das Online-Formular und E-Mail, steht den Bewerbern weiterhin die Möglichkeit zur Verfügung, uns die Bewerbung auf dem Postweg zuzusenden.<br>
        <br>
         Die von den Bewerbern zur Verfügung gestellten Daten, können im Fall einer erfolgreichen Bewerbung für die Zwecke des Beschäftigungsverhältnisses von uns weiterverarbeitet werden. Andernfalls, sofern die Bewerbung auf ein Stellenangebot nicht erfolgreich ist, werden die Daten der Bewerber gelöscht. Die Daten der Bewerber werden ebenfalls gelöscht, wenn eine Bewerbung zurückgezogen wird, wozu die Bewerber jederzeit berechtigt sind.<br>
        <br>
         Die Löschung erfolgt, vorbehaltlich eines berechtigten Widerrufs der Bewerber, nach dem Ablauf eines Zeitraums von sechs Monaten, damit wir etwaige Anschlussfragen zu der Bewerbung beantworten und unseren Nachweispflichten aus dem Gleichbehandlungsgesetz genügen können. Rechnungen über etwaige Reisekostenerstattung werden entsprechend den steuerrechtlichen Vorgaben archiviert.<br>
        </span></p><p></p><h3 id="dsg-job-talentpool">Talent-Pool</h3><p></p><p><span class="ts-muster-content">Im Rahmen der Bewerbung bieten wir den Bewerbern die Möglichkeit an, in unseren „Talent-Pool“ für einen Zeitraum von zwei Jahren auf Grundlage einer Einwilligung im Sinne der Art. 6 Abs. 1 lit. a. und Art. 7 DSGVO aufgenommen zu werden. <br>
        <br>
        Die Bewerbungsunterlagen im Talent-Pool werden alleine im Rahmen von künftigen Stellenausschreibungen und der Beschäftigtensuche verarbeitet und werden spätestens nach Ablauf der Frist vernichtet. Die Bewerber werden darüber belehrt, dass deren Einwilligung in die Aufnahme in den Talent-Pool freiwillig ist, keinen Einfluss auf das aktuelle Bewerbungsverfahren hat und sie diese Einwilligung jederzeit für die Zukunft widerrufen sowie Widerspruch im Sinne des Art. 21 DSGVO erklären können.</span></p><p></p><h3 id="dsg-registration">Registrierfunktion</h3><p></p><p><span class="ts-muster-content">Nutzer können ein Nutzerkonto anlegen. Im Rahmen der Registrierung werden die erforderlichen Pflichtangaben den Nutzern mitgeteilt und auf Grundlage des Art. 6 Abs. 1 lit. b DSGVO zu Zwecken der Bereitstellung des Nutzerkontos verarbeitet. Zu den verarbeiteten Daten gehören insbesondere die Login-Informationen (Name, Passwort sowie eine E-Mailadresse). Die im Rahmen der Registrierung eingegebenen Daten werden für die Zwecke der Nutzung des Nutzerkontos und dessen Zwecks verwendet. <br>
        <br>
        Die Nutzer können über Informationen, die für deren Nutzerkonto relevant sind, wie z.B. technische Änderungen, per E-Mail informiert werden. Wenn Nutzer ihr Nutzerkonto gekündigt haben, werden deren Daten im Hinblick auf das Nutzerkonto, vorbehaltlich einer gesetzlichen Aufbewahrungspflicht, gelöscht. Es obliegt den Nutzern, ihre Daten bei erfolgter Kündigung vor dem Vertragsende zu sichern. Wir sind berechtigt, sämtliche während der Vertragsdauer gespeicherten Daten des Nutzers unwiederbringlich zu löschen.<br>
        <br>
        Im Rahmen der Inanspruchnahme unserer Registrierungs- und Anmeldefunktionen sowie der Nutzung des Nutzerkontos, speichern wir die IP-Adresse und den Zeitpunkt der jeweiligen Nutzerhandlung. Die Speicherung erfolgt auf Grundlage unserer berechtigten Interessen, als auch der Nutzer an Schutz vor Missbrauch und sonstiger unbefugter Nutzung. Eine Weitergabe dieser Daten an Dritte erfolgt grundsätzlich nicht, außer sie ist zur Verfolgung unserer Ansprüche erforderlich oder es besteht hierzu besteht eine gesetzliche Verpflichtung gem. Art. 6 Abs. 1 lit. c. DSGVO. Die IP-Adressen werden spätestens nach 7 Tagen anonymisiert oder gelöscht.<br>
        </span></p><p></p><h3 id="dsg-gravatar">Abruf von Profilbildern bei Gravatar</h3><p></p><p><span class="ts-muster-content">Wir setzen innerhalb unseres Onlineangebotes und insbesondere im Blog den Dienst Gravatar der Automattic Inc., 60 29th Street #343, San Francisco, CA 94110, USA, ein.<br>
        <br>
        Gravatar ist ein Dienst, bei dem sich Nutzer anmelden und Profilbilder und ihre E-Mailadressen hinterlegen können. Wenn Nutzer mit der jeweiligen E-Mailadresse auf anderen Onlinepräsenzen (vor allem in Blogs) Beiträge oder Kommentare hinterlassen, können so deren Profilbilder neben den Beiträgen oder Kommentaren dargestellt werden. Hierzu wird die von den Nutzern mitgeteilte E-Mailadresse an Gravatar zwecks Prüfung, ob zu ihr ein Profil gespeichert ist, verschlüsselt übermittelt. Dies ist der einzige Zweck der Übermittlung der E-Mailadresse und sie wird nicht für andere Zwecke verwendet, sondern danach gelöscht.<br>
        <br>
        Die Nutzung von Gravatar erfolgt auf Grundlage unserer berechtigten Interessen im Sinne des Art. 6 Abs. 1 lit. f) DSGVO, da wir mit Hilfe von Gravatar den Beitrags- und Kommentarverfassern die Möglichkeit bieten ihre Beiträge mit einem Profilbild zu personalisieren.<br>
        <br>
        Durch die Anzeige der Bilder bringt Gravatar die IP-Adresse der Nutzer in Erfahrung, da dies für eine Kommunikation zwischen einem Browser und einem Onlineservice notwendig ist. Nähere Informationen zur Erhebung und Nutzung der Daten durch Gravatar finden sich in den Datenschutzhinweisen von Automattic: <a target="_blank" href="https://automattic.com/privacy/">https://automattic.com/privacy/</a>.<br>
        <br>
        Wenn Nutzer nicht möchten, dass ein mit Ihrer E-Mail-Adresse bei Gravatar verknüpftes Benutzerbild in den Kommentaren erscheint, sollten Sie zum Kommentieren eine E-Mail-Adresse nutzen, welche nicht bei Gravatar hinterlegt ist. Wir weisen ferner darauf hin, dass es auch möglich ist eine anonyme oder gar keine E-Mailadresse zu verwenden, falls die Nutzer nicht wünschen, dass die eigene E-Mailadresse an Gravatar übersendet wird. Nutzer können die Übertragung der Daten komplett verhindern, indem Sie unser Kommentarsystem nicht nutzen.</span></p><p></p><h3 id="dsg-contact">Kontaktaufnahme</h3><p></p><p><span class="ts-muster-content">Bei der Kontaktaufnahme mit uns (z.B. per Kontaktformular, E-Mail, Telefon oder via sozialer Medien) werden die Angaben des Nutzers zur Bearbeitung der Kontaktanfrage und deren Abwicklung gem. Art. 6 Abs. 1 lit. b. (im Rahmen vertraglicher-/vorvertraglicher Beziehungen),  Art. 6 Abs. 1 lit. f. (andere Anfragen) DSGVO verarbeitet.. Die Angaben der Nutzer können in einem Customer-Relationship-Management System ("CRM System") oder vergleichbarer Anfragenorganisation gespeichert werden.<br>
        <br>
        Wir löschen die Anfragen, sofern diese nicht mehr erforderlich sind. Wir überprüfen die Erforderlichkeit alle zwei Jahre; Ferner gelten die gesetzlichen Archivierungspflichten.</span></p><p></p><h3 id="dsg-newsletter-de">Newsletter</h3><p></p><p><span class="ts-muster-content">Mit den nachfolgenden Hinweisen informieren wir Sie über die Inhalte unseres Newsletters sowie das Anmelde-, Versand- und das statistische Auswertungsverfahren sowie Ihre Widerspruchsrechte auf. Indem Sie unseren Newsletter abonnieren, erklären Sie sich mit dem Empfang und den beschriebenen Verfahren einverstanden.<br>
        <br>
        Inhalt des Newsletters: Wir versenden Newsletter, E-Mails und weitere elektronische Benachrichtigungen mit werblichen Informationen (nachfolgend „Newsletter“) nur mit der Einwilligung der Empfänger oder einer gesetzlichen Erlaubnis. Sofern im Rahmen einer Anmeldung zum Newsletter dessen Inhalte konkret umschrieben werden, sind sie für die Einwilligung der Nutzer maßgeblich. Im Übrigen enthalten unsere Newsletter Informationen zu unseren Leistungen und uns.<br>
        <br>
        Double-Opt-In und Protokollierung: Die Anmeldung zu unserem Newsletter erfolgt in einem sog. Double-Opt-In-Verfahren. D.h. Sie erhalten nach der Anmeldung eine E-Mail, in der Sie um die Bestätigung Ihrer Anmeldung gebeten werden. Diese Bestätigung ist notwendig, damit sich niemand mit fremden E-Mailadressen anmelden kann. Die Anmeldungen zum Newsletter werden protokolliert, um den Anmeldeprozess entsprechend den rechtlichen Anforderungen nachweisen zu können. Hierzu gehört die Speicherung des Anmelde- und des Bestätigungszeitpunkts, als auch der IP-Adresse. Ebenso werden die Änderungen Ihrer bei dem Versanddienstleister gespeicherten Daten protokolliert.<br>
        <br>
        Anmeldedaten: Um sich für den Newsletter anzumelden, reicht es aus, wenn Sie Ihre E-Mailadresse angeben. Optional bitten wir Sie einen Namen, zwecks persönlicher Ansprache im Newsletters anzugeben.<br>
        <br>
        Der Versand des Newsletters und die mit ihm verbundene Erfolgsmessung erfolgen auf Grundlage einer Einwilligung der Empfänger gem. Art. 6 Abs. 1 lit. a, Art. 7 DSGVO i.V.m § 7 Abs. 2 Nr. 3 UWG oder falls eine Einwilligung nicht erforderlich ist, auf Grundlage unserer berechtigten Interessen am Direktmarketing gem. Art. 6 Abs. 1 lt. f. DSGVO i.V.m. § 7 Abs. 3 UWG. <br>
        <br>
        Die Protokollierung des Anmeldeverfahrens erfolgt auf Grundlage unserer berechtigten Interessen gem. Art. 6 Abs. 1 lit. f DSGVO. Unser Interesse richtet sich auf den Einsatz eines nutzerfreundlichen sowie sicheren Newslettersystems, das sowohl unseren geschäftlichen Interessen dient, als auch den Erwartungen der Nutzer entspricht und uns ferner den Nachweis von Einwilligungen erlaubt.<br>
        <br>
        Kündigung/Widerruf - Sie können den Empfang unseres Newsletters jederzeit kündigen, d.h. Ihre Einwilligungen widerrufen. Einen Link zur Kündigung des Newsletters finden Sie am Ende eines jeden Newsletters. Wir können die ausgetragenen E-Mailadressen bis zu drei Jahren auf Grundlage unserer berechtigten Interessen speichern bevor wir sie löschen, um eine ehemals gegebene Einwilligung nachweisen zu können. Die Verarbeitung dieser Daten wird auf den Zweck einer möglichen Abwehr von Ansprüchen beschränkt. Ein individueller Löschungsantrag ist jederzeit möglich, sofern zugleich das ehemalige Bestehen einer Einwilligung bestätigt wird.</span></p><p></p><h3 id="dsg-newsletter-at">Newsletter</h3><p></p><p><span class="ts-muster-content">Mit den nachfolgenden Hinweisen informieren wir Sie über die Inhalte unseres Newsletters sowie das Anmelde-, Versand- und das statistische Auswertungsverfahren sowie Ihre Widerspruchsrechte auf. Indem Sie unseren Newsletter abonnieren, erklären Sie sich mit dem Empfang und den beschriebenen Verfahren einverstanden.<br>
        <br>
        Inhalt des Newsletters: Wir versenden Newsletter, E-Mails und weitere elektronische Benachrichtigungen mit werblichen Informationen (nachfolgend „Newsletter“) nur mit der Einwilligung der Empfänger oder einer gesetzlichen Erlaubnis. Sofern im Rahmen einer Anmeldung zum Newsletter dessen Inhalte konkret umschrieben werden, sind sie für die Einwilligung der Nutzer maßgeblich. Im Übrigen enthalten unsere Newsletter Informationen zu unseren Produkten und sie begleitenden Informationen (z.B. Sicherheitshinweise), Angeboten, Aktionen und unser Unternehmen.<br>
        <br>
        Double-Opt-In und Protokollierung: Die Anmeldung zu unserem Newsletter erfolgt in einem sog. Double-Opt-In-Verfahren. D.h. Sie erhalten nach der Anmeldung eine E-Mail, in der Sie um die Bestätigung Ihrer Anmeldung gebeten werden. Diese Bestätigung ist notwendig, damit sich niemand mit fremden E-Mailadressen anmelden kann. Die Anmeldungen zum Newsletter werden protokolliert, um den Anmeldeprozess entsprechend den rechtlichen Anforderungen nachweisen zu können. Hierzu gehört die Speicherung des Anmelde- und des Bestätigungszeitpunkts, als auch der IP-Adresse. Ebenso werden die Änderungen Ihrer bei dem Versanddienstleister gespeicherten Daten protokolliert.<br>
        <br>
        Anmeldedaten: Um sich für den Newsletter anzumelden, reicht es aus, wenn Sie Ihre E-Mailadresse angeben. Optional bitten wir Sie einen Namen, zwecks persönlicher Ansprache im Newsletters anzugeben.<br>
        <br>
        Der Versand des Newsletters und die mit ihm verbundene Erfolgsmessung erfolgen auf Grundlage einer Einwilligung der Empfänger gem. Art. 6 Abs. 1 lit. a, Art. 7 DSGVO i.V.m § 107 Abs. 2 TKG oder falls eine Einwilligung nicht erforderlich ist, auf Grundlage unserer berechtigten Interessen am Direktmarketing gem. Art. 6 Abs. 1 lt. f. DSGVO i.V.m. § 107 Abs. 2 u. 3 TKG.<br>
        <br>
        Die Protokollierung des Anmeldeverfahrens erfolgt auf Grundlage unserer berechtigten Interessen gem. Art. 6 Abs. 1 lit. f DSGVO. Unser Interesse richtet sich auf den Einsatz eines nutzerfreundlichen sowie sicheren Newslettersystems, das sowohl unseren geschäftlichen Interessen dient, als auch den Erwartungen der Nutzer entspricht und uns ferner den Nachweis von Einwilligungen erlaubt.<br>
        <br>
        Kündigung/Widerruf - Sie können den Empfang unseres Newsletters jederzeit kündigen, d.h. Ihre Einwilligungen widerrufen. Einen Link zur Kündigung des Newsletters finden Sie am Ende eines jeden Newsletters. Wir können die ausgetragenen E-Mailadressen bis zu drei Jahren auf Grundlage unserer berechtigten Interessen speichern bevor wir sie löschen, um eine ehemals gegebene Einwilligung nachweisen zu können. Die Verarbeitung dieser Daten wird auf den Zweck einer möglichen Abwehr von Ansprüchen beschränkt. Ein individueller Löschungsantrag ist jederzeit möglich, sofern zugleich das ehemalige Bestehen einer Einwilligung bestätigt wird.<br>
        <br>
        </span></p><p></p><h3 id="dsg-newsletter-analytics">Newsletter - Erfolgsmessung</h3><p></p><p><span class="ts-muster-content">Die Newsletter enthalten einen sog. „web-beacon“, d.h. eine pixelgroße Datei, die beim Öffnen des Newsletters von unserem Server, bzw. sofern wir einen Versanddienstleister einsetzen, von dessen Server abgerufen wird. Im Rahmen dieses Abrufs werden zunächst technische Informationen, wie Informationen zum Browser und Ihrem System, als auch Ihre IP-Adresse und Zeitpunkt des Abrufs erhoben. <br>
        <br>
        Diese Informationen werden zur technischen Verbesserung der Services anhand der technischen Daten oder der Zielgruppen und ihres Leseverhaltens anhand derer Abruforte (die mit Hilfe der IP-Adresse bestimmbar sind) oder der Zugriffszeiten genutzt. Zu den statistischen Erhebungen gehört ebenfalls die Feststellung, ob die Newsletter geöffnet werden, wann sie geöffnet werden und welche Links geklickt werden. Diese Informationen können aus technischen Gründen zwar den einzelnen Newsletterempfängern zugeordnet werden. Es ist jedoch weder unser Bestreben, noch, sofern eingesetzt, das des Versanddienstleisters, einzelne Nutzer zu beobachten. Die Auswertungen dienen uns viel mehr dazu, die Lesegewohnheiten unserer Nutzer zu erkennen und unsere Inhalte auf sie anzupassen oder unterschiedliche Inhalte entsprechend den Interessen unserer Nutzer zu versenden.<br>
        <br>
        Ein getrennter Widerruf der Erfolgsmessung ist leider nicht möglich, in diesem Fall muss das gesamte Newsletterabonnement gekündigt werden. </span></p><p></p><h3 id="dsg-hostingprovider">Hosting und E-Mail-Versand</h3><p></p><p><span class="ts-muster-content">Die von uns in Anspruch genommenen Hosting-Leistungen dienen der Zurverfügungstellung der folgenden Leistungen: Infrastruktur- und Plattformdienstleistungen, Rechenkapazität, Speicherplatz und Datenbankdienste, E-Mail-Versand, Sicherheitsleistungen sowie technische Wartungsleistungen, die wir zum Zwecke des Betriebs dieses Onlineangebotes einsetzen. <br>
        <br>
        Hierbei verarbeiten wir, bzw. unser Hostinganbieter Bestandsdaten, Kontaktdaten, Inhaltsdaten, Vertragsdaten, Nutzungsdaten, Meta- und Kommunikationsdaten von Kunden, Interessenten und Besuchern dieses Onlineangebotes auf Grundlage unserer berechtigten Interessen an einer effizienten und sicheren Zurverfügungstellung dieses Onlineangebotes gem. Art. 6 Abs. 1 lit. f DSGVO i.V.m. Art. 28 DSGVO (Abschluss Auftragsverarbeitungsvertrag).</span></p><p></p><h3 id="dsg-logfiles">Erhebung von Zugriffsdaten und Logfiles</h3><p></p><p><span class="ts-muster-content">Wir, bzw. unser Hostinganbieter, erhebt auf Grundlage unserer berechtigten Interessen im Sinne des Art. 6 Abs. 1 lit. f. DSGVO Daten über jeden Zugriff auf den Server, auf dem sich dieser Dienst befindet (sogenannte Serverlogfiles). Zu den Zugriffsdaten gehören Name der abgerufenen Webseite, Datei, Datum und Uhrzeit des Abrufs, übertragene Datenmenge, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite), IP-Adresse und der anfragende Provider.<br>
        <br>
        Logfile-Informationen werden aus Sicherheitsgründen (z.B. zur Aufklärung von Missbrauchs- oder Betrugshandlungen) für die Dauer von maximal 7 Tagen gespeichert und danach gelöscht. Daten, deren weitere Aufbewahrung zu Beweiszwecken erforderlich ist, sind bis zur endgültigen Klärung des jeweiligen Vorfalls von der Löschung ausgenommen.</span></p><p></p><h3 id="dsg-tracking-tagmanager">Google Tag Manager</h3><p></p><p><span class="ts-muster-content">Google Tag Manager ist eine Lösung, mit der wir sog. Website-Tags über eine Oberfläche verwalten können (und so z.B. Google Analytics sowie andere Google-Marketing-Dienste in unser Onlineangebot einbinden). Der Tag Manager selbst (welches die Tags implementiert) verarbeitet keine personenbezogenen Daten der Nutzer. Im Hinblick auf die Verarbeitung der personenbezogenen Daten der Nutzer wird auf die folgenden Angaben zu den Google-Diensten verwiesen. Nutzungsrichtlinien: <a target="_blank" href="https://www.google.com/intl/de/tagmanager/use-policy.html">https://www.google.com/intl/de/tagmanager/use-policy.html</a>.<br>
        </span></p><p></p><h3 id="dsg-ga-googleanalytics">Google Analytics</h3><p></p><p><span class="ts-muster-content">Wir setzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) Google Analytics, einen Webanalysedienst der Google LLC („Google“) ein. Google verwendet Cookies. Die durch das Cookie erzeugten Informationen über Benutzung des Onlineangebotes durch die Nutzer werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert.<br>
        <br>
        Google ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active</a>).<br>
        <br>
        Google wird diese Informationen in unserem Auftrag benutzen, um die Nutzung unseres Onlineangebotes durch die Nutzer auszuwerten, um Reports über die Aktivitäten innerhalb dieses Onlineangebotes zusammenzustellen und um weitere, mit der Nutzung dieses Onlineangebotes und der Internetnutzung verbundene Dienstleistungen, uns gegenüber zu erbringen. Dabei können aus den verarbeiteten Daten pseudonyme Nutzungsprofile der Nutzer erstellt werden.<br>
        <br>
        Wir setzen Google Analytics nur mit aktivierter IP-Anonymisierung ein. Das bedeutet, die IP-Adresse der Nutzer wird von Google innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt.<br>
        <br>
        Die von dem Browser des Nutzers übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt. Die Nutzer können die Speicherung der Cookies durch eine entsprechende Einstellung ihrer Browser-Software verhindern; die Nutzer können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf ihre Nutzung des Onlineangebotes bezogenen Daten an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem sie das unter folgendem Link verfügbare Browser-Plugin herunterladen und installieren:&nbsp;<a target="_blank" href="http://tools.google.com/dlpage/gaoptout?hl=de">http://tools.google.com/dlpage/gaoptout?hl=de</a>.<br>
        <br>
        Weitere Informationen zur Datennutzung durch Google, Einstellungs- und Widerspruchsmöglichkeiten, erfahren Sie in der Datenschutzerklärung von Google (<a target="_blank" href="https://policies.google.com/privacy">https://policies.google.com/privacy</a>) sowie in den Einstellungen für die Darstellung von Werbeeinblendungen durch Google <a target="_blank" href="https://adssettings.google.com/authenticated">(https://adssettings.google.com/authenticated</a>).<br>
        <br>
        Die personenbezogenen Daten der Nutzer werden nach 14 Monaten gelöscht oder anonymisiert.</span></p><p></p><h3 id="dsg-ga-universal">Google Universal Analytics</h3><p></p><p><span class="ts-muster-content">Wir setzen Google Analytics in der Ausgestaltung als „<a target="_blank" href="https://support.google.com/analytics/answer/2790010?hl=de&amp;ref_topic=6010376">Universal-Analytics</a>“ ein. „Universal Analytics“ bezeichnet ein Verfahren von Google Analytics, bei dem die Nutzeranalyse auf Grundlage einer pseudonymen Nutzer-ID erfolgt und damit ein pseudonymes Profil des Nutzers mit Informationen aus der Nutzung verschiedener Geräten erstellt wird (sog. „Cross-Device-Tracking“).</span></p><p></p><h3 id="dsg-ga-audiences">Zielgruppenbildung mit Google Analytics</h3><p></p><p><span class="ts-muster-content">Wir setzen Google Analytics ein, um die durch innerhalb von Werbediensten Googles und seiner Partner geschalteten Anzeigen, nur solchen Nutzern anzuzeigen, die auch ein Interesse an unserem Onlineangebot gezeigt haben oder die bestimmte Merkmale (z.B. Interessen an bestimmten Themen oder Produkten, die anhand der besuchten Webseiten bestimmt werden) aufweisen, die wir an Google übermitteln (sog. „Remarketing-“, bzw. „Google-Analytics-Audiences“). Mit Hilfe der Remarketing Audiences möchten wir auch sicherstellen, dass unsere Anzeigen dem potentiellen Interesse der Nutzer entsprechen.<br>
        </span></p><p></p><h3 id="dsg-tracking-adsense-personalized">Google Adsense mit personalisierten Anzeigen</h3><p></p><p><span class="ts-muster-content">Wir nutzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) die Dienste der Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, („Google“).<br>
        <br>
        Google ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active</a>).<br>
        <br>
        Wir Nutzen den Dienst AdSense, mit dessen Hilfe Anzeigen in unsere Webseite eingeblendet und wir für deren Einblendung oder sonstige Nutzung eine Entlohnung erhalten. Zu diesen Zwecken werden Nutzungsdaten, wie z.B. der Klick auf eine Anzeige und die IP-Adresse der Nutzer verarbeitet, wobei die IP-Adresse um die letzten beiden Stellen gekürzt wird. Daher erfolgt die Verarbeitung der Daten der Nutzer pseudonymisiert. <br>
        <br>
        Wir setzen Adsense mit personalisierten Anzeigen ein. Dabei zieht Google auf Grundlage der von Nutzern besuchten Websites oder verwendeten Apps und den so erstellten Nutzerprofilen Rückschlüsse auf deren Interessen. Werbetreibende nutzen diese Informationen, um ihre Kampagnen an diesen Interessen auszurichten, was für Nutzer und Werbetreibende gleichermaßen von Vorteil ist. Für Google sind Anzeigen dann personalisiert, wenn erfasste oder bekannte Daten die Anzeigenauswahl bestimmen oder beeinflussen. Dazu zählen unter anderem frühere Suchanfragen, Aktivitäten, Websitebesuche, die Verwendung von Apps, demografische und Standortinformationen. Im Einzelnen umfasst dies: demografisches Targeting, Targeting auf Interessenkategorien, Remarketing sowie Targeting auf Listen zum Kundenabgleich und Zielgruppenlisten, die in DoubleClick Bid Manager oder Campaign Manager hochgeladen wurden.<br>
        <br>
        Weitere Informationen zur Datennutzung durch Google, Einstellungs- und Widerspruchsmöglichkeiten, erfahren Sie in der Datenschutzerklärung von Google (<a target="_blank" href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a>) sowie in den Einstellungen für die Darstellung von Werbeeinblendungen durch Google <a target="_blank" href="https://adssettings.google.com/authenticated">(https://adssettings.google.com/authenticated</a>).<br>
        </span></p><p></p><h3 id="dsg-tracking-adsense-nonpersonalized">Google Adsense mit nicht-personalisierten Anzeigen</h3><p></p><p><span class="ts-muster-content">Wir nutzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) die Dienste der Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, („Google“).<br>
        <br>
        Google ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active).<br>
        <br>
        Wir Nutzen den Dienst AdSense, mit dessen Hilfe Anzeigen in unsere Webseite eingeblendet und wir für deren Einblendung oder sonstige Nutzung eine Entlohnung erhalten. Zu diesen Zwecken werden Nutzungsdaten, wie z.B. der Klick auf eine Anzeige und die IP-Adresse der Nutzer verarbeitet, wobei die IP-Adresse um die letzten beiden Stellen gekürzt wird. Daher erfolgt die Verarbeitung der Daten der Nutzer pseudonymisiert. <br>
        <br>
        Wir setzen Adsense mit nicht-personalisierten Anzeigen ein. Dabei werden die Anzeigen nicht auf Grundlage von Nutzerprofilen angezeigt. Nicht personalisierte Anzeigen basieren nicht auf früherem Nutzerverhalten. Beim Targeting werden Kontextinformationen herangezogen, unter anderem ein grobes (z. B. auf Ortsebene) geografisches Targeting basierend auf dem aktuellen Standort, dem Inhalt auf der aktuellen Website oder der App sowie aktuelle Suchbegriffe. Google unterbindet jedwedes personalisierte Targeting, also auch demografisches Targeting und Targeting auf Basis von Nutzerlisten.<br>
        <br>
        Weitere Informationen zur Datennutzung durch Google, Einstellungs- und Widerspruchsmöglichkeiten, erfahren Sie in der Datenschutzerklärung von Google (<a target="_blank" href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a>) sowie in den Einstellungen für die Darstellung von Werbeeinblendungen durch Google <a target="_blank" href="https://adssettings.google.com/authenticated">(https://adssettings.google.com/authenticated</a>).</span></p><p></p><h3 id="dsg-tracking-adwords">Google AdWords und Conversion-Messung</h3><p></p><p><span class="ts-muster-content">Wir nutzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) die Dienste der Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, („Google“).<br>
        <br>
        Google ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active).<br>
        <br>
        Wir nutzen das Onlinemarketingverfahren Google "AdWords", um Anzeigen im Google-Werbe-Netzwerk zu platzieren (z.B., in Suchergebnissen, in Videos, auf Webseiten, etc.), damit sie Nutzern angezeigt werden, die ein mutmaßliches Interesse an den Anzeigen haben. Dies erlaubt uns Anzeigen für und innerhalb unseres Onlineangebotes gezielter anzuzeigen, um Nutzern nur Anzeigen zu präsentieren, die potentiell deren Interessen entsprechen. Falls einem Nutzer z.B. Anzeigen für Produkte angezeigt werden, für die er sich auf anderen Onlineangeboten interessiert hat, spricht man hierbei vom „Remarketing“. Zu diesen Zwecken wird bei Aufruf unserer und anderer Webseiten, auf denen das Google-Werbe-Netzwerk aktiv ist, unmittelbar durch Google ein Code von Google ausgeführt und es werden sog. (Re)marketing-Tags (unsichtbare Grafiken oder Code, auch als "Web Beacons" bezeichnet) in die Webseite eingebunden. Mit deren Hilfe wird auf dem Gerät der Nutzer ein individuelles Cookie, d.h. eine kleine Datei abgespeichert (statt Cookies können auch vergleichbare Technologien verwendet werden). In dieser Datei wird vermerkt, welche Webseiten der Nutzer aufgesucht, für welche Inhalte er sich interessiert und welche Angebote der Nutzer geklickt hat, ferner technische Informationen zum Browser und Betriebssystem, verweisende Webseiten, Besuchszeit sowie weitere Angaben zur Nutzung des Onlineangebotes.<br>
        <br>
        Ferner erhalten  wir ein individuelles „Conversion-Cookie“. Die mit Hilfe des Cookies eingeholten Informationen dienen Google dazu, Conversion-Statistiken für uns zu erstellen. Wir erfahren jedoch nur die anonyme Gesamtanzahl der Nutzer, die auf unsere Anzeige geklickt haben und zu einer mit einem Conversion-Tracking-Tag versehenen Seite weitergeleitet wurden. Wir erhalten jedoch keine Informationen, mit denen sich Nutzer persönlich identifizieren lassen.<br>
        <br>
        Die Daten der Nutzer werden im Rahmen des Google-Werbe-Netzwerks pseudonym verarbeitet. D.h. Google speichert und verarbeitet z.B. nicht den Namen oder E-Mailadresse der Nutzer, sondern verarbeitet die relevanten Daten cookie-bezogen innerhalb pseudonymer Nutzerprofile. D.h. aus der Sicht von Google werden die Anzeigen nicht für eine konkret identifizierte Person verwaltet und angezeigt, sondern für den Cookie-Inhaber, unabhängig davon wer dieser Cookie-Inhaber ist. Dies gilt nicht, wenn ein Nutzer Google ausdrücklich erlaubt hat, die Daten ohne diese Pseudonymisierung zu verarbeiten. Die über die Nutzer gesammelten Informationen werden an Google übermittelt und auf Googles Servern in den USA gespeichert.<br>
        <br>
        Weitere Informationen zur Datennutzung durch Google, Einstellungs- und Widerspruchsmöglichkeiten, erfahren Sie in der Datenschutzerklärung von Google (<a target="_blank" href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a>) sowie in den Einstellungen für die Darstellung von Werbeeinblendungen durch Google <a target="_blank" href="https://adssettings.google.com/authenticated">(https://adssettings.google.com/authenticated</a>).</span></p><p></p><h3 id="dsg-facebook-pixel">Facebook-Pixel, Custom Audiences und Facebook-Conversion</h3><p></p><p><span class="ts-muster-content">Innerhalb unseres Onlineangebotes wird aufgrund unserer berechtigten Interessen an Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes und zu diesen Zwecken das sog. "Facebook-Pixel" des sozialen Netzwerkes Facebook, welches von der Facebook Inc., 1 Hacker Way, Menlo Park, CA 94025, USA, bzw. falls Sie in der EU ansässig sind, Facebook Ireland Ltd., 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland betrieben wird ("Facebook"), eingesetzt.<br>
        <br>
        Facebook ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&amp;status=Active</a>).<br>
        <br>
        Mit Hilfe des Facebook-Pixels ist es Facebook zum einen möglich, die Besucher unseres Onlineangebotes als Zielgruppe für die Darstellung von Anzeigen (sog. "Facebook-Ads") zu bestimmen. Dementsprechend setzen wir das Facebook-Pixel ein, um die durch uns geschalteten Facebook-Ads nur solchen Facebook-Nutzern anzuzeigen, die auch ein Interesse an unserem Onlineangebot gezeigt haben oder die bestimmte Merkmale (z.B. Interessen an bestimmten Themen oder Produkten, die anhand der besuchten Webseiten bestimmt werden) aufweisen, die wir an Facebook übermitteln (sog. „Custom Audiences“). Mit Hilfe des Facebook-Pixels möchten wir auch sicherstellen, dass unsere Facebook-Ads dem potentiellen Interesse der Nutzer entsprechen und nicht belästigend wirken. Mit Hilfe des Facebook-Pixels können wir ferner die Wirksamkeit der Facebook-Werbeanzeigen für statistische und Marktforschungszwecke nachvollziehen, in dem wir sehen ob Nutzer nachdem Klick auf eine Facebook-Werbeanzeige auf unsere Website weitergeleitet wurden (sog. „Conversion“).<br>
        <br>
        Die Verarbeitung der Daten durch Facebook erfolgt im Rahmen von Facebooks Datenverwendungsrichtlinie. Dementsprechend generelle Hinweise zur Darstellung von Facebook-Ads, in der Datenverwendungsrichtlinie von Facebook:&nbsp;<a target="_blank" href="https://www.facebook.com/policy">https://www.facebook.com/policy</a>. Spezielle Informationen und Details zum Facebook-Pixel und seiner Funktionsweise erhalten Sie im Hilfebereich von Facebook: <a target="_blank" href="https://www.facebook.com/business/help/651294705016616">https://www.facebook.com/business/help/651294705016616</a>.<br>
        <br>
        Sie können der Erfassung durch den Facebook-Pixel und Verwendung Ihrer Daten zur Darstellung von Facebook-Ads widersprechen. Um einzustellen, welche Arten von Werbeanzeigen Ihnen innerhalb von Facebook angezeigt werden, können Sie die von Facebook eingerichtete Seite aufrufen und dort die Hinweise zu den Einstellungen nutzungsbasierter Werbung befolgen:&nbsp;<a target="_blank" href="https://www.facebook.com/settings?tab=ads">https://www.facebook.com/settings?tab=ads</a>. Die Einstellungen erfolgen plattformunabhängig, d.h. sie werden für alle Geräte, wie Desktopcomputer oder mobile Geräte übernommen.<br>
        <br>
        Sie können dem Einsatz von Cookies, die der Reichweitenmessung und Werbezwecken dienen, ferner über die Deaktivierungsseite der Netzwerkwerbeinitiative (<a target="_blank" href="http://optout.networkadvertising.org/">http://optout.networkadvertising.org/</a>) und zusätzlich die US-amerikanische Webseite&nbsp;(<a target="_blank" href="http://www.aboutads.info/choices">http://www.aboutads.info/choices</a>)&nbsp;oder die europäische Webseite&nbsp;(<a target="_blank" href="http://www.youronlinechoices.com/uk/your-ad-choices/">http://www.youronlinechoices.com/uk/your-ad-choices/</a>) widersprechen.</span></p><p></p><h3 id="dsg-socialmedia">Onlinepräsenzen in sozialen Medien</h3><p></p><p><span class="ts-muster-content">Wir unterhalten Onlinepräsenzen innerhalb sozialer Netzwerke und Plattformen, um mit den dort aktiven Kunden, Interessenten und Nutzern kommunizieren und sie dort über unsere Leistungen informieren zu können.<br>
        <br>
        Wir weisen darauf hin, dass dabei Daten der Nutzer außerhalb des Raumes der Europäischen Union verarbeitet werden können. Hierdurch können sich für die Nutzer Risiken ergeben, weil so z.B. die Durchsetzung der Rechte der Nutzer erschwert werden könnte. Im Hinblick auf US-Anbieter die unter dem Privacy-Shield zertifiziert sind, weisen wir darauf hin, dass sie sich damit verpflichten, die Datenschutzstandards der EU einzuhalten.<br>
        <br>
        Ferner werden die Daten der Nutzer im Regelfall für Marktforschungs- und Werbezwecke verarbeitet. So können z.B. aus dem Nutzungsverhalten und sich daraus ergebenden Interessen der Nutzer Nutzungsprofile erstellt werden. Die Nutzungsprofile können wiederum verwendet werden, um z.B. Werbeanzeigen innerhalb und außerhalb der Plattformen zu schalten, die mutmaßlich den Interessen der Nutzer entsprechen. Zu diesen Zwecken werden im Regelfall Cookies auf den Rechnern der Nutzer gespeichert, in denen das Nutzungsverhalten und die Interessen der Nutzer gespeichert werden. Ferner können in den Nutzungsprofilen auch Daten unabhängig der von den Nutzern verwendeten Geräte gespeichert werden (insbesondere wenn die Nutzer Mitglieder der jeweiligen Plattformen sind und bei diesen eingeloggt sind).<br>
        <br>
        Die Verarbeitung der personenbezogenen Daten der Nutzer erfolgt auf Grundlage unserer berechtigten Interessen an einer effektiven Information der Nutzer und Kommunikation mit den Nutzern gem. Art. 6 Abs. 1 lit. f. DSGVO. Falls die Nutzer von den jeweiligen Anbietern der Plattformen um eine Einwilligung in die vorbeschriebene Datenverarbeitung gebeten werden, ist die Rechtsgrundlage der Verarbeitung Art. 6 Abs. 1 lit. a., Art. 7 DSGVO.<br>
        <br>
        Für eine detaillierte Darstellung der jeweiligen Verarbeitungen und der Widerspruchsmöglichkeiten (Opt-Out), verweisen wir auf die nachfolgend verlinkten Angaben der Anbieter.<br>
        <br>
        Auch im Fall von Auskunftsanfragen und der Geltendmachung von Nutzerrechten, weisen wir darauf hin, dass diese am effektivsten bei den Anbietern geltend gemacht werden können. Nur die Anbieter haben jeweils Zugriff auf die Daten der Nutzer und können direkt entsprechende Maßnahmen ergreifen und Auskünfte geben. Sollten Sie dennoch Hilfe benötigen, dann können Sie sich an uns wenden.<br>
        <br>
        - Facebook, -Seiten, -Gruppen, (Facebook Ireland Ltd., 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland) auf Grundlage einer <a target="_blank" href="https://www.facebook.com/legal/terms/page_controller_addendum">Vereinbarung über gemeinsame Verarbeitung personenbezogener Daten</a> - Datenschutzerklärung: <a target="_blank" href="https://www.facebook.com/about/privacy/">https://www.facebook.com/about/privacy/</a>, speziell für Seiten: <a target="_blank" href="https://www.facebook.com/legal/terms/information_about_page_insights_data">https://www.facebook.com/legal/terms/information_about_page_insights_data</a> , Opt-Out: <a target="_blank" href="https://www.facebook.com/settings?tab=ads">https://www.facebook.com/settings?tab=ads</a> und <a target="_blank" href="http://www.youronlinechoices.com">http://www.youronlinechoices.com</a>, Privacy Shield: <a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&amp;status=Active</a>.<br>
        <br>
        - Google/ YouTube (Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA) – Datenschutzerklärung: &nbsp;<a target="_blank" href="https://policies.google.com/privacy">https://policies.google.com/privacy</a>, Opt-Out: <a target="_blank" href="https://adssettings.google.com/authenticated">https://adssettings.google.com/authenticated</a>, Privacy Shield: <a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active</a>.<br>
        <br>
        - Instagram (Instagram Inc., 1601 Willow Road, Menlo Park, CA, 94025, USA) – Datenschutzerklärung/ Opt-Out: <a target="_blank" href="http://instagram.com/about/legal/privacy/">http://instagram.com/about/legal/privacy/</a>.<br>
        <br>
        - Twitter (Twitter Inc., 1355 Market Street, Suite 900, San Francisco, CA 94103, USA) - Datenschutzerklärung: <a target="_blank" href="https://twitter.com/de/privacy">https://twitter.com/de/privacy</a>, Opt-Out: <a target="_blank" href="https://twitter.com/personalization">https://twitter.com/personalization</a>, Privacy Shield: <a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt0000000TORzAAO&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt0000000TORzAAO&amp;status=Active</a>.<br>
        <br>
        - Pinterest (Pinterest Inc., 635 High Street, Palo Alto, CA, 94301, USA) – Datenschutzerklärung/ Opt-Out: <a target="_blank" href="https://about.pinterest.com/de/privacy-policy">https://about.pinterest.com/de/privacy-policy</a>.<br>
        <br>
        - LinkedIn (LinkedIn Ireland Unlimited Company Wilton Place, Dublin 2, Irland) - Datenschutzerklärung <a target="_blank" href="https://www.linkedin.com/legal/privacy-policy">https://www.linkedin.com/legal/privacy-policy</a> , Opt-Out: <a target="_blank" href="https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out">https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out</a>, Privacy Shield:&nbsp;<a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt0000000L0UZAA0&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt0000000L0UZAA0&amp;status=Active</a>.<br>
        <br>
        - Xing (XING AG, Dammtorstraße 29-32, 20354 Hamburg, Deutschland) - Datenschutzerklärung/ Opt-Out: <a target="_blank" href="https://privacy.xing.com/de/datenschutzerklaerung">https://privacy.xing.com/de/datenschutzerklaerung</a>.<br>
        <br>
        - Wakalet (Wakelet Limited, 76 Quay Street, Manchester, M3 4PR, United Kingdom) - Datenschutzerklärung/ Opt-Out: <a target="_blank" href="https://wakelet.com/privacy.html">https://wakelet.com/privacy.html</a>.<br>
        <br>
        - Soundcloud (SoundCloud Limited, Rheinsberger Str. 76/77, 10115 Berlin, Deutschland) - Datenschutzerklärung/ Opt-Out: <a target="_blank" href="https://soundcloud.com/pages/privacy">https://soundcloud.com/pages/privacy</a>.</span></p><p></p><h3 id="dsg-thirdparty-einleitung">Einbindung von Diensten und Inhalten Dritter</h3><p></p><p><span class="ts-muster-content">Wir setzen innerhalb unseres Onlineangebotes auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) Inhalts- oder Serviceangebote von Drittanbietern ein, um deren Inhalte und Services, wie z.B. Videos oder Schriftarten einzubinden (nachfolgend einheitlich bezeichnet als “Inhalte”). <br>
        <br>
        Dies setzt immer voraus, dass die Drittanbieter dieser Inhalte, die IP-Adresse der Nutzer wahrnehmen, da sie ohne die IP-Adresse die Inhalte nicht an deren Browser senden könnten. Die IP-Adresse ist damit für die Darstellung dieser Inhalte erforderlich. Wir bemühen uns nur solche Inhalte zu verwenden, deren jeweilige Anbieter die IP-Adresse lediglich zur Auslieferung der Inhalte verwenden. Drittanbieter können ferner so genannte Pixel-Tags (unsichtbare Grafiken, auch als "Web Beacons" bezeichnet) für statistische oder Marketingzwecke verwenden. Durch die "Pixel-Tags" können Informationen, wie der Besucherverkehr auf den Seiten dieser Website ausgewertet werden. Die pseudonymen Informationen können ferner in Cookies auf dem Gerät der Nutzer gespeichert werden und unter anderem technische Informationen zum Browser und Betriebssystem, verweisende Webseiten, Besuchszeit sowie weitere Angaben zur Nutzung unseres Onlineangebotes enthalten, als auch mit solchen Informationen aus anderen Quellen verbunden werden.</span></p><p></p><h3 id="dsg-thirdparty-vimeo">Vimeo</h3><p></p><p><span class="ts-muster-content">Wir können die Videos der Plattform “Vimeo” des Anbieters Vimeo Inc., Attention: Legal Department, 555 West 18th Street New York, New York 10011, USA, einbinden. Datenschutzerklärung: <a target="_blank" href="https://vimeo.com/privacy">https://vimeo.com/privacy</a>.  Wir weisen darauf hin, dass Vimeo Google Analytics einsetzen kann und verweisen hierzu auf die Datenschutzerklärung (<a target="_blank" href="https://policies.google.com/privacy">https://policies.google.com/privacy</a>) sowie Opt-Out-Möglichkeiten für Google-Analytics (<a target="_blank" href="http://tools.google.com/dlpage/gaoptout?hl=de">http://tools.google.com/dlpage/gaoptout?hl=de</a>) oder die Einstellungen von Google für die Datennutzung zu Marketingzwecken (<a target="_blank" href="https://adssettings.google.com/">https://adssettings.google.com/</a>).</span></p><p></p><h3 id="dsg-thirdparty-youtube">Youtube</h3><p></p><p><span class="ts-muster-content">Wir binden die Videos der Plattform “YouTube” des Anbieters Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, ein. Datenschutzerklärung: <a target="_blank" href="https://www.google.com/policies/privacy/">https://www.google.com/policies/privacy/</a>, Opt-Out: <a target="_blank" href="https://adssettings.google.com/authenticated">https://adssettings.google.com/authenticated</a>.</span></p><p></p><h3 id="dsg-thirdparty-googlefonts">Google Fonts</h3><p></p><p><span class="ts-muster-content">Wir binden die Schriftarten ("Google Fonts") des Anbieters Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, ein. Datenschutzerklärung: <a target="_blank" href="https://www.google.com/policies/privacy/">https://www.google.com/policies/privacy/</a>, Opt-Out: <a target="_blank" href="https://adssettings.google.com/authenticated">https://adssettings.google.com/authenticated</a>.</span></p><p></p><h3 id="dsg-thirdparty-googlerecaptcha">Google ReCaptcha</h3><p></p><p><span class="ts-muster-content">Wir binden die Funktion zur Erkennung von Bots, z.B. bei Eingaben in Onlineformularen ("ReCaptcha") des Anbieters Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, ein. Datenschutzerklärung: <a target="_blank" href="https://www.google.com/policies/privacy/">https://www.google.com/policies/privacy/</a>, Opt-Out: <a target="_blank" href="https://adssettings.google.com/authenticated">https://adssettings.google.com/authenticated</a>.</span></p><p></p><h3 id="dsg-thirdparty-googlemaps">Google Maps</h3><p></p><p><span class="ts-muster-content">Wir binden die Landkarten des Dienstes “Google Maps” des Anbieters Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, ein. Zu den verarbeiteten Daten können insbesondere IP-Adressen und Standortdaten der Nutzer gehören, die jedoch nicht ohne deren Einwilligung (im Regelfall im Rahmen der Einstellungen ihrer Mobilgeräte vollzogen), erhoben werden. Die Daten können in den USA verarbeitet werden. Datenschutzerklärung: <a target="_blank" href="https://www.google.com/policies/privacy/">https://www.google.com/policies/privacy/</a>, Opt-Out: <a target="_blank" href="https://adssettings.google.com/authenticated">https://adssettings.google.com/authenticated</a>.</span></p><p></p><h3 id="dsg-thirdparty-openstreetmap">OpenStreetMap</h3><p></p><p><span class="ts-muster-content">Wir binden die Landkarten des Dienstes "OpenStreetMap" ein (<a target="_blank" href="https://www.openstreetmap.de">https://www.openstreetmap.de</a>), die auf Grundlage der Open Data Commons Open Database Lizenz (ODbL) durch die OpenStreetMap Foundation (OSMF) angeboten werden. Datenschutzerklärung: <a target="_blank" href="https://wiki.openstreetmap.org/wiki/Privacy_Policy">https://wiki.openstreetmap.org/wiki/Privacy_Policy</a>. <br>
        <br>
        Nach unserer Kenntnis werden die Daten der Nutzer durch OpenStreetMap ausschließlich zu Zwecken der Darstellung der Kartenfunktionen und Zwischenspeicherung der gewählten Einstellungen verwendet. Zu diesen Daten können insbesondere IP-Adressen und Standortdaten der Nutzer gehören, die jedoch nicht ohne deren Einwilligung (im Regelfall im Rahmen der Einstellungen ihrer Mobilgeräte vollzogen), erhoben werden. <br>
        <br>
        Die Daten können in den USA verarbeitet werden. Weitere Informationen können Sie der Datenschutzerklärung von OpenStreetMap entnehmen: <a target="_blank" href="https://wiki.openstreetmap.org/wiki/Privacy_Policy">https://wiki.openstreetmap.org/wiki/Privacy_Policy</a>.</span></p><p></p><h3 id="dsg-facebook-plugin">Verwendung von Facebook Social Plugins</h3><p></p><p><span class="ts-muster-content">Wir nutzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) Social Plugins ("Plugins") des sozialen Netzwerkes facebook.com, welches von der Facebook Ireland Ltd., 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland betrieben wird ("Facebook"). <br>
        Hierzu können z.B. Inhalte wie Bilder, Videos oder Texte und Schaltflächen gehören, mit denen Nutzer Inhalte dieses Onlineangebotes innerhalb von Facebook teilen können. Die Liste und das Aussehen der Facebook Social Plugins kann hier eingesehen werden:&nbsp;<a target="_blank" href="https://developers.facebook.com/docs/plugins/">https://developers.facebook.com/docs/plugins/</a>.<br>
        <br>
        Facebook ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&amp;status=Active</a>).<br>
        <br>
        Wenn ein Nutzer eine Funktion dieses Onlineangebotes aufruft, die ein solches Plugin enthält, baut sein Gerät eine direkte Verbindung mit den Servern von Facebook auf. Der Inhalt des Plugins wird von Facebook direkt an das Gerät des Nutzers übermittelt und von diesem in das Onlineangebot eingebunden. Dabei können aus den verarbeiteten Daten Nutzungsprofile der Nutzer erstellt werden. Wir haben daher keinen Einfluss auf den Umfang der Daten, die Facebook mit Hilfe dieses Plugins erhebt und informiert die Nutzer daher entsprechend unserem Kenntnisstand.<br>
        <br>
        Durch die Einbindung der Plugins erhält Facebook die Information, dass ein Nutzer die entsprechende Seite des Onlineangebotes aufgerufen hat. Ist der Nutzer bei Facebook eingeloggt, kann Facebook den Besuch seinem Facebook-Konto zuordnen. Wenn Nutzer mit den Plugins interagieren, zum Beispiel den Like Button betätigen oder einen Kommentar abgeben, wird die entsprechende Information von Ihrem Gerät direkt an Facebook übermittelt und dort gespeichert. Falls ein Nutzer kein Mitglied von Facebook ist, besteht trotzdem die Möglichkeit, dass Facebook seine IP-Adresse in Erfahrung bringt und speichert. Laut Facebook wird in Deutschland nur eine anonymisierte IP-Adresse gespeichert.<br>
        <br>
        Zweck und Umfang der Datenerhebung und die weitere Verarbeitung und Nutzung der Daten durch Facebook sowie die diesbezüglichen Rechte und Einstellungsmöglichkeiten zum Schutz der Privatsphäre der Nutzer, können diese den Datenschutzhinweisen von Facebook entnehmen:&nbsp;<a target="_blank" href="https://www.facebook.com/about/privacy/">https://www.facebook.com/about/privacy/</a>.<br>
        <br>
        Wenn ein Nutzer Facebookmitglied ist und nicht möchte, dass Facebook über dieses Onlineangebot Daten über ihn sammelt und mit seinen bei Facebook gespeicherten Mitgliedsdaten verknüpft, muss er sich vor der Nutzung unseres Onlineangebotes bei Facebook ausloggen und seine Cookies löschen. Weitere Einstellungen und Widersprüche zur Nutzung von Daten für Werbezwecke, sind innerhalb der Facebook-Profileinstellungen möglich:&nbsp;<a target="_blank" href="https://www.facebook.com/settings?tab=ads">https://www.facebook.com/settings?tab=ads</a> &nbsp;oder über die US-amerikanische Seite&nbsp;<a target="_blank" href="http://www.aboutads.info/choices/">http://www.aboutads.info/choices/</a> &nbsp;oder die EU-Seite&nbsp;<a target="_blank" href="http://www.youronlinechoices.com/">http://www.youronlinechoices.com/</a>. Die Einstellungen erfolgen plattformunabhängig, d.h. sie werden für alle Geräte, wie Desktopcomputer oder mobile Geräte übernommen.</span></p><p></p><h3 id="dsg-thirdparty-twitter">Twitter</h3><p></p><p><span class="ts-muster-content">Innerhalb unseres Onlineangebotes können Funktionen und Inhalte des Dienstes Twitter, angeboten durch die Twitter Inc., 1355 Market Street, Suite 900, San Francisco, CA 94103, USA, eingebunden werden. Hierzu können z.B. Inhalte wie Bilder, Videos oder Texte und Schaltflächen gehören, mit denen Nutzer Inhalte dieses Onlineangebotes innerhalb von Twitter teilen können.<br>
        Sofern die Nutzer Mitglieder der Plattform Twitter sind, kann Twitter den Aufruf der o.g. Inhalte und Funktionen den dortigen Profilen der Nutzer zuordnen. Twitter ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt0000000TORzAAO&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt0000000TORzAAO&amp;status=Active</a>). Datenschutzerklärung: <a target="_blank" href="https://twitter.com/de/privacy">https://twitter.com/de/privacy</a>, Opt-Out: <a target="_blank" href="https://twitter.com/personalization">https://twitter.com/personalization</a>.</span></p><p></p><h3 id="dsg-thirdparty-instagram">Instagram</h3><p></p><p><span class="ts-muster-content">Innerhalb unseres Onlineangebotes können Funktionen und Inhalte des Dienstes Instagram, angeboten durch die Instagram Inc., 1601 Willow Road, Menlo Park, CA, 94025, USA, eingebunden werden. Hierzu können z.B. Inhalte wie Bilder, Videos oder Texte und Schaltflächen gehören, mit denen Nutzer Inhalte dieses Onlineangebotes innerhalb von Instagram teilen können. Sofern die Nutzer Mitglieder der Plattform Instagram sind, kann Instagram den Aufruf der o.g. Inhalte und Funktionen den dortigen Profilen der Nutzer zuordnen. Datenschutzerklärung von Instagram: <a target="_blank" href="http://instagram.com/about/legal/privacy/">http://instagram.com/about/legal/privacy/</a>.  </span></p><p></p><h3 id="dsg-thirdparty-pinterest">Pinterest</h3><p></p><p><span class="ts-muster-content">Innerhalb unseres Onlineangebotes können Funktionen und Inhalte des Dienstes Pinterest, angeboten durch die Pinterest Inc., 635 High Street, Palo Alto, CA, 94301, USA, eingebunden werden. Hierzu können z.B. Inhalte wie Bilder, Videos oder Texte und Schaltflächen gehören, mit denen Nutzer Inhalte dieses Onlineangebotes innerhalb von Pinterest teilen können. Sofern die Nutzer Mitglieder der Plattform Pinterest sind, kann Pinterest den Aufruf der o.g. Inhalte und Funktionen den dortigen Profilen der Nutzer zuordnen. Datenschutzerklärung von Pinterest: <a target="_blank" href="https://about.pinterest.com/de/privacy-policy">https://about.pinterest.com/de/privacy-policy</a>. </span></p><p></p><h3 id="dsg-thirdparty-linkedin">LinkedIn</h3><p></p><p><span class="ts-muster-content">Innerhalb unseres Onlineangebotes können Funktionen und Inhalte des Dienstes LinkedIn, angeboten durch die LinkedIn Ireland Unlimited Company Wilton Place, Dublin 2, Irland, eingebunden werden. Hierzu können z.B. Inhalte wie Bilder, Videos oder Texte und Schaltflächen gehören, mit denen Nutzer Inhalte dieses Onlineangebotes innerhalb von LinkedIn teilen können. Sofern die Nutzer Mitglieder der Plattform LinkedIn sind, kann LinkedIn den Aufruf der o.g. Inhalte und Funktionen den dortigen Profilen der Nutzer zuordnen. Datenschutzerklärung von LinkedIn: <a target="_blank" href="https://www.linkedin.com/legal/privacy-policy">https://www.linkedin.com/legal/privacy-policy.</a>. LinkedIn ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a target="_blank" href="https://www.privacyshield.gov/participant?id=a2zt0000000L0UZAA0&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt0000000L0UZAA0&amp;status=Active</a>). Datenschutzerklärung: <a target="_blank" href="https://www.linkedin.com/legal/privacy-policy">https://www.linkedin.com/legal/privacy-policy</a>, Opt-Out: <a target="_blank" href="https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out">https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out</a>.</span></p><a href="https://datenschutz-generator.de" class="dsg1-6" rel="nofollow" target="_blank">Erstellt mit Datenschutz-Generator.de von RA Dr. Thomas Schwenke</a>
        </div>';
        if ($container) $output .= '</div>';

        return $output;
    }

    private function imprint($data = null) {
        $address = str_replace(', ', '<br />', CONTACT_ADDRESS);
        $output = '
        <div class="container imprint">
            <h1>Impressum</h1>
        
            <p>
            '.__('IMPRINT_LEGAL_NOTE').'
            <br /> 
            <br /> 
            Angaben gemäß § 5 TMG<br />           
            <br />
            '. ROOT_SHORT .'<br />
            '.$address.'
            <br /><br />
            E-Mail:<br />
            <a href="mailto:'. CONTACT_EMAIL .'">'. CONTACT_EMAIL .'</a><br />
            <br />
            Vertreten durch:<br />
            '. CONTACT_NAMES .'<br />
            <br/>
            Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:<br/>
            '. explode(',', CONTACT_NAMES)[0] .'
            <br />
            '. $address .'
            </p>
        
            <hr />
        
            <h2>Haftungsausschluss</h2>
        
            <h3>Haftung für Inhalte</h3>
        
            <p>
            Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt.
            Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen.
            Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich.
            Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet,
            übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen,
            die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von
            Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt.
            Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich.
            Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
            </p>
        
            <h3>Haftung für Links</h3>
            <p>
            Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben.
            Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen.
            Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.
            Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft.
            Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.
            Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar.
            Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.
            </p>
        
            <h3>Urheberrecht</h3>
            <p>
            Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht.
            Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes
            bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.
            Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet.
            Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet.
            Insbesondere werden Inhalte Dritter als solche gekennzeichnet.
            Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis.
            Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.
            </p>
        
            <h3>Datenschutzbestimmungen</h3>
            <p>
            Die Datenschutzbestimmungen sind komplett hier einsehbar:<br />
            <a href="'. ROOT .'privacy">'. ROOT .'privacy</a>
            </p>
        
            <h3>Google Analytics</h3>
            <p>
            Diese Website benutzt Google Analytics, einen Webanalysedienst der Google Inc. (\'Google\'). Google Analytics verwendet sog.
            "Cookies", Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglicht.
            Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website (einschließlich Ihrer IP-Adresse) wird an einen Server
            von Google in den USA übertragen und dort gespeichert. Google wird diese Informationen benutzen,
            um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivitäten für die Websitebetreiber zusammenzustellen
            und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen zu erbringen.
            Auch wird Google diese Informationen gegebenenfalls an Dritte übertragen, sofern dies gesetzlich vorgeschrieben
            oder soweit Dritte diese Daten im Auftrag von Google verarbeiten. Google wird in keinem Fall Ihre IP-Adresse mit anderen Daten
            der Google in Verbindung bringen. Sie können die Installation der Cookies durch eine entsprechende Einstellung Ihrer
            Browser Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen
            dieser Website voll umfänglich nutzen können. Durch die Nutzung dieser Website erklären Sie sich mit der
            Bearbeitung der über Sie erhobenen Daten durch Google in der zuvor beschriebenen Art und Weise und zu dem zuvor benannten Zweck
            einverstanden.
            </p>
        
            <h3>Google AdSense</h3>
            <p>
            Diese Website benutzt Google Adsense, einen Webanzeigendienst der Google Inc., USA (\'Google\'). Google Adsense verwendet sog.
            "Cookies", Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglicht.
            Google Adsense verwendet auch sog. "Web Beacons" (kleine unsichtbare Grafiken) zur Sammlung von Informationen.
            Durch die Verwendung des Web Beacons können einfache Aktionen wie der Besucherverkehr auf der Webseite aufgezeichnet
            und gesammelt werden. Die durch den Cookie und/oder Web Beacon erzeugten Informationen über Ihre Benutzung dieser Website
            (einschließlich Ihrer IP-Adresse) werden an einen Server von Google in den USA übertragen und dort gespeichert.
            Google wird diese Informationen benutzen, um Ihre Nutzung der Website im Hinblick auf die Anzeigen auszuwerten,
            um Reports über die Websiteaktivitäten und Anzeigen für die Websitebetreiber zusammenzustellen und um weitere mit der
            Websitenutzung und der Internetnutzung verbundene Dienstleistungen zu erbringen. Auch wird Google diese Informationen
            gegebenenfalls an Dritte übertragen, sofern dies gesetzlich vorgeschrieben oder soweit Dritte
            diese Daten im Auftrag von Google verarbeiten. Google wird in keinem Fall Ihre IP-Adresse mit anderen Daten der Google
            in Verbindung bringen. Das Speichern von Cookies auf Ihrer Festplatte und die Anzeige von Web Beacons können Sie verhindern,
            indem Sie in Ihren Browser-Einstellungen "keine Cookies akzeptieren" wählen
            (Im Microsoft Internet-Explorer unter "Extras > Internetoptionen > Datenschutz > Einstellung";
            im Firefox unter "Extras > Einstellungen > Datenschutz > Cookies");
            wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser Website voll
            umfänglich nutzen können. Durch die Nutzung dieser Website erklären Sie sich mit der Bearbeitung der über Sie erhobenen Daten
            durch Google in der zuvor beschriebenen Art und Weise und zu dem zuvor benannten Zweck einverstanden.
            </p>
        </div>';        

        return $output;
    }

}