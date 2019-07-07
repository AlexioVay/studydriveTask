<?php

class Navigation {

    public function language() {
        $output = '<span class="lgc">';
        $lgc_build = null;
        // LGC HTML:
        if (LGC == 'de') {
            $lgc_build .= '
                <img class="flag disabled mr7" src="'.ROOT_CMS.'img/flag/de.svg" alt="Deutsche Sprachauswahl" /><span>DE</span>
                <span class="middot"></span>
                <a href="?lang=en"><img class="flag mr7" src="'.ROOT_CMS.'img/flag/en.svg" alt="Englische Sprachauswahl" title="Switch to English language" />EN</a>
                ';
            $output .= $lgc_build;
        } else {
            $lgc_build .= '
                <a href="?lang=de">
                <img class="flag mr7" src="'.ROOT_CMS.'img/flag/de.svg" alt="German language" title="Inhalte auf Deutsch anzeigen" />DE</a>
                <span class="middot"></span>
                <img class="flag disabled mr7" src="'.ROOT_CMS.'img/flag/en.svg" alt="English language" /><span>EN</span>
                ';
            $output .= $lgc_build;
        }
        $output .= '</span>';

        return $output;
    }

    function admin() {
        // Admin Access:
        $admin = null;
        $br = null;
        if (IS_MOBILE) $br = '<br />';
        if ($_SESSION['admin'])
            $admin .= '
            <li><a href="' . ROOT . 'admin" class="item">
                <i class="material-icons">fingerprint</i>' . __('ADMIN') . '</a>'.$br.'
                <a class="f09 dib" href="'.ROOT.'admin?case=api" class="item sub">API</a>
                <a class="f09 dib" href="'.ROOT.'admin?case=orders" class="item sub">ORDERS</a>
            </li>';

        return $admin;
    }

    function items($signup, $asList = false) {
        global $match;
        $target = $match['target'];

        $output = null;
        $nav = explode(',', NAV);
        $n = null;
        if ($asList) {
            $a = '<li>';
            $b = '</li>';
        }
        // Logged In View:
        if (IS_MOBILE) {
            if ($_SESSION['uid']) {
                $output .= '<ul class="menu logged-in">
                '.$this->admin().'
                <li><a href="' . ROOT . 'settings" class="item"><i class="material-icons">settings</i>' . __('SETTINGS') . '</a></li>
                </ul>
                ';
            }
            $output .= '<ul class="menu">';
        }
        foreach ($nav as $value) {
            switch ($value):
                case 'guarantee': $href = ROOT . 'guarantee'; $class = 'signup'; $title = __('NAV_GUARANTEE'); break;
                case 'signup': $href = $signup; $class = 'signup'; $title = __('NAV_REGISTER'); break;
                case 'news': $href = ROOT . 'news'; $class = 'news'; $title = __('NAV_NEWS'); break;
                case 'ratings': $href = ROOT . '#ratings'; $class = 'ratings'; $title = __('NAV_RATINGS'); break;
                case 'help': $href = ROOT . 'help'; $class = 'help'; $title = __('NAV_HELP'); break;
            endswitch;
            if ($target == $value) $class .= ' active';

            $output .= $a.'<a href="' . $href . '" class="item '.$class.'">'.$title.'</a>'.$b;
        }
        if (IS_MOBILE)
            $output .= '</ul>';

        return $output;
    }

}