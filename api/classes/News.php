<?php

class News {

    public function titleToUrl($title) {
        return str_replace([' ', ':'], ['-', ''], $title);
    }

    private function api($topics, $multiple = false, $source = null) {
        $output = null;
        $html = null;
        $build = null;
        $excludeDomains = null;
        $apiKey = '24ece43daa5048eeaac6f99caefdef31';

        if (LGC == 'de')
            $excludeDomains = 'mydealz.de,pcgameshardware.de,amazon.de,ze.tt,bild.de,gamerboom.com,apnews.com,ac.jp';

        foreach($topics as $tid => $topic) {
            // Sanitize Topic:
            $cleanTopic = str_replace(':', '', $topic);
            $cleanTopic = preg_replace('/\d/', '', $cleanTopic);
            // Call Api:
            $urlTopic = 'https://newsapi.org/v2/everything?q=' . urlencode($cleanTopic) . '&apiKey=' . $apiKey . '&language=' . LGC . '&excludeDomains=' . $excludeDomains;
            $urlSource = 'https://newsapi.org/v2/top-headlines?sources=' . $source . '&apiKey=' . $apiKey . '&language=' . LGC;
            if ($topic)
                $fetch = file_get_contents($urlTopic);
            else
                $fetch = file_get_contents($urlSource);

            // Decode Result
            $fetch = json_decode($fetch);

            if (!is_array($fetch) && !isset($fetch->articles)) {
                return null;
            }
            // Build News HTML from data:
            $titleStack = null;
            $last_url = null;
            foreach ($fetch->articles as $value) {
                $title = $value->title;
                $description = $value->description;
                #$content = $value->content;
                $url = $value->url;
                // Continue if last url is same as current url:
                if ($last_url == $url)
                    continue;

                $last_url = $url;
                $img = $value->urlToImage;
                $date = timeUTC($value->publishedAt);
                $titleSearch = explode($topic, $title);
                $count = count($titleSearch);
                $descriptionSearch = null;
                $percent = null;
                // No Exact Match Found in $title:
                $skip = false;
                $pcs = '<div class="f09 pink gc"';
                if ($count < 2) {
                    $descriptionCut = strtolower(trim(preg_replace('/[[:digit:]]/', '', $description)));
                    $topicCut = strtolower(trim(preg_replace('/[[:digit:]]/', '', $topic)));
                    $descriptionSearch = stripos($descriptionCut, $topicCut);
                    // No Exact Match Found in $description:
                    if (empty($descriptionSearch)) {
                        // Search Similarity:
                        $words = explode(' ', $descriptionCut);
                        $skip = true;
                        foreach ($words as $word) {
                            similar_text($topicCut, $word, $percent);
                            $percent = round($percent);
                            $pcs .= $topicCut . ' - ' . $word . ': ' . $percent . '<br>';
                            if ($percent > 60) {
                                $skip = false;
                                break;
                            }
                        }
                        # debug:
                        #echo $pcs . '</div><br>---<br>';
                    }
                }

                // Validation:
                if ((is_array($titleStack) && in_array($title, $titleStack)) || $skip) continue;
                // Image check:
                if ($img)
                    $img = '<i class="lazy-img" data-src="' . $img . '" data-alt="' . $title . '"></i>';
                else
                    $img = null;

                $build[$topic][] = [
                #'tid' => $tid,
                'img' => $value->urlToImage,
                'output' => '
                <div class="news">
                    ' . $img . '
                    <h2>' . $title . '</h2>
                    <time datetime="' . $value->publishedAt . '">' . $date . '</time>
                    <p>
                        ' . $description . '<br />
                        <a href="' . $url . '" target="_blank">' . __('READ_MORE') . '</a>
                    </p>
                    
                    <div></div>
                </div>
                '];
                $titleStack[] = $title;
            }
        }
        // Finalize:
        if (is_array($build)) {
            $i = 1;
            $last_img = null;
            foreach ($build as $k => $x) {
                $count = count($x);

                foreach ($x as $y) {
                    $img = $y['img'];
                    if ($img == $last_img)
                        continue;
                    $text = $y['output'];
                    $hr = '<hr />';
                    if ($i == $count) $hr = null;

                    $html .= $text . $hr;

                    $last_img = $img;
                }
                $i++;
            }
        } else {
            $html = '<p class="f10">' . __('NEWS_EMPTY', [$topic]) . '</p>';
        }
        $output['html'] = $html;

        return $output;
    }

    private function releaseStatus($date_raw) {
        $status = true;
        $timeFirst = strtotime($date_raw);
        $timeSecond = strtotime(DATE_NOW);
        $diff = $timeFirst - $timeSecond;
        if ($diff <= 0) {
            $status = false;
        }

        return $status;
    }

    private function topicList($data) {
        $unreleased = true;
        // Fetch available topics:
        $db = MysqliDb::getInstance();
        $db->orderBy('t.published', 'DESC');
        $db->join('companies c', 't.author = c.id');
        $items = $db->get('topics t', null,
            't.id AS tid, t.title, t.published AS date_raw, DATE_FORMAT(t.published, "%d.%m.%Y") AS date, t.tba,
        c.name AS author');
        // Select specific topic:
        $topic = null;
        $topicSelected = null;
        $preselect = false;
        if (isset($data['params']['topic']) && isset($data['params']['tid'])) {
            $topic = $data['params']['topic'];
        } else {
            // News Overview: Select 5 topics
            $preselect = true;
        }
        $item = $this->titleToUrl($topic);

        $list = null;
        $release = null;
        $author = null;
        $i = 0;
        $this_tid = null;
        // BadgeList Template:
        $template = init::load('Template');
        foreach ($items as $x) {
            $tid = $x['tid'];
            $title = $x['title'];
            $date_raw = $x['date_raw'];
            $date = $x['date'];
            $status = 'inactive';
            $url = $this->titleToUrl($title);

            // Title match found:
            if (isset($data['params']['tid']) && $tid == $data['params']['tid']) {
                $this_tid = $tid;
                if (isset($data['params']['topic'])) {
                    $author = $x['author'];
                    $status = null;
                    $release = $date;
                    $topicSelected[$tid] = $title;
                    $i = -1;
                    // Publish status:
                    $unreleased = $this->releaseStatus($date_raw);
                    $tba = $x['tba'];
                }
            }

            $i++;

            if ($data['name'] == 'news' && $_SESSION['topics'] && is_array($_SESSION['topics'])) {
                $preselect = false;
                // Add subscribed topics to stack:
                if (in_array($title, $_SESSION['topics']))
                    $topicSelected[$tid] = $title;
            } else if ($preselect && $i <= 5) {
                // Select random topics when no subscribed topics yet:
                $unreleased = $this->releaseStatus($date_raw);
                $topic = $title;
                $topicSelected[$tid] = $title;
                $this_tid = $tid;
                $release = $date;
                $author = $x['author'];
                $status = null;
            }

            $url = ROOT . 'news/' . $url . '/' . $tid;
            $class = $status;
            $list[$tid] = $template->badge($title, $class, $url, 'popular-badge-'.$tid);
        }
        $output['topic'] = $topic;
        $output['topicSelected'] = $topicSelected;
        $output['list'] = $list;
        $output['unreleased'] = $unreleased;
        $output['this_tid'] = $this_tid;
        $output['item'] = $item;
        $output['author'] = $author;
        $output['release'] = $release;
        $output['tba'] = $tba;

        return $output;
    }

    public function output($data) {
        /* @var Template() $template */
        $db = MysqliDb::getInstance();
        $template = init::load('Template');

        $popularList = null;
        $topicList = $this->topicList($data);
        $unreleased = $topicList['unreleased'];
        $author = $topicList['author'];
        $release = $topicList['release'];
        $tba = $topicList['tba'];
        #$this_tid = $topicList['this_tid'];
        #$topic = $topicList['topic'];
        $topicSelected = $topicList['topicSelected'];
        #$item = $topicList['item'];
        $list = $topicList['list'];
        if ($data['name'] == 'news') {
            $multiple = $data['limit'];
        }

        // Create Topic list as badges (style is like badges):
        $newsContent = $this->api($topicSelected, $multiple);
        $newsContentOutput = $newsContent['html'];
        // Highlights:
        $highlights = null;
        if ($tba)
            $release = __('TOPIC_TBA');
        else if ($unreleased)
            $highlights = '
            <ul>
                <li><i class="material-icons">check_circle</i> ' . __('HIGHLIGHT_BETATEST') . '</li>
            </ul>';
        // Details:
        $details = '
            <div class="details">
                <span><i class="material-icons md-15">work</i> ' . __('AUTHOR') . ': ' . $author . '</span> 
                <span><i class="material-icons md-15">access_time</i> ' . __('RELEASED') . ': ' . $release . '</span>
            </div>
            ';
        // Project Vars:
        $add = null;
        if ($_SESSION['completed'])
            $add = 'COMPLETED';
        else if ($unreleased)
            $add = 'UNRELEASED';
        else
            $add = 'RELEASED';

        $contentLeft = null;
        $subscribedTopics = null;
        if (isset($_SESSION['topics']) && !empty($_SESSION['topics'])) {
            foreach ($_SESSION['topics'] as $k => $x) {
                $url = $this->titleToUrl($x);
                $badge_class = 'inactive';
                if ($data['params']['topic'] == $url || $data['name'] == 'news') $badge_class = null;

                $subscribedTopics .= $template->badge($x, $badge_class, ROOT.'news/'.$url.'/'.$k, 'badge-'.$k);
            }
        } else {
            $subscribedTopics = __('SUBSCRIBED_TOPICS_EMPTY');
        }
        end($topicSelected);
        $this_tid = key($topicSelected);
        $topic = $topicSelected[$this_tid];
        // Assign Image:
        $img = ROOT . 'img/news/' . strtolower(str_replace(['-', ' ', ':'], '', $topic));

        $contentLeft .= '
        <div class="topics">
            <h3>' . __('SUBSCRIBED_TOPICS') . '</h3>
            <div id="subscribedTopics">'.$subscribedTopics.'</div>
            ';
        // Create Popular List:
        foreach ($list as $k => $x) {
            if (isset($_SESSION['topics']) && array_key_exists($k, $_SESSION['topics']))
                continue;

            $popularList .= $x;
        }

        $contentLeft .= '
            <h3>' . __('POPULAR_TOPICS') . '</h3>
            <div id="popularList">
                ' . $popularList . '
            </div>
            <div id="news-options">
                <a data-toggle="collapse" data-target="#makeSuggestion" class="suggestion">' . __('SUGGESTION_COLLAPSE') . '</a> &nbsp; &middot; &nbsp;
                <a data-toggle="collapse" data-target="#addNews" class="suggestion">' . __('SUGGESTION_ADD_NEWS') . '</a>
            </div>
        
            <div class="news-main box-shadow-bright">
                <div class="collapse" id="makeSuggestion">
                    <form id="suggestionForm">
                        <div class="faded in">
                            <p class="info">' . __('SUGGESTION_DESCRIPTION') . '</p>
                            <fieldset>
                                ' . input('topic') . '
                                <a data-form="#suggestionForm" data-task="suggest" class="async pull-right btn btn-info">' . __('INPUT_SEND') . '</a>
                            </fieldset>
                            <hr />
                        </div>
                    </form>
                </div>
                <div class="collapse" id="addNews">
                    <form id="addNewsForm">
                        <div class="faded in">
                            <p class="info">' . __('ADD_NEWS_DESCRIPTION', [$topic]) . '</p>
                            <div id="add-news-input">
                                <fieldset>
                                    <input name="tid" type="hidden" value="' . $this_tid . '" />
                                    ' . input('title') . '
                                    <textarea name="text" placeholder="' . __('INPUT_TEXT') . '"></textarea>
                                    <a data-form="#addNewsForm" data-task="addNews" class="async btn btn-info pull-right">' . __('INPUT_SEND') . '</a>
                                </fieldset>
                            </div>
                            <div class="cb"></div>
                            <hr />
                        </div>
                    </form>
                </div>        
                ' . $newsContentOutput . '
            </div>
        </div>
        ';

        // Follow
        $button = '<a href="' . $data['signup'] . '" class="btn btn-info xl">' . __('BTN_PARTICIPATE') . '</a>';
        if ($_SESSION['completed']) {
            if ($this_tid) {
                $db->where('(uid = ' . $_SESSION['uid'] . ' AND tid = ' . $this_tid . ')');
                $follow_state = $db->getValue('topics_follow', 'state');
            }
            $note = null;
            $button_class = 'primary';
            if ($unreleased) {
                $releaseCode = 0;
                $button_label = __('PARTICIPATE');
                $note .= '<p class="note">' . __('PARTICIPATE_NOTE_' . INITIALS) . '</p>';
                if ($follow_state == 1)
                    $button_label = __('WITHDRAW_PARTICIPATION');
            } else {
                $releaseCode = 1;
                $button_label = __('FOLLOW');
                if ($follow_state == 1)
                    $button_label = __('UNFOLLOW');
            }
            if (empty($follow_state)) {
                $follow_state = 0;
                $button_class = 'info';
            }

            $button = '
                <a id="button-follow" data-params="' . $follow_state . ',' . $this_tid . ','.$releaseCode.','.$topic.'" data-task="topic_follow" class="async btn btn-' . $button_class . ' xl">
                ' . $button_label . '
                </a>'.
                $note;
        }
        // Rating
        # My Like:
        $total_likes = 0;
        if (isset($this_tid) && isset($_SESSION['uid'])) {
            $db->where('uid', $_SESSION['uid']);
            $db->where('tid', $this_tid);
            $like_state = $db->getValue('topics_likes', 'state');
        # Total Likes:
            $total_fake_dislikes = 2;
            $db->where('tid', $this_tid);
            $db->where('state', 1);
            $total_likes = $db->getValue('topics_likes', 'COUNT(1)');
        }
        $total_fake = 1195;
        $total_fake_likes = 990 + $total_likes;
        $percent = number_format($total_fake_likes / $total_fake * 100);

        $button_class_no = null;
        $button_class_yes = null;
        if ($like_state == 1 || $like_state == -1) {
            if ($like_state == 1)
                $button_class_yes = ' green';
            else
                $button_class_no = ' lava';
        }

        $side_text = __('TOPIC_LIKE_' . $add, ['topic' => $topic]);
        if ($tba) $side_text = __('TOPIC_LIKE_TBA', ['topic' => $topic]);

        $rating = '
            <div class="rating">
                <a id="no" data-params="0,' . $this_tid . ',' . $topic . '" data-task="topic_rating" class="async' . $button_class_no . '" title="' . __('TOPIC_DISLIKE_TITLE', [$topic]) . '">
                    <i class="material-icons">thumb_down</i> ' . __('NO') . '
                </a>
                <a id="yes" data-params="1,' . $this_tid . ',' . $topic . '" data-task="topic_rating" class="async' . $button_class_yes . '" title="' . __('TOPIC_LIKE_TITLE', [$topic]) . '">
                    <i class="material-icons">thumb_up</i> ' . __('YES') . '
                </a>     
                <p>' . __('TOPIC_TOTAL_LIKES', [$percent, $topic]) . '</p> 
            </div>
        ';

        $sidebar_class = 'news-side';
        $img_bg = $img . '.webp';
        $img_logo = '<img src="' . $img . '_logo.webp" alt="' . $topic . '" />';


        $contentRight = '
            <div class="' . $sidebar_class . '" style="background-image: url(' . $img_bg . ')">
                <div></div>
                    <div>
                        ' . $img_logo . '
                        <h1>' . $topic . '</h1>
                        ' . $highlights . $button . '
                        <p>' . $side_text . '</p>
                        ' . $rating . '
                        ' . $details . '
                    </div>
                </div>
            </div>
        ';
        $data['contentLeft'] = $contentLeft;
        $data['contentRight'] = $contentRight;

        $output = '
        <div class="news-topics">
        ' . $template->splitView($data) . '
        ';

        return $output;
    }

}