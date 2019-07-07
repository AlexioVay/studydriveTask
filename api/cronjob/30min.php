<?php /** @noinspection PhpUnhandledExceptionInspection */
require_once '../init.php';
# htaccess ---> admin:87226113

require_once ROOT_ABS . "TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_SECRET);
$content = $connection->get("account/verify_credentials");

$timeline = $connection->get("statuses/user_timeline", ['screen_name' => 'sarah_gamerin', 'count' => 100]);
for ($i = 0; $i < count($timeline); $i++) {
    // Calculate created date to "total seconds ago":
    $created_at = $timeline[$i]->created_at;
    $date = new DateTime($created_at);
    $date->setTimezone(new DateTimeZone('America/New_York'));
    $timediff = $date->diff(new DateTime());
    $reference = new DateTimeImmutable;
    $endTime = $reference->add($timediff);
    $secs = $endTime->getTimestamp() - $reference->getTimestamp();
    $min = round($secs / 60); // 1440 min = 1 day

    if ($min >= 1440) {
        $status_id = $timeline[$i]->id_str;
        $destroy = $connection->post("statuses/destroy/".$status_id."");
    }
}


$db = MysqliDb::getInstance();
$db->join('twitter_categories c', 'c.id = t.category');
$db->where('c.'.LGC.'', 'gaming');
$topics = $db->get('twitter_topics t', null, 't.hashtag');

$merge = null;
if ($db->count > 0) {
    foreach($topics as $t) {
        $merge[] = $t['hashtag'];
    }
}

$hashtags = ['PS4share', 'zocken', 'gaming', 'ps4', 'xbox'];
if (is_array($merge) && !empty($merge)) $hashtags = array_merge($hashtags, $merge);
shuffle($hashtags);

$hashtag = $hashtags[0];
$statuses = $connection->get("search/tweets", ['q' => $hashtag, 'lang' => 'de']);

$id = $statuses->statuses[0]->id_str;
$username = $statuses->statuses[0]->user->screen_name;

$twitter_bots = unserialize(TWITTER_BOTS);
if (!empty($username) && !in_array($username, $twitter_bots)) {
    $db->where('tweet_id', $id);
    $db->where('username', $username);
    $already = $db->getValue('twitter_bot', '1');
    if (empty($already)) { // Send Tweet:
$texts[] =
'@'.$username.' Wusstest du, dass man durch www.Spieletester.eu kostenlos zocken kann und noch Geld verdient?';

if (is_array($merge) && !empty($merge) && in_array($hashtag, $merge)) {
$texts[] =
'@'.$username.' Wusstest du, dass man #'.$hashtag.' bei www.Spieletester.eu umsonst zocken kann und noch Geld verdient?';
$texts[] =
'@'.$username.' Bei www.Spieletester.eu kriegt man Geld und zockt #'.$hashtag.' kostenlos!';
$texts[] =
'@'.$username.' Hab heute #'.$hashtag.' zum Testen kostenlos bei www.Spieletester.eu gekriegt!';
}
        shuffle($texts);
        $text = $texts[0];

        $tweet = $connection->post('statuses/update', ['in_reply_to_status_id' => $id, 'status' => $text]);
        // Store to database to prevent another reply to same tweet id:
        $db->insert('twitter_bot', ['tweet_id' => $id, 'username' => $username, 'date' => $db->now()]);

        echo '
        <div style="font-family: \'Google Sans\', sans-serif; font-size: 20px;">
            #'.$hashtag.'
            <p>'.$text.'</p>
        </div>';
        /*var_dump($tweet);
        echo '<pre>';
        print_r($statuses);
        echo '</pre>';*/
    }
} else { // Selected myself, therefore reload this file.
    header("Refresh: 0");
}