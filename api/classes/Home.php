<?php

Class Home {

    public function output($data) {
        $output = null;
        $status = $data['status'];
        $signup_button = $data['signup_button'];
        $template = init::load('Template');

        switch (INITIALS):
            case 'ST':

        $output .= '
<div id="status" class="container">
    ' . $status . '
    <hr />                
    <div id="companies" class="slider" data-interval="4000">
        <i></i>
        <div class="one show">
            <img src="'.ROOT.'img/home/ea.svg" width="45" height="45" alt="Electronic Sports" />
            <img src="'.ROOT.'img/home/naughty_dog.svg" width="150" height="55" alt="Naughty Dog" />
            <img src="'.ROOT.'img/home/sega.svg" width="84" height="55" alt="SEGA" />
        </div>
        <div class="two">
            <img src="'.ROOT.'img/home/ubisoft.svg" width="45" height="45" alt="Ubisoft" />
            <img src="'.ROOT.'img/home/bethesda.svg" width="130" height="55" alt="Bethesda" />
            <img src="'.ROOT.'img/home/nintendo.svg" width="120" height="55" alt="Nintendo" />            
        </div>
        <div class="three">
            <img src="'.ROOT.'img/home/rockstar.svg" width="45" height="45" alt="Rockstar" />
            <img src="'.ROOT.'img/home/valve.svg" width="110" height="50" alt="Valve" />
            <img src="'.ROOT.'img/home/microsoft.svg" width="135" height="58" alt="Microsoft" />               
        </div>
    </div>
    <p class="copyright-note">' . __('COPYRIGHT_NOTE') . '</p>
</div>
<div id="ratings" class="dummy" data-snap-ignore="true">
    <div class="gb"></div>
        <div class="container pt30 pb30 tac">
            <div class="row">
                <div class="col-sm-6">	
                    <div itemscope itemtype="' . ROOT . 'signup">
                    <span itemprop="name" class="f12 gc db">' . __('RATING_1_AUTHOR') . '</span>
                    <img class="mb15 mt20 trans-rl img-circle" itemprop="image" src="' . ROOT . 'img/rating/' . __('RATING_1_IMG') . '.webp" width="100" height="100" alt="' . __('PROJECT') . ' ' . __('RATINGS_TITLE') . '" />
                    <p class="pl15 pr15">' . __('RATING_1_TEXT') . '</p>
                        <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating">
                            <div class="f09">
                                <div class="mt15 mb15">
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                </div>
                                <span itemprop="ratingValue">5</span> ' . __('OF') . ' <span itemprop="bestRating">5</span>
                                ' . __('STARS_BASED_ON') . ' <span itemprop="ratingCount">5.122</span> ' . __('RATINGS_IN_TOTAL') . '.
                            </div>
                        </div>
                    </div>
                    <div class="visible-xs mt40 pb30"><hr /></div>
                </div>
            <div class="col-sm-6 tac mb30">
                <div itemscope itemtype="' . ROOT . 'signup">
                    <span itemprop="name" class="f12 gc db">' . __('RATING_2_AUTHOR') . '</span>
                    <img class="mb15 mt20 trans-rl img-circle" itemprop="image" src="' . ROOT . 'img/rating/' . __('RATING_2_IMG') . '.webp" width="100" height="100" alt="Spieletester Meinung" />
                    <p class="pl15 pr15">' . __('RATING_2_TEXT') . '</p>
                        <div itemprop="aggregateRating itemscope itemtype="http://schema.org/AggregateRating">
                            <div class="f09">
                                <div class="mt15 mb15">
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                    <i class="material-icons yellow">star</i>
                                </div>
                                <span itemprop="ratingValue">5</span> ' . __('OF') . ' <span itemprop="bestRating">5</span>
                                ' . __('STARS_BASED_ON') . ' <span itemprop="ratingCount">5.122</span> ' . __('RATINGS_IN_TOTAL') . '.
                            </div>
                        </div>
                </div>  
            </div>
        </div>      
    </div>
    <div class="gt"></div>    
</div>

<div>
    <div class="container">
        <div class="mt40 mb40">
            <div class="row">
                <div class="col-sm-4 tac">
                    <div id="location" class="unseen">
                        <i class="material-icons md-36">location_on</i><br />
                        <h2 class="mt20 mb5 f15 uc">' . __('NATIONAL') . '</h2>
                        <p class="p15 three">' . __('NATIONAL_TEXT') . '</p>
                    </div>
                </div>
                <div class="col-sm-4 tac">
                        <div class="visible-xs mt30"><hr class="mb30" /></div>
                    <div id="exclusive" class="unseen">                            
                        <i class="material-icons md-36">verified_user</i><br />
                        <h2 class="mt20 mb5 f15 uc">' . __('EXCLUSIVE') . '</h2>
                        <p class="p15 three">' . __('EXCLUSIVE_TEXT') . '</p>
                    </div>
                </div>
                <div class="col-sm-4 tac">
                    <div id="relax" class="unseen">
                        <div class="visible-xs mt30"><hr class="mb30" /></div>
                        <i class="material-icons md-36">wb_sunny</i><br />
                        <h2 class="mt20 mb5 f15 uc">' . __('RELAXING') . '</h2>
                        <p class="p15 three">' . __('RELAXING_TEXT') . '</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

                $timeFirst = strtotime(date('Y-m-d H:i:s'));
                $timeSecond = strtotime('2015-12-12 23:59:59');
                $s = $timeFirst - $timeSecond;
                $d = $s / (24 * 60 * 60);
                $ratings_total = floor($d);

                $output .= '
<div class=\'dummy\'>
    <div class=\'gb\'></div>
    <div class=\'container pb35 pt30\'>
        <h2 class=\'green mb25 text-shadow\'>' . __('ACTIVE_GAMERTAG_TITLE') . '</h2>
        <p>' . __('ACTIVE_GAMERTAG_TEXT') . '</p>
    </div>
    <div class=\'gt\'></div>
</div>

<div class="container pb40">
    <div class="row prel">
        <div class="col-sm-8 worldmap">
            <h1 class="text-shadow">' . __('WORLDWIDE_PRESENCE') . '</h1>
            <p class="mb10">' . __('FOOTER_TEXT') . '</p>
            ' . $signup_button . '
        </div>
        <div class="visible-xs pt25">
            <hr />
        </div>
        <div class="col-sm-4 tac mb40 pt40 pb20 mt50">
            <h2>' . __('247_TITLE') . '</h2>
            <p class="db mt5">' . __('247') . '</p>

            <a href="http://facebook.com/' . FACEBOOK_USERNAME . '" target="_blank">
                <div class="mt20 mb10 tac">
                    <span class="fb-bg text-shadow" style="color: #495dca">
                        <span id="button-fb"></span><br />
                        / ' . FACEBOOK_USERNAME . '
                    </span>
                </div>
            </a>
            <strong class="grey-light uc gc fwN">' . __('MAIL_ADRESS') . '</strong>
        </div>
    </div>
</div>';

                break;
            case 'SJ':

                $movies = movies();
                $output .= '
                <div id="status" class="container">
                '.$status;

                if (!$_SESSION['uid']) {
                    $output .=
                    '<hr class="visible-sm visible-xs visible-md" />
                    <a href="'. ROOT .'signup">                 
                        <div id="movies" class="sliderSwap">
                            <h3>' . __('YOUR_ROLE') . '<br />
                            <span class="title">' . $movies[0]['title'] . '</span>?</h3>
                                   
                            <img class="img-shadow faded in" src="' . $movies[0]['img'] . '" alt="' . $movies[0]['title'] . '" />
                            <img class="img-shadow" src="' . $movies[1]['img'] . '" alt="' . $movies[1]['title'] . '" />
                            <img class="img-shadow" src="' . $movies[2]['img'] . '" alt="' . $movies[2]['title'] . '" />
                        </div>
                    </a>';
                }
                $output .= '
                </div>
                
                <hr/>

                <div id="companies" class="container">
                    <img id="amazon" src="'. ROOT .'img/home/amazon.svg" alt="Amazon Video"/>
                    <img id="netflix" src="'. ROOT .'img/home/netflix.svg" alt="Netflix"/>
                    <img id="maxdome" src="'. ROOT .'img/home/maxdome.svg" alt="Paramount"/>
                    <p>'.__('COPYRIGHT_NOTE').'</p>
                </div>';

                if (!$_SESSION['completed']) {
                
                    $output .= '
                    <div id="reviews">
                        <div id="cover">
                            <div>
                                <div class="container tac">
                                    <div class="row">
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <span style="font-size: 2.2em">'. number_format(20000, 0, ',', '.') .'+</span><br/>
                                            <span class="f12">'. __('JOB_PLACEMENTS') .'</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span style="font-size: 2.2em">'. number_format(500, 0, ',', '.') .'+</span><br/>
                                            <span class="f12">'. __('AGENCIES') .'</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <span style="font-size: 2.2em">'. number_format(100, 0, ',', '.').'+</span><br/>
                                            <span class="f12">'. __('COUNTRIES') .'</span>
                                        </div>
                                        <div class="col-sm-offset-1"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="ratings" class="container ratings">
                                <div class="box-shadow">
                                    '.$template->sliderSwap().'                                
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="container boxes-container">
                        <div class="row tac">
                            <div class="col-sm-4">
                                <div id="box-1" class="box unseen">
                                    <img class="exclusive" src="'. ROOT .'img/home/exclusive.svg"
                                         alt="'. __('EXCLUSIVE_TITLE') .'" width="45" height="45"/>
                                    <h3 class="title">'. __('EXCLUSIVE_TITLE') .'</h3>
                                    <p class="text">'. __('EXCLUSIVE_TEXT') .'</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div id="box-2" class="box unseen">
                                    <img class="travel" src="'. ROOT .'img/home/travel.svg"
                                         alt="'. __('TRAVEL_TITLE') .'"
                                         width="45" height="45"/>
                                    <h3 class="title">'. __('TRAVEL_TITLE') .'</h3>
                                    <p class="text">'. __('TRAVEL_TEXT') .'</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div id="box-3" class="box unseen">
                                    <img class="events" src="'. ROOT .'img/home/events.svg"
                                         alt="'. __('EVENTS_TITLE') .'"
                                         width="45" height="45"/>
                                    <h3 class="title">'. __('EVENTS_TITLE') .'</h3>
                                    <p class="text">'. __('EVENTS_TEXT') .'</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gt"></div>
                    <div class="container textbox">
                        <div>
                            <h1>'. __('NO1_TITLE') .'</h1>
                            <p>
                                '. __('NO1_TEXT') .'
                            </p>
                        </div>

                        <hr/>

                        <div class="prel">
                            <h2><i class="material-icons md-20 pink mr10">favorite</i> '. __('PHILOSOPHY_TITLE') .'
                            </h2>
                            <p>'. __('PHILOSOPHY_TEXT') .'</p>
                        </div>

                        <div class="signup-btn sticky-bottom">
                            '. $signup_button .'
                        </div>
                    </div>';

                }

                $output .= $template->contact();

                break;
            case 'VM':
                $accountClass = ' hideSlider';
                if (!$_SESSION['completed']) $accountClass = ' setHeight';
                $output .= '
                <div id="status" class="container'. $accountClass .'">
                    '. $status;

                if (!$_SESSION['uid']) {
                    $output .= '
                    <hr class="visible-md visible-sm"/>
                        <div id="slider" class="slider faded in" data-interval="5000">
                            <i></i>
                            <div class="one show">
                                <img src="' . ROOT . 'img/slider/1.jpg" alt="Claire" />
                            </div>
                            <div class="two">
                                <img src="' . ROOT . 'img/slider/2.jpg" alt="Stephan" />
                            </div>
                            <div class="three">
                                <img src="' . ROOT . 'img/slider/3.jpg" alt="Jill" />
                            </div>                    
                        </div>';
                }

                $output .= '
                </div><!-- end of #status -->
                                        
                <hr class="hidden-xs"/>

                <div id="companies" class="container">
                    <img id="tommy" src="'. ROOT .'img/home/tommy.svg" alt="Tommy Hilfiger"/>
                    <img id="chanel" src="'. ROOT .'img/home/chanel.svg" alt="Chanel"/>
                    <img id="gntm" src="'. ROOT .'img/home/GNTM_Logo.svg" alt="Germany\'s Next Top Model"/>
                    <img id="mfm" src="'. ROOT .'img/home/MFM.svg" alt="McFIT Models"/>
                    <img id="emporio" src="'. ROOT .'img/home/emporio.svg" alt="Emporio Armani"/>
                    <p>'. __('COPYRIGHT_NOTE') .'</p>
                </div>';

                if (!$_SESSION['completed']) {

                $output .= '
                <div id="rating-container">

                    <div id="cover">
                        <div>
                            <div class="container tac">
                                <div class="row">
                                    <div class="col-sm-3 col-sm-offset-1">
                                        <span style="font-size: 2.2em">'. number_format(30000, 0, ',', '.') .'+</span><br/>
                                        <span class="f12">'. __('JOB_PLACEMENTS') .'</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span style="font-size: 2.2em">'. number_format(500, 0, ',', '.') .'+</span><br/>
                                        <span class="f12">'. __('AGENCIES') .'</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span style="font-size: 2.2em">'. number_format(100, 0, ',', '.') .'+</span><br/>
                                        <span class="f12">'. __('COUNTRIES') .'</span>
                                    </div>
                                    <div class="col-sm-offset-1"></div>
                                </div>
                            </div>
                        </div>

                        <div id="ratings" class="container ratings">
                            <div>
                            '.$template->sliderSwap().'
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="container boxes-container">
                    <div class="row tac">
                        <div class="col-sm-4">
                            <div id="box-1" class="box unseen">
                                <div>
                                    <img class="exclusive" src="'. ROOT .'img/home/exclusive.svg"
                                         alt="'. __('EXCLUSIVE_TITLE') .'" width="45" height="45"/>
                                </div>
                                <h3 class="title">'. __('EXCLUSIVE_TITLE') .'</h3>
                                <p class="text">'. __('EXCLUSIVE_TEXT') .'</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div id="box-2" class="box unseen">
                                <div>
                                    <img class="travel" src="'. ROOT .'img/home/travel.svg"
                                         alt="'. __('TRAVEL_TITLE') .'"
                                         width="45" height="45"/>
                                </div>
                                <h3 class="title">'. __('TRAVEL_TITLE') .'</h3>
                                <p class="text">Paris, Mailand, New York: '. __('TRAVEL_TEXT') .'</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div id="box-3" class="box unseen">
                                <div>
                                    <img class="events" src="'. ROOT .'img/home/events.svg"
                                         alt="'. __('EVENTS_TITLE') .'"
                                         width="45" height="45"/>
                                </div>
                                <h3 class="title">'. __('EVENTS_TITLE') .'</h3>
                                <p class="text">'. __('EVENTS_TEXT') .'</p>
                            </div>
                        </div>
                    </div>
                </div>';

            }

            $output .= '
<div class="gt"></div>
<div class="container textbox inline">

    <div>
        <hr />
        <span>
            <i class="material-icons md-20 mr10">how_to_reg</i> <h2>' . __('ADVANTAGES_1_TITLE') . '</h2>
        </span>
        <div class="row justify">
            <div class="col-sm-6">            
                <p>' . __('ADVANTAGES_1_TEXT_1') . '</p>
            </div>
            <div class="col-sm-6">            
                <p>' . __('ADVANTAGES_1_TEXT_2') . '</p>
            </div>
        </div>     
    </div>
    
    <div>
        <hr />
        <span>
            <i class="material-icons md-20 mr10">fingerprint</i> <h2>' . __('ADVANTAGES_2_TITLE') . '</h2>
        </span>
        <div class="row justify">
            <div class="col-sm-6">            
                <p>' . __('ADVANTAGES_2_TEXT_1') . '</p>
            </div>
            <div class="col-sm-6">            
                <p>' . __('ADVANTAGES_2_TEXT_2') . '</p>
            </div>
        </div>    
    </div>
        
    <div>
        <hr />    
        <span>
            <i class="material-icons md-20 mr10">looks_5</i> <h2>' . __('ADVANTAGES_3_TITLE') . '</h2>
        </span>
        <div class="row justify">
            <div class="col-sm-6">            
                <p>' . __('ADVANTAGES_3_TEXT_1') . '</p>
            </div>
            <div class="col-sm-6">            
                <p>' . __('ADVANTAGES_3_TEXT_2') . '</p>
            </div>
        </div>         
    </div>    
    <div class="signup-btn sticky-bottom">      
    ' . $signup_button . '
    </div>       
    
</div>

' . $template->contact();

        break;
        case 'WF':

        break;
        endswitch;

        return $output;
    }
}