<?php

class Template {

    public function badge($title, $class = null, $url = null, $id = null) {
        $href = null;
        if ($id) $id = ' id="'.$id.'"';
        if ($url) $href = ' href="'.$url.'"';
        if ($class) $class = ' '.$class;
        $output = '<a'.$id.$href.' class="badge'.$class.'">'.$title.'</a>';

        return $output;
    }

    public function splitView($data) {
        $contentLeft = $data['contentLeft'];
        $contentRight = $data['contentRight'];
        $colsLeft = 7;
        $colsRight = 5;
        if (isset($data['colsLeft'])) $colsLeft = $data['colsLeft'];
        if (isset($data['colsRight'])) $colsRight = $data['colsRight'];

        $output = null;
        if (IS_MOBILE) {
            $tempLeft = $contentLeft;
            $tempColsLeft = $colsLeft;
            $contentLeft = $contentRight;
            $contentRight = $tempLeft;
            $colsLeft = $colsRight;
            $colsRight = $tempColsLeft;
        }
        if ($data['clearRight'])
            $content = $contentRight;
        else
            $content = '
            <div class="row">
                <div class="col-sm-'.$colsLeft.'">
                '.$contentLeft.'
                </div>
                <div class="col-sm-'.$colsRight.' sticky-top">
                '.$contentRight.'                
                </div>
            </div>            
            ';

        $output = '
        <div class="container">
            '.$content.'
        </div>                
        ';

        return $output;
    }

    public function head($match) {
        // Init:
        $output = null;
        $css = null;
        $topic = null;
        if (isset($match['params']['topic'])) {
            $topic = str_replace('-', ' ', $match['params']['topic']);
        }

        $add = null;
        switch ($match['target']):
            default: case 'home': $title = __('META_TITLE'); break;
            case 'signup': $title = __('META_SIGNUP_TITLE'); break;
            case 'news':
                if ($match['data']['unreleased']) $add = '_BETA';
                $title = __('META_NEWS_TITLE'.$add, [$topic]);
            break;
        endswitch;

        # When delayed to display favicon:
        $add = 'n';
        #if ($_SERVER['HTTP_HOST'] == 'schauspiel-jobs.de') $add = null;
        $robots = 'index,follow';
        if ($match['nofollow']) $robots = 'noindex,nofollow';

        // Meta Language:
        $metaLang = 'en';
        if (LGC == 'en') $metaLang = 'de';

        $z = null;
        if (isset($match['params'])) {
            $stringify = null;
            foreach($match['params'] as $k => $x) $stringify .= $k.':'.$x.',';
            $z = '&z=' . substr($stringify, 0, -1);
        }

        $output .= "
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=9' />
        <meta name='google-site-verification' content='ATw5Ti-tUXYYlnIpFwad6E3CEHvQhsxySjgbXohRyQc' />
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'>
        <meta name='description' content='".__('META_DESCRIPTION')."'>
        <meta name='keywords' content='".__('META_KEYWORDS')."'>
        <meta name='robots' content='".$robots."'>
        <meta name='author' content='".PROJECT."'>
        <link rel='shortcut icon' href='".ROOT."img/favico".$add."/favico".$add.".ico'>
        <link rel='dns-prefetch' href='//google-analytics.com'>         
        <link rel='dns-prefetch' href='//www.google-analytics.com'>         
        <link rel='dns-prefetch' href='//fonts.googleapis.com'>         
        <link rel='dns-prefetch' href='//fonts.gstatic.com'>         
        <link rel='dns-prefetch' href='//jobspace24.com/api'>         
        <title>".$title."</title>
        <link rel='stylesheet' href='".ROOT_CMS."css/dev/bundle.php?x=".base64_encode(ROOT_ABS)."&y=".$match['target'].$z."' media='screen'>
        <style type='text/css'>@import url('https://fonts.googleapis.com/css?family=Roboto:400,700')@font-face{font-family:'Roboto';font-display:auto} @font-face {font-family:'Google Sans';font-display:auto;src:url(".ROOT_CMS."css/fonts/GoogleSans-Medium.ttf)}@font-face{font-family:'Material Icons';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/materialicons/v43/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.woff2) format('woff2')}.material-icons{font-family:'Material Icons';font-weight:400;font-style:normal;font-size:24px;line-height:1;letter-spacing:normal;text-transform:none;display:inline-block;white-space:nowrap;word-wrap:normal;direction:ltr;-webkit-font-feature-settings:'liga';-webkit-font-smoothing:antialiased}</style>
        <link rel='alternate' hreflang='".$metaLang."' href='".ROOT."?lang=".$metaLang."'>
        
        <link rel='apple-touch-icon' sizes='180x180' href='".ROOT."img/favico".$add."/apple-touch-icon.png'>
        <link rel='icon' type='image/png' sizes='32x32' href='".ROOT."img/favico".$add."/favicon-32x32.png'>
        <link rel='icon' type='image/png' sizes='16x16' href='".ROOT."img/favico".$add."/favicon-16x16.png'>
        <link rel='manifest' href='".ROOT."img/favico".$add."/manifest.json'>
        <link rel='mask-icon' href='".ROOT."img/favico".$add."/safari-pinned-tab.svg' color='#aa61cc'>
        <meta name='theme-color' content='#ffffff'>
        ";

        return $output;
    }

    public function main($match) {
        // Init:
        $output = null;
        $slideMenu = null;
        $contentClass = null;
        $status = null;
        $mainMargin = null;
        // Assign Vars:
        $signup = $match['signup'];
        $nav = init::load('Navigation');
        $footer = $this->footer();
        $footerMenu = null;
        $footerMain = $footer;

        if ($match['header'] == 1) $contentClass .= 'bg';
        if (IS_MOBILE) {
            $footerMenu = $footer;
            $footerMain = '<div class="legal"><span>☰</span>'.__('MAIN_LEGAL_NOTE').'</div>';
            $contentClass .= ' snap-content';
            $slideMenu = '
            <div id="menu" class="snap-drawers">
                <div class="snap-drawer snap-drawer-left">
                    <div class="account">
                        ' . $match['login'] . '
                    </div>
                    ' . $nav->items($signup, true) . '
                    ' . $footerMenu . '
                </div>
                <div class="snap-drawer snap-drawer-right"></div>
            </div>';
        }
        // Header:
        $headerArray = ['size' => $match['header'], 'login' => $match['login'], 'signup' => $match['signup']];
        $header = $this->header($headerArray);
        // Content:
        $targetClass = init::load($match['class']);
        $main = $targetClass->output($match);
        if ($contentClass) $contentClass = ' class="'.$contentClass.'"';
        // Footer:
        if ($match['target'] == 'news') $mainMargin .= ' class="pt0"';

        $output = '
        ' . $slideMenu . '
        <div id="content"'.$contentClass.'>
            '.$header.'
            <main' . $mainMargin . '>'.$main.$footerMain.'</main>
        </div>';

        return $output;
    }

    public function header($data) {
        $output = null;
        $nav = init::load('Navigation');

        $size = $data['size'];
        $login = $data['login'];
        $signup = $data['signup'];

        $slide_menu_toggle = '
        <div id="slide-menu-toggle">
            <div></div>
            <div></div>
            <div></div>
        </div>              
        ';

        if ($size == 1) {
            $logo_fade = 'rl';
            $nav_class = null;
            $login = '<span>'.$login.'</span>';
            $logo = '
            <div class="logo ' . $logo_fade . '">
                <a href="' . ROOT . '">
                    <img src="' . ROOT . 'img/logo_horizontal.svg" alt="'.PROJECT.' Logo" width="364" height="33" />
                </a>
                <p class="faded in">' . __('INTRO') . '</p>
            </div>
            ';
            $header_sticky = null;
            if (IS_MOBILE) {
                $logo = null;
                $logo_fade = 'tb';
                $nav_class = ' class="simple"';
                $login = null;
                $header_sticky = '
                <div id="header-sticky" class="faded in">
                    '.$slide_menu_toggle.'        
                                
                    <div class="container logo ' . $logo_fade . '">              
                        <a href="' . ROOT . '">
                            <img src="' . ROOT . 'img/logo_mobile.svg" alt="'.PROJECT.' Logo" width="364" height="33" />
                        </a>
                        <p id="header-text" class="faded in">' . __('INTRO') . '</p>
                    </div>
                </div>';
            }

            $output .=
            '          
            '.$header_sticky.'
            <header class="big faded in">
                <div class="container">
                    '.$logo.'
                    
                    <div class="slider">
                        <i><i class="bar"></i></i>
                        <div class="show">
                            <img src="' . ROOT . 'img/slider/red_dead_redemption2.webp" alt="Red Dead Redemption 2" class="run-left rdr2" />
                            <img src="' . ROOT . 'img/slider/red_dead_redemption2_logo.webp" alt="Red Dead Redemption 2 Logo" class="run-right slide-logo rdr2-logo" />
                        </div>
                        <div>
                            <img src="' . ROOT . 'img/slider/hitman2.webp" alt="Hitman 2" class="run-left hitman2" />
                            <img src="' . ROOT . 'img/slider/hitman2_logo.png" alt="Hitman 2 Logo" class="run-right slide-logo hitman2-logo" />
                        </div>
                        <div>
                            <img src="' . ROOT . 'img/slider/dota2.webp" alt="Dota 2" class="run-left hitman2" />
                            <img src="' . ROOT . 'img/slider/dota2_logo.webp" alt="Dota 2 Logo" class="run-right slide-logo dota2-logo" />
                        </div>                        
                    </div>
                </div>
            </header>';

            if (!IS_MOBILE)
            $output .=
            '<nav id="account"' . $nav_class . '>
                <div class="container">
                    '.$login.'                
                    <a href="' . $signup . '" class="item signup">
                        <img src="' . ROOT . 'img/participate.svg" alt="' . __('NAV_REGISTER') . '" />' . __('NAV_REGISTER') . '
                    </a>
                    <a href="' . ROOT . 'news" class="item news">
                        <img src="' . ROOT . 'img/news.svg" alt="' . __('NAV_NEWS') . '" />' . __('NAV_NEWS') . '
                    </a>                    
                    <a href="' . ROOT . '#ratings" class="item ratings">
                        <img src="' . ROOT . 'img/ratings.svg" alt="' . __('NAV_RATINGS') . '" />' . __('NAV_RATINGS') . '
                    </a>
                </div>
            </nav>
            ';
        } else {
            $n = $nav->items($signup);
            $nav = '<nav>'.$n.'</nav>';

            $headerClass = 'simple';
            $login = '<div id="account">'.$login.'</div>  ';
            $logo_file = 'logo_horizontal.svg';
            $nav_mobile = null;
            if (IS_MOBILE) {
                $headerClass = 'mobile';
                $nav = null;
                $nav_mobile = $slide_menu_toggle;
                $login = null;
                $logo_file = 'logo_mobile.svg';
            }
            $output .= '
            <header class="'.$headerClass.' faded in">
                '.$nav_mobile.'
                <div class="container">
                    <a title="' . __('PARTICIPATE_TITLE') . '" href="' . ROOT . '">
                        <img class="logo" src="'.ROOT . 'img/'.$logo_file.'" alt="'.PROJECT.' Logo" />
                    </a>
                    '.$nav.'
                    '.$login.'           
                </div>
            </header>
            ';
        }

        return $output;
    }

    public function contact() {
        $instagram = null;
        if (defined('INSTAGRAM_USERNAME'))
        $instagram = '
        <a href="http://instagram.com/'.INSTAGRAM_USERNAME.'" target="_blank" class="instagram">
            <span><img src="'.ROOT_CMS.'img/social/instagram.svg" /> / &nbsp;'.INSTAGRAM_USERNAME.'</span>
        </a>          
        ';

        $output = '
        <hr />
        
        <div id="contact" class="container">
            <h2>'.__('247_TITLE').'</h2>
            <p>'.__('247').'</p>        
        
            <h2>'.__('REFUND_TITLE').'</h2>
            <p>'.__('REFUND_TEXT').'</p>
        
            <a href="http://facebook.com/'.FACEBOOK_USERNAME.'" target="_blank" class="facebook">
                <span><img src="'.ROOT_CMS.'img/social/facebook.svg" /> / &nbsp;'.FACEBOOK_USERNAME.'</span>
            </a>
            '.$instagram.'  
            <a href="mailto:'.CONTACT_EMAIL.'" target="_blank" class="email">
                <span><img src="'.ROOT_CMS.'img/social/email.svg" /> '.__('MAIL_ADRESS').'</span>
            </a>
        </div>        
        ';

        return $output;
    }

    public function sliderSwap($theme = 'default') {
        $output = '
        <div class="sliderSwap" data-interval="7000" data-element=".rating-img">
            <span class="img-circle rating-img a" data-author="'.__('RATING_1_AUTHOR').'" data-city="Berlin" data-age="20" data-text="'.__('RATING_1_TEXT').'"></span>
            <span class="img-circle rating-img b" data-author="'.__('RATING_2_AUTHOR').'" data-city="Essen" data-age="23" data-text="'.__('RATING_2_TEXT').'"></span>
            <span class="img-circle rating-img c" data-author="'.__('RATING_3_AUTHOR').'" data-city="Hamburg" data-age="31" data-text="'.__('RATING_3_TEXT').'"></span>
            <div class="rating-name">
                <i class="material-icons md-18 green mr7">check_circle</i><span class="author">'.__('RATING_1_AUTHOR').'</span>
                (<span class="age">20</span>) 
                <i class="material-icons md-18 mr7 ml5">location_on</i><span class="city">Berlin</span>
            </div>                                
            <p>“'.__('RATING_1_TEXT').'”</p>
            <div class="stars">
                <i class="material-icons">star</i>
                <i class="material-icons">star</i>
                <i class="material-icons">star</i>
                <i class="material-icons">star</i>
                <i class="material-icons">star</i>
            </div>        
            <div class="f09 pt10">' . __('RATINGS_COUNT') . '</div>                      
        </div>';

        return $output;
    }

    public function footer($theme = 'bright') {
        $nav = init::load('Navigation');
        $add = null;
        if (defined('WWW_EN')) {
            $host_default = str_replace(['https://', '/'], ['www.', ''], WWW);
            $host_en = str_replace(['https://', '/'], ['www.', ''], WWW_EN);
            if ($host_en != $host_default)
                $add = ' &nbsp;&middot;&nbsp; <a href="' . WWW_EN . '" target="_blank">' . $host_en . '</a>';
        }

        $titleBreak = ' &ndash;&nbsp;&nbsp; ';
        $subpagesBreak = ' &nbsp;&nbsp;&middot;&nbsp;&nbsp; ';
        if (IS_MOBILE) {
            $titleBreak = '<br />';
            $subpagesBreak = '<br />';
        }
        $footerClass = null;
        if ($theme == 'dark') {
            $footerClass = ' class="dark"';
        }

        $output = '
        <footer'.$footerClass.'>
            <div class="container">
                <div class="copyright">
                    <span class="logo"><img src="'.ROOT.'img/logo.svg" alt="'.__('PROJECT').' Logo" /></span>
                    <span class="title">&copy; '.date("Y").$titleBreak.'
                    ' . COPYRIGHT_URL.$add. '</span>                
                    ' . $nav->language() . '
                </div>		
                <div class="subpages">
                    <a title="' . __('NAV_HELP') . '" href="' . ROOT . 'imprint">' . __('NAV_HELP') . '</a>'.$subpagesBreak.'
                    <a title="' . __('IMPRINT') . '" href="' . ROOT . 'imprint">' . __('IMPRINT') . '</a>'.$subpagesBreak.'
                    <a title="' . __('DATA_PROTECTION') . '" href="#modal-privacy">' . __('DATA_PROTECTION') . '</a>'.$subpagesBreak.'
                    <a title="' . __('AGB') . '" href="#modal-termsofservice">' . __('AGB') . '</a>
                </div>	
            </div>				
        </footer>';

        return $output;
    }
}