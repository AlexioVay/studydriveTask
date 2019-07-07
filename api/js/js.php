<?php
    header('Content-Type: text/javascript; charset=utf-8');
    // Init:
    define('LOCALHOST', ((strpos($_SERVER['HTTP_REFERER'], 'localhost') !== false) || $_SERVER['HTTP_HOST'] == 'localhost') ? true : false);
    define('XFILE', 1);

    $dir = base64_decode($_GET['x']);
    $session_id = $_GET['y'];
    $uri = $_GET['z'];
    $mobile = $_GET['m'];
    // Receive Session:
    if (!empty($session_id)) {
        session_id($session_id);
        session_start();
    }
    // Set Constants:
    define ('URI', substr($uri, 1));
    define ('IS_MOBILE', $mobile);

    // Load dependency:
    if (LOCALHOST)
        require_once 'C:/xampp/htdocs/'.$dir.'/init.php';
    else
        require_once '/www/htdocs/'.$dir.'/init.php';
    // Load JS Must-Have-Functions:
    require_once 'dev/global.php';

    // Inline JS - Minify:
    #if (!LOCALHOST) {
        #$request = ['http' => ['method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => http_build_query(['input' => $buffer])]];
        #$mainContent = file_get_contents('https://javascript-minifier.com/raw', false, stream_context_create($request));
    #}
?>
window.fbAsyncInit=function(){FB.init({appId:"<?= FACEBOOK_APP_ID ?>",cookie:!0,xfbml:!0,version:"v3.2"}),FB.AppEvents.logPageView()},function(e,n,t){var o,c=e.getElementsByTagName(n)[0];e.getElementById(t)||((o=e.createElement(n)).id=t,o.src="https://connect.facebook.net/en_US/sdk.js",c.parentNode.insertBefore(o,c))}(document,"script","facebook-jssdk");

<?php
    switch($match['target']):
        case 'settings':
?>
    // Settings:
    $('#settings #work .add').on('click', function(){
        var id = $(this).attr('data-target');
        var icon = $('.material-icons:last-child', this);
        var icon_text = icon.text();

        setTimeout(function(){
            $(id).find('fieldset input:first').focus();
        }, 200);
    });
    $('#settings .overview a').on('click', function(){
        var id = $(this).attr('data-target');
        var icon = $('.material-icons:last-child', this);
        var icon_text = icon.text();

        faded(icon);
        if (icon_text === 'keyboard_arrow_up')
            icon.text('keyboard_arrow_down');
        else
            icon.text('keyboard_arrow_up');

        setTimeout(function(){
            $(id).find('fieldset input:first').focus();
        }, 200);
    });
<?php
    break;
    case 'home':
?>
    $.each($('.slider'), function(){
        var that = $(this);
        var sliderCount = $(this).children('div').length;
        var interval = $(this).attr('data-interval');
        if (!interval) interval = 5000;
        var bar = that.find('.bar');
        bar.addClass('full');

        setInterval(function () {
            bar.remove();
            setTimeout(function() {
                var bar = that.children('i');
                bar.html('<i class="bar"></i>');
                setTimeout(function() {
                    bar = that.find('.bar');
                    bar.addClass('full');
                }, 100);
            }, 100);

            var sliderActive = that.children('.show');
            var sliderNext = sliderActive.next();
            var sliderIteration = sliderActive.index();
            if (sliderIteration === sliderCount)
                sliderNext = that.children('div').first();

            sliderActive.removeClass('show faded in');
            sliderNext.addClass('show faded in');
        }, interval);
    });
<?php
    break;
    case 'admin':
?>
    $('#DKB').on('click', function() {
        data = { task: 'DKB' };
        async(null, null, data);
    });
<?php
    break;
    case 'signup':

        if ($match['params']['step'] == 3) {
            $rand_timer = mt_rand(7, 12);
            $rand_timer *= 1000;
?>
            body.on('click', '.dummy .accept, .dummy .decline', function (e) {
                e.preventDefault();
                window.location.href = '#modal-example';
            });
            setTimeout(function () {
                $('#verification').hide();
                $('#payForm, .dummy, .verification-success, #last-step').removeClass('dn').show();
            }, <?= $rand_timer ?>);
            $("#keyup_input").keyup(function () {
                calc_discount();
            });
            function payment_check() {
                if ($('#pay_pp').prop('checked') && $('#payForm input[name=termsofservice]').prop('checked')) {
                    $('#payForm').attr('action', 'https://www.paypal.com/cgi-bin/webscr').attr('method', 'post');
                    $('#pay').removeClass('async');
                } else {
                    $('#payForm').attr('action', '').attr('method', '');
                    $('#pay').addClass('async');
                }
            }
            $('#pay, #payform input[type=radio], #payForm input[type=checkbox]').on('click change', function (e) {
                var method = $(this).attr('data-method');
                $('#method').val(method);
                payment_check();
            });
<?php
        }
    break;
    endswitch;

    if (is_array($match['module'])) {
        if (in_array('sticky', $match['module'])) {
            if (!IS_MOBILE) {
            // - - - D e s k t o p - - -
?>
            // Aside Sticky:
            setTimeout(function () {
                // Realize sticky .news-side by setting height:
                var stickyTopContainer = $('.sticky-top-container');
                var relativeHeight = stickyTopContainer.prev().height();
                var stickyHeight = $('.sticky-top').height();
                if (stickyHeight > relativeHeight)
                    stickyTopContainer.css('height', stickyHeight + 'px');
                else
                    stickyTopContainer.css('height', relativeHeight + 'px');
            }, 500);

<?php       }
        }
        if (in_array('croppie', $match['module'])) {
            include ROOT_CMS_ABS . 'js/croppie.php';

    ?>
    function croppie_result(element) {
        <?php
        if ($data['vheight']) $vheight = $data['vheight'];
        else $vheight = 240;
        ?>
        var vheight = '<?= $vheight; ?>';
        uploadCrop.croppie("result", {
            type: "canvas",
            size: {width: 700, height: (vheight * 2.917)},
            format: "jpeg",
            quality: 1,
            circle: false
        }).then(function (resp) {
            popupResult({src: resp});
            async(element, resp);
        });
    }
<?php   }
        if (in_array('sliderSwap', $match['module'])) {
?>
    $.each($('.sliderSwap'), function(){
        var that = $(this);
        var searchElement = 'img';
        if ($(this).attr('data-element')) searchElement = $(this).attr('data-element');
        var sliderCount = $(this).children(searchElement).length;
        var interval = $(this).attr('data-interval');
        if (!interval) interval = 5000;

        setInterval(function () {
            var sliderActive = that.children(searchElement).first();
            var sliderNext = sliderActive.next();
            var sliderNextNext = sliderNext.next();
            var sliderIteration = sliderActive.index();
            var sliderAlt = sliderNext.attr('alt');
            if (searchElement === '.rating-img') {
                var author = sliderNext.attr('data-author');
                var city = sliderNext.attr('data-city');
                var age = sliderNext.attr('data-age');
                var text = sliderNext.attr('data-text');
                $('.rating-name .author', that).text(author);
                $('.rating-name .age', that).text(age);
                $('.rating-name .city', that).text(city);
                $('p', that).text(text);
            }

            if (sliderIteration === sliderCount)
                sliderNext = that.children(searchElement).first();

            sliderActive.removeClass('faded in');
            sliderNext.addClass('faded in');
            $('.title', that).text(sliderAlt);
            faded($('.title', that));

            sliderActive.before(sliderNext);
            sliderNext.after(sliderNextNext);

        }, interval);
    });
<?php   }
        if (in_array('unseen', $match['module'])) {
?>
// - - - Viewport Seen/Unseen - - -
function unseenElements() {
    var unseen = $('.unseen');
    var unseenElement = isTargetVisible(unseen);
    if (unseenElement) {
        console.warn(unseenElement);
        $('#' + unseenElement).removeClass('unseen').addClass('seen tb');
    }
}
function isTargetVisible(element) {
    var returnVal = false;
    $(element).each(function () {
        if ($(this).isInViewport()) {
            returnVal = this.id;
        }
    });
    return returnVal;
}
$.fn.isInViewport = function () {
    var win = $('#content');

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
};
<?php   }
        if (in_array('collapseShowHide', $match['module'])) {
?>
    function collapseShow(element) {
        var href = element.attr('data-target');
        var targetElement = $(href);

        targetElement.addClass('show');
        $(href).show().removeClass('faded out').addClass('faded in');
    }
    $.each($('[data-toggle=collapseShow]:checked'), function() {
        collapseShow($(this));
    });
    $('[data-toggle=collapseShow]').on('click', function(e) {
        collapseShow($(this));
    });
    $('[data-toggle=collapseHide]').on('click', function(e) {
        var href = $(this).attr('data-target');
        var targetElement = $(href);

        targetElement.removeClass('show');
        $(href).removeClass('in').addClass('out');
        setTimeout(function(){
            $(href).hide();
        }, 500);
    });
<?php   }
        if (in_array('collapse', $match['module'])) {
?>
    $('[data-toggle=collapse]').on('click', function(e) {
        var href = $(this).attr('data-target');
        var targetElement = $(href);
        var targetStatus = targetElement.hasClass('show');

        console.log(targetElement);

        if (targetStatus) {
            targetElement.removeClass('show');
            $(href).removeClass('faded in').addClass('faded out');
            setTimeout(function(){
                $(href).hide();
            }, 500);
        } else {
            targetElement.addClass('show');
            $(href).show().removeClass('faded out').addClass('faded in');
            setTimeout(function() {
                $(href).find('input[type=text], input[type=tel], input[type=number]').first().focus();
            }, 500);
        }
    });
<?php   }
        if (in_array('scrollX', $match['module'])) {

        if (!IS_MOBILE)
            require_once 'dev/scrollX.min.js';

        }
        if (in_array('account', $match['module'])) {

        require_once 'dev/bootstrap_datepicker.min.js';
        if (LGC == 'de') require_once 'dev/datepicker_de.min.js';
?>
    // Datepicker Start
    $(document).on('focusin', 'input[data-datepicker-dmyd=1]', function () {
        $(this).datepicker({
            firstDay: 1,
            format: 'dd.mm.yyyy',
            weekStart: 1,
            orientation: 'top',
            autoclose: true,
            nextText: 'M',
            startView: 2,
            changeMonth: true,
            changeYear: true,
            minDate: '-116Y',
            maxDate: 'now',
            yearRange: '-100:+0',
            defaultDate: '-100y-m-d',
            minViewMode: 0,
            maxViewMode: 2,
            defaultViewDate: {year: new Date().getFullYear() - 18, month: 1, day: 1},
            language: '<?= LGC ?>',
            templates: {
                leftArrow: '<i class="material-icons md-24 grey-light">arrow_left</i>',
                rightArrow: '<i class="material-icons md-24 grey-light">arrow_right</i>'
            },
            endDate: '+0d'
        }).on('changeDate', function (ev) {
            var value = $(this).val();
            $(this).next().addClass('filled');
            Cookies.set('birthdate', value, {expires: 356});
        }).on('changeYear', function(e) {
            $(this).next().addClass('filled');
            console.log(e);
        }).on('changeDecade', function(e) {
            $(this).next().addClass('filled');
            console.log(e);
        });
    });
    $(document).on('focusin', 'input[data-datepicker-my=1]', function () {
        $(this).datepicker({
            firstDay: 1,
            format: 'mm/yyyy',
            weekStart: 1,
            orientation: 'top',
            autoclose: true,
            nextText: 'M',
            startView: 2,
            changeMonth: true,
            changeYear: true,
            minDate: '-116Y',
            maxDate: 'now',
            yearRange: '-100:+0',
            defaultDate: '-100y-m-d',
            minViewMode: 1,
            maxViewMode: 2,
            defaultViewDate: {year: new Date().getFullYear() - 18, month: 1, day: 1},
            language: '<?= LGC ?>',
            templates: {
                leftArrow: '<i class="material-icons md-24 grey-light">arrow_left</i>',
                rightArrow: '<i class="material-icons md-24 grey-light">arrow_right</i>'
            },
            endDate: '+0d'
        }).on('changeDate', function (ev) {
            var id= this.id;
            var value = $(this).val();
            $(this).next().addClass('filled');
            Cookies.set(id, value, {expires: 356});
        }).on('changeYear', function(e) {
            $(this).next().addClass('filled');
            console.log(e);
        });
    });
    // Datepicker End


    <?php if (defined('SLIDER') &&
    (($match['target'] == 'settings' && SLIDER == 1) ||
    $match['target'] == 'signup' && $match['params']['step'] == 2 && SLIDER == 1)) { ?>
        function oneValueSlider(name, min, max, start) {
            var slider = document.getElementById(name + '-slider');
            if (start === 'NaN') {
                calc = (max - min) / 2;
                calc += min;
                start = calc;
            }
            noUiSlider.create(slider, {
                range: {
                    'min': min,
                    'max': max
                },
                start: [start],
                connect: [true, false],
                format: {
                    to: function (value) {
                        return Math.round(value);
                    },
                    from: function (value) {
                        return Math.round(value);
                    }
                }
            });
            var heightValues = [document.getElementById(name + '-value')];
            slider.noUiSlider.on('update', function (values, handle) {
                heightValues[handle].innerHTML = values[handle];
                if (name === 'height' || name === 'height-kids')
                    $('#height-value-feet').html(Math.round((values[handle] / 30.48) * 10) / 10);
                else
                    $('#weight-value-lbs').html(Math.round(values[handle] * 2.205));

                $('#input-' + name).val(values[handle]);
                Cookies.set(name, values[handle], {expires: 356});
            });
        }

        /* Adult sizes */
        height = 170;
        weight = 65;
        height_kids = 130;
        weight_kids = 40;
        if (Cookies.get('height')) var height = Cookies.get('height');
        if (Cookies.get('height-kids')) var height_kids = Cookies.get('height-kids');
        if (Cookies.get('weight')) var weight = Cookies.get('weight');
        if (Cookies.get('weight-kids')) var weight_kids = Cookies.get('weight-kids');
        oneValueSlider('height', 140, 220, height);
        oneValueSlider('weight', 40, 200, weight);
        /* Kids sizes */
        oneValueSlider('height-kids', 100, 180, height_kids);
        oneValueSlider('weight-kids', 25, 70, weight_kids);

        $('.switch-sliders').on('click', function () {
            var visibilty = $('#height-kids-slider').is(':visible');
            var text;
            if (!visibilty) {
                text = '<?= __('ADULT_SIZES') ?>';
                $('#height-kids-slider, #weight-kids-slider, #height-kids-value, #weight-kids-value').show();
                $('#height-slider, #weight-slider, #height-value, #weight-value').hide();
                Cookies.set('display_sizes', 'kids', {expires: 356});
            } else {
                text = '<?= __('KIDS_SIZES') ?>';
                $('#height-kids-slider, #weight-kids-slider, #height-kids-value, #weight-kids-value').hide();
                $('#height-slider, #weight-slider, #height-value, #weight-value').show();
                Cookies.set('display_sizes', 'adult', {expires: 356});
            }
            $(this).text(text);
        });

        $('.color-circle').on('click', function () {
            var color = $(this).attr("class").split(' ')[1];
            var parent = $(this).parent().closest('fieldset').attr('id');
            console.log(parent);

            var colors = Array();
            colors.red = '<?= __('RED') ?>';
            colors.black = '<?= __('BLACK') ?>';
            colors.blonde = '<?= __('BLONDE') ?>';
            colors.brown = '<?= __('BROWN') ?>';
            colors.green = '<?= __('GREEN') ?>';
            colors.blue = '<?= __('BLUE') ?>';
            colors.grey = '<?= __('GREY') ?>';

            $('.' + parent + '-value').text(colors[color]);
            $('#input-' + parent).val(color);

            if (parent === 'hair-color')
                Cookies.set('hair_color', color, {expires: 356});
            else
                Cookies.set('eye_color', color, {expires: 356});

            parent = $(this).parent();
            $('.color-circle', parent).removeClass("checked");
            $(this).addClass("checked");
        });
<?php
        }
    }
}


if (!IS_MOBILE) {
    // - - - DESKTOP - - -

    if ($match['header']) {
?>
    // Nav:
    var header_big_nav = $('nav > div > a');
    header_big_nav.on('mouseenter', function () {
        $('img', this).addClass('faded in');
    });
    header_big_nav.on('mouseleave', function () {
        var this_svg = $('img', this);
        this_svg.removeClass('in').addClass('faded out');
        setTimeout(function () {
            this_svg.removeClass('faded in');
        }, 500);
    });
<?php
    }
?>

    $('nav .dropdown, #account .dropdown, .account .dropdown').on('click', function (e) {
        e.stopPropagation();
        var dropdown_menu = $('.dropdown-menu', this);
        var dropdown_display = dropdown_menu.is(':visible');
        console.warn(dropdown_display);
        if (!dropdown_display) {
            dropdown_menu.show();
        } else {
            dropdown_menu.hide();
        }
    });
<?php
} else {
    // - - - MOBILE - - -

    // - - - APP:
    if (!empty(PACKAGE)) {
        if (APP) {
            $total = 0;
            if ($_SESSION['notif_total']) $total = $_SESSION['notif_total'];
?>
    $('.pay-option').hide();
    $('#pay_iap').click();


<?php
        }
    }
    // - - - END OF APP
?>
    var header = $('header');
    var headerOriginal = header;
    var nav = $('nav');
    var lastScrollTop = 0;
    var mainContent = $('#content');
    var header_big = <?php if ($match['header']) echo 'true'; else echo 'false'; ?>;
    if (header_big) header = $('#header-sticky');
    var header_text = $('#header-text');
    var scrollTimer;

    headerHeight = header.height() + nav.height();
    if (header_big)
        mainMargin = headerOriginal.height() + 30;
    else
        mainMargin = header.height() + 30;

    mainContent.on('scroll', function (event) {
        modalContents = 0;
        if ($('.modal').length) modalContents = $('.modal').html().length;


        if (modalContents) {
            header.css('z-index', '0');
        } else {
            var st = $(this).scrollTop();
            var headerShow = false;
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function () {
                if (st < lastScrollTop) { // Scrolling UP:
                    if (header_big && st < mainMargin) {
                        setTimeout(function () {
                            header.removeClass('small');
                        }, 500);
                        if (st < 50) {
                            headerShow = true;
                            header_text.addClass('in').removeClass('out');
                        }
                    } else {
                        headerShow = true;
                    }

                    if (headerShow)
                        header.addClass('in').removeClass('out').css('z-index', '10000');
                } else { // Scrolling DOWN:
                    if (st >= mainMargin) {
                        if (header_big) {
                            setTimeout(function () {
                                header.addClass('small');
                            }, 500);
                        }
                    } else {
                        header.removeClass('out').addClass('in');
                    }
                    if (st >= 50) {
                        header_text.addClass('out').removeClass('in');
                    }
                    header.removeClass('in').addClass('out');

                    setTimeout(function () {
                        header.css('z-index', '0');
                    }, 500);
                }

                //unseenElements();
                lastScrollTop = st;
            }, 30);
        }
    });

    var snapper = new Snap({
        element: document.getElementById('content'),
        dragger: document.getElementById('content'),
        disable: 'right'
    });
    $('#slide-menu-toggle, #slide-menu-toggle.open, .legal').on('click', function(){
        if (snapper.state().state === "left"){
            $(this).removeClass('open');
            snapper.close();
        } else {
            $(this).addClass('open');
            snapper.open('left');
        }
    });
    $('.snap-drawers a, .snap-drawers .logout').on('click', function (e) {
         snapper.close();
    });

<?php
}
?>