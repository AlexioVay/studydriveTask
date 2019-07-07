<?php
/**
 * Created by PhpStorm.
 * User: Alexio
 * Date: 30.03.19
 * Time: 8:16 AM
 */

class Guarantee {

    public function output() {
        $output = '
        <div id="assurance-intro">
            <div class="container">
                <h1>'.__('GUARANTEE_TITLE').'</h1>
                <i class="material-icons">brightness_auto</i>                
                <p>'.__('GUARANTEE_TEXT').'</p>
            </div>  
            <div class="gt"></div>          
        </div>
        
        <div class="container mb40 pt45">
            <div class="row">
                <div class="col-sm-8">        
                    <div id ="assurance-firstP">
                        <h2>'.__('WHY_FEE_TITLE').'</h2>
                        <p class="mt10 pb30">'.__('WHY_FEE_TEXT', [PRICE]).'</p>
                    </div>
                        
                    <hr />
                
                    <div id="job-placement" class="pt25 pb5">
                        <h2>'.__('JOB_CHANCE_TITLE').'</h2>
                        <p class="mt10 mb30">'.__('JOB_CHANCE_TEXT', [PRICE]).'</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <h2 class="f14 green"><i class="material-icons">check_circle</i> '.__('MONEY_BACK_TITLE').'</h2>
                        <p class="mb20 pt5">'.__('MONEY_BACK_TEXT').'</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="assurance-delete">
        
            <div class="container">
                <h2>'.__('QUIT_MEMBERSHIP_TITLE').'</h2>
                <p class="mb20">'.__('QUIT_MEMBERSHIP_TEXT').'</p>
                <form id="deletionForm">
                '.check('deletion').'
                '.check('deletion_lifetime').'
                </form>
                <button data-task="account_delete" data-form="#deletionForm" class="async btn btn-info">'.__('QUIT_MEMBERSHIP_BUTTON').'</button>
            </div>
        
        </div>
        
        </div>';

        return $output;
    }

}