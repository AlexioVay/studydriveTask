// - - - Initialize - - -
body = $('body');
html = $('html');
main = $('main');
content = $('#content');
let w = window.innerWidth;
let h = window.innerHeight;
console.log("window width: " + w);
console.log("window height: " + h);

var presign = "<?= PRESIGN ?>";
var aftsign = "<?= AFTSIGN ?>";
var id = "<?= ID ?>";
var uid = "<?= $_SESSION['uid'] ?>";
var isMobile = "<?= IS_MOBILE ?>";

// - - -  Set & Save Viewport:
function setViewport(wnow) {
    Cookies.set('viewport', wnow, {expires: 7});
    console.log('Viewport set to ' + wnow);
    processViewport(wnow);
}
function processViewport(wnow) {
    // Reload If Required:
    if ((isEmpty(isMobile) && wnow <= 991) || (!isEmpty(isMobile) && wnow > 991)) {
        window.location.href = '<?= ROOT . URI ?>';
    }
}
var resizeTimeout;
$(window).on('resize', function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        wnow = window.innerWidth;
        setViewport(wnow);
    }, 250);
});
if (isEmpty(Cookies.get("viewport"))) {
    setViewport(w);
}
//processViewport(w);

<?php
    if ($_SESSION['uid']) {
?>
$('.logout').on('click', function () {
    data = { task: 'logout' };
    async(null, null, data);
});
<?php
    }
?>

function isEmpty(str) {
    return typeof str == "string" && !str.trim() || typeof str == "undefined" || str === null || str === undefined || str == 0;
}
function faded(element) {
    element.addClass('faded in');

    setTimeout(function () {
        element.removeClass('faded in');
    }, 500);
}

setTimeout(function () {
    var src, alt;
    $.each($('i.lazy-img'), function () {
        var obj = $(this);
        src = obj.attr('data-src');
        alt = obj.attr('data-alt');
        obj.replaceWith('<img class="faded in" src="' + src + '" alt="' + alt + '" />');
    })
}, 500);

// - - - Input - - -
body.on('click', 'input ~ label', function () {
    $(this).prev().focus();
});
$('#vwzForm input').on('keyup', function (e) {
    var len = $(this).val().length;
    $(this).focus();
    console.warn(len);
    if (len > 3) {
        data = { task: 'vwz', disableBlur: 1 }
        async($(this), null, data, null, null, true);
    }
});
body.on('input click focus', 'input', function (e) {
    var span = $(this).prev();
    var val = $(this).val();
    var name = $(this).attr('name');
    var type = $(this).attr('type');

    if (val)
        $(this).next().addClass('filled');
    else
        $(this).next().removeClass('filled');
    // display preset:
    if (span.length)
        span.removeClass().addClass('visible');

    if (name !== 'zip' && type === 'tel')
        e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{3})/g, '$1 ').trim();
<?php if (LGC == 'DE') { ?>
    if (name === 'zip')
        e.target.value = e.target.value.replace(/[^\dA-Z]/g, '');
<?php } ?>
});
body.on('focusout blur', '.collapse input', function () {
    var val = $(this).val();
    var span = $(this).prev();
    // span is preset:
    if (val.length === 0 && span.length)
        span.removeClass().addClass('hidden');
});
body.on('click', '.material-icons.pass', function () {
    var val = $(this).text();
    faded($('.material-icons.pass'));

    if (val === 'visibility') {
        $(this).text('visibility_off');
        $('i.pass + em input').attr('type', 'password');
    } else {
        $(this).text('visibility');
        $('i.pass + em input').attr('type', 'text');
    }
});
// Save input clicks:
$('input[type=radio], input[type=checkbox]').on('click', function () {
    var value = $(this).val();
    var name = $(this).attr('name');
    var type = $(this).attr('type');

    if (type === 'radio') {
        Cookies.set(name, value, {expires: 356});
    } else {
        var valueImplode = '';
        $("input[name='" + name + "']:checked").each(function (e) {
            var value = $(this).val();
            valueImplode += value + decodeURIComponent(',');
        });
        console.log(valueImplode);
        Cookies.set(name, valueImplode, {expires: 356});
    }
});
$('input[type=tel], input[type=email], input[type=text], input[type=number], textarea').on('input', function () {
    var value = $(this).val();
    var name = $(this).attr('name');
    console.log(name);
    console.log(value);
    Cookies.set(name, value, {expires: 356});
});
body.on('click', '.btn-info, .btn-default', function (e) {
    var val = $(this).html();
    var span = $('span', this).length;

    if (span < 1)
        $(this).html(val + '<span class="loader"></span>');
});

<?php
    if (APP) {
?>
// Default functions
function execFunc(func, input) {
    try {
        var f = func;
        if (input) {
            res = Android[f](input);
        } else {
            res = Android[f]();
        }
        console.log(func + "() - input: " + input + " - success: " + res);
    } catch (e) {
        if (func === "jsShortToast" || func === "jsLongToast") alert(input);
        res = 0;
        console.log(func + "() error: " + e + " - input: " + input);
    }
    return res;
}
function gcm_assign() {
    try {
        storedToken = null;
        currentToken = Android.jsToken();
        if (!isEmpty(Cookies.get("storedToken"))) {
            storedToken = Cookies.get("storedToken");
            console.warn("storedToken: " + storedToken);
        }
        if (currentToken.length < 10) currentToken = null;
        //$("#dynamic-static").attr("data-gcm", currentToken);
        //var root = $("#dynamic-static").attr("data-root");
        if (!isEmpty(currentToken) && (currentToken !== storedToken)) {
            data = {token: currentToken, task: "account,gcm_assign", get: 1, premium: 1 /*boolPremium()*/};
            Cookies.set("storedToken", currentToken, {expires: 1095});
            console.log("GCM Token DB Update: [token => " + currentToken + ", uid => " + uid + "]");
            async($(this), false, data);
        } else {
            console.warn("GCM Token DB NOT Updated: " +
            "[currentToken => " + currentToken + ", " +
            "storedToken => " + storedToken + ", " +
            "uid => " + uid + "]");
        }
    } catch (e) {
    //if (stripos(DEVICE, "android")) header('Location: market://details?id='.PACKAGE.'');
    //Intent;scheme=https;package='.PACKAGE.';end; --- market://details?id= PACKAGE;
    }
}
<?php
    }
?>
$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function elementLoaded(el, cb) {
    if ($(el).length) {
        cb($(el));
    } else {
        setTimeout(function() { elementLoaded(el, cb) }, 500);
    }
}


// - - - Modal - - -

// Freeze Page Content Scrolling:
function freeze(data) {
    var popupStyle = '';
    if (!isEmpty(data.popupStyle)) {
        popupStyle = data.popupStyle;
        console.log(popupStyle);
        setTimeout(function(){
            $('#modalForm .popup .body').attr('style', popupStyle);
        }, 1000);
    }
    elementLoaded('#modalForm .popup .header', function(el) {
        var popupHeader = $('#modalForm .popup .header').height();
        $('#modalForm .popup').attr('style', 'max-height:' + h + 'px');
        $('#modalForm .popup .body').attr('style', 'max-height:' + (h - 112 - popupHeader) + 'px');
    });

    <?php
    if (IS_MOBILE) {
    ?>
    main.css({ 'overflow': 'hidden' });
    $('#header-sticky, #slide-menu-toggle, header.mobile').attr('style', 'position: static');

    <?php
    } else {
    ?>
    if (html.css("position") !== "fixed") {
        var top = html.scrollTop() ? html.scrollTop() : $("body").scrollTop();
        html.css({"width": "100%", "height": "100%", "position": "fixed", "top": -top});
    }
    <?php
    }
    ?>
}
// Unfreeze Page Content Scrolling:
function unfreeze() {
    <?php
    if (IS_MOBILE) {
    ?>
    main.css({ 'overflow': 'visible' });
    $('#header-sticky, #slide-menu-toggle').attr('style', 'position: absolute');
    $('header.mobile').attr('style','');

    <?php
    } else {
    ?>
    if (html.css("position") === "fixed") {
        html.css("position", "static");
        $("html, body").scrollTop(-parseInt(html.css("top")));
        html.css({"position": "", "width": "", "height": "", "top": "", "overflow-y": ""});
    }
    <?php
    }
    ?>
}
// XHR
var requestSent = false;
function async(element, image, customData, autoload, err, delay) {
    if (!isEmpty(customData)) {
        var data = (customData);
    } else {
        var data = $(element).not($(element).attr('data-form')).data();
    }
    var type = 'POST';
    if ($(element).attr('data-get')) type = 'GET';

    data.form = '';
    var data_form = $(element).attr('data-form');
    if (data_form) {
        var disabled = $(data_form).find(':input:disabled').removeAttr('disabled');
        data.form = $(data_form).serializeObject();
        data.formID = data_form;
        disabled.attr('disabled', 'disabled');
    }
    data.RID = '<?= $_SESSION['rid'] ?>';
    data.lgc = '<?= LGC ?>';
    data.session_id = '<?= session_id(); ?>';
    data.uri = '<?= URI ?>';
    if (!data['disableBlur']) $(element).blur();
    if (data['task']) data.task = data['task'].toString().split(',');
    if (!isEmpty($(element).attr('data-params'))) data.params = data_params.split(',');
    if (!isEmpty(image) && body.attr('data-upload')) data.form.image = image;
    // GCM: var gcm = body.attr('data-gcm');
    <?php if ((ROOT_CMS_DIR != DIR) || LOCALHOST) { ?>
    data.project = '<?= DIR ?>';
    data.root_username = '<?= ROOT_USERNAME ?>';
    <?php } ?>
    // Transfer Android FCM Token
    try {
        if (!isEmpty(Cookies.get('storedToken'))) {
            data.token = Android.jsToken();
        }
    } catch (e) {
        console.warn(e);
    }
    console.log(data);

    if (!requestSent) {
        if (!delay) requestSent = true;
        $.ajax({
            type: type,
            url: "<?= ROOT_CMS; ?>xhr.php",
            cache: false,
            dataType: 'json',
            crossDomain: true,
            data: { data: data },
            success: function (json) {
                console.log('--- json return:');
                console.log(json);
                // Save Cookies:
                if (json.cookie) {
                    cookieArray = JSON.parse(JSON.stringify(json.cookie));
                    Object.keys(cookieArray).forEach(function (key) {
                        if (cookieArray[key] != null) Cookies.set(key, cookieArray[key], {expires: 356});
                    });
                }
                // Display Output in PopUp:
                if (!json['hide'] && !data.hide) {
                    var addPopup;
                    if (!isEmpty(json.modalType)) addPopup = json.modalType;
                    popupShow(addPopup, data);

                    setTimeout(function () { $('.popup .load').removeClass().addClass('faded out') }, 300);
                    setTimeout(function () { $('.popup:first .body').addClass('faded in').html(json.html); }, 700);
                }
                if (json.success) {
                    if (data['clear'] && data_form) $(data_form).trigger("reset");
                }
                if (json.jsr) content.after('<script id="jsr" type="text/javascript">' + json.jsr + '<\/script>');
                $('#jsr').remove();
            },
            error: function (jqXHR) {
                if (err) return false;
                if (jqXHR.responseText) console.log(jqXHR.responseText);
                location.href = '#modal-error-occured';
                <?php if (!$_SESSION['admin']) { ?>
                    errorReport(jqXHR.responseText);
                <?php } ?>
            },
            complete: function (xhr, status) {
                $('.btn span').addClass('faded out');
                setTimeout(function () {
                    requestSent = false;
                    $('.btn span').remove();
                }, 500); // Reset AJAX blocking
            }
        });
    }
}
function errorReport(errorText) {
    Cookies.set('uri', '<?= $_SERVER['REQUEST_URI'] ?>', { expires: 356 });
    var errorData = {
        project: '<?= DIR ?>', root_username: '<?= ROOT_USERNAME ?>', uri: '<?= $_SERVER['REQUEST_URI'] ?>', session_id: '<?= session_id(); ?>',
        <?php
        if (is_array($_COOKIE)) {
            foreach ($_COOKIE as $k => $x) {
                $k = str_replace(['-', '/'], '_', $k);
                $cook[] = '' . $k . ': "' . $x . '"';
            }
            if (is_array($cook) && !empty($cook))
                echo 'cookies: { '.implode(',', $cook).' },';
        }
        ?>
        lgc: '<?= LGC ?>', task: 'errorReport', error: 1, errorText: errorText, post: 1
    };
    console.log('errorReport: Sending Error Report...');
    $.ajax({
        type: 'POST',
        url: "<?= ROOT_CMS; ?>xhrError.php",
        cache: false,
        dataType: 'json',
        crossDomain: true,
        data: { data: errorData },
        success: function (data) { console.log(data); },
        error: function (jqXHR) { console.log(jqXHR.responseText); }
    });
}
body.on('click', '.async', function (e) {
    e.preventDefault();
    var ele = $('.cr-image');
    var img_width = ele.attr('width');

    if (ele.length && img_width) {
        croppie_result($(this));
    } else {
        async($(this));
    }
});

/* PopUp */
body.on('click', '.popup .close', function () {
    popupHide(true);
});
function popupShow(type, data) {
    freeze(data);
    // Define Selector:
    var a = '';
    var b = '';

    var selector = content;
    var elementClass = '';
    var bar = '';
    // Fill Success Bar:
    if (type === 'success') {
        bar = '<div class="bar"></div>';
        setTimeout(function () {
            $('.popup.success .bar').addClass('max');
        }, 700);
    }
    var modalForm = $('#modalForm').length;
    if (modalForm > 0) {
        selector = $('.popup:first');
        if (type === 'success') {
            $('.popup:last').addClass('faded out');
            setTimeout(function () {
                $('.popup:last').remove();
            }, 700);
        }
    } else {
        a = '<form id="modalForm">';
        b = '</form>';
    }

    if (type) {
        elementClass = ' ' + type;
    }
    // Create Popup:
    selector.before(a + '<div class="popup' + elementClass + '"><div class="load"><i class="loader"></i><?= __('LOADING') ?></div><div class="body"></div>' + bar + '</div>' + b);
    // Blur Background:
    content.css('opacity', '0.5');
    <?php if (IS_MOBILE) { ?>
    $('#menu, footer').hide();
    setTimeout(function() {
        var popupWidth = $('#modalForm .popup').width();
        $('#modalForm .popup .footer').css('width', popupWidth + 'px');
    });
    <?php } ?>
}
function popupHide() {
    <?php if (IS_MOBILE) { ?>
    $('#menu, footer').show();
    <?php } ?>
    unfreeze();
    $('.popup:first').remove();

    var popupCount = $('.popup').length;
    if (popupCount < 1) {
        $('#modalForm').remove();
        content.css('opacity', '1');
        history.pushState("", document.title, window.location.pathname + window.location.search);
    }
}


// - - -  U R L   H a s h  - - -
function hashProcess(element, popupStyle) {
    var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character

    if (hash.indexOf("modal") !== -1) { // Modal found
        console.warn('"modal" found in hash.');
        var explode = hash.split('-');
        var removeFromHash = hash.split('?');
        var getValue = true;

        <?php
        if (!isset($_SESSION['uid'])) {
        ?>
        var regArray = ['steampay', 'payment'];
        for (i = 0; i < regArray.length; ++i) {
            if (explode[1] === regArray[i]) {
                console.log(regArray[i] + ' was found and user is not signed in.');
                proceed = false;
            }
        }
        <?php } ?>

        data = {'task': explode[0] + ',' + explode[1], 'lgc': '<?= LGC ?>', 'hash': removeFromHash[0], 'get': getValue, 'popupStyle': popupStyle};
        async(null, null, data);
    }
}
$(window).on('hashchange', function () {
    //var hash = window.location.hash.substring(1);
    // Remove Previous Popup if There is one already displayed:
    var popupCount = $('.popup').length;
    var popupStyle = '';
    if (popupCount > 0) {
        popupStyle = $('.popup:last .body').attr('style');
        setTimeout(function () {
            $('.popup:last').remove();
        }, 700);
    }
    // Hash Process
    hashProcess($(this), popupStyle);
});
if (window.location.hash) {
    var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
    expr = '_head';
    console.warn(hash);
    if (hash.indexOf(expr) >= 0) {
        setTimeout(function () {
            location.href = location.hash;
            $('#' + hash).click();
        }, 10);
        console.warn('clicking #' + hash);
    } else if (hash === '_=_') { // Facebook Login, Remove Hash
        history.pushState("", document.title, window.location.pathname + window.location.search);
    } else {
        hashProcess();
    }
}