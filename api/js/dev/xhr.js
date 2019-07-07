// XHR
var requestSent = false;
function async(element, image, customData, autoload, err, delay) {
    var hash = window.location.hash.substring(1);
    if (customData !== undefined && customData !== 'undefined') {
        var data = (customData);
    } else {
        var data = ($(element).not($(element).attr('data-form')).data());
    }
    // Prevent an accidental clicked button/link by asking if the user is sure:
    if (data['verify'] !== undefined && data['verify']) {
        var form_id = $(element).parent().closest('form').attr('id');
        var task = $(element).attr('data-task');

        $('#modal-verify').modal('show').show();
        $('#modal-verify .modal').attr('style', 'display: block; padding-right: 0 !important');
        $('#modal-verify .modal .verify-content').html(data['verify']);
        $('#modal-verify .modal .modal-footer .yes').attr('data-form', '#' + form_id).attr('data-task', task);

        return false;
    }
    if (data['task']) data.task = data['task'].toString().split(',');
    <?php
    if (isset($_SESSION['rid']) && !empty($_SESSION['rid']))
        echo 'data.RID = "' . $_SESSION['rid'] . '";'; // Referal ID
    if (!isset($_SESSION['step'])) $_SESSION['step'] = 1;
    elseif (isset($_SESSION['step'])) echo 'var step = ' . $_SESSION['step'] . ';';
    else echo 'var step = 0;'; ?>
    var data_get = $(element).attr('data-get');
    if (data_get || (customData !== undefined && customData['get'] === true && customData['post'] === false)) type = 'GET';
    else type = 'POST';

    //$('.modal-one-content-loading').show();
    if (type === 'POST' && ($(this).is('button'))) {
        $(element).css('pointer-events', 'none');
        //$.each($('button'), function( key, value ) {
        var button_id = $(this).attr('id');
        console.warn($(this).attr('id') + ': ' + $(this).hasClass('btn-grey'));
        if ($(this).hasClass('btn-grey') === false) {
            $(this).addClass('btn-grey').removeClass('btn-<?= COLOR ?>');
            if (button_id) {
                setTimeout(function () { // Re-Coloring Button
                    $('#' + button_id).addClass('btn-<?= COLOR ?>').removeClass('btn-grey');
                }, 1000);
            }
        }
        //});
    }
    var upload = $('#dynamic-static').attr('data-upload');
    var gcm = $('#dynamic-static').attr('data-gcm');
    var data_form = $(element).attr('data-form');
    var data_params = $(element).attr('data-params');
    // data (#idForm)
    data.form = '';

    if (data_form) {
        var disabled = $(data_form).find(':input:disabled').removeAttr('disabled');
        data.form = $(data_form).serializeObject();
        data.formID = data_form;
        disabled.attr('disabled', 'disabled');
    }
    if (data_params !== undefined) {
        data.params = data_params.split(',');
    }
    if (data['langAdd']) data.langAdd = data['langAdd'].toString().split(',');
    else if (data['langadd']) data.langAdd = data['langadd'].toString().split(',');

    if (data['index']) $('#remove').val('id,' + data['index']);
    <?php
    if (isset($_SESSION['fb']) && $_SESSION['step'] < 3) { ?>
    if (image !== undefined) data.form.image = image;
    <?php } else { ?>
    if (image !== undefined && upload) data.form.image = image;
    <?php } ?>
    if (!data['disableBlur']) $(element).blur();
    data.lgc = LGC;
    data.session_id = '<?= session_id(); ?>';
    <?php if ((ROOT_CMS_DIR != DIR) || LOCALHOST) { ?>
    data.project = '<?= DIR ?>';
    data.root_username = '<?= ROOT_USERNAME ?>';
    <?php } ?>
    data.uri = '<?= substr($_SERVER['REQUEST_URI'], 1); ?>';
    // Transfer Android FCM Token
    try {
        if (!isEmpty(Cookies.get('storedToken'))) {
            data.token = Android.jsToken();
        }
    } catch (e) {
        console.warn(e);
    }
    console.warn(data);

    if (!requestSent) {
        if (!delay) requestSent = true;
        $.ajax({
            type: type,
            url: "<?= ROOT_CMS; ?>xhr.php",
            cache: false,
            dataType: 'json',
            crossDomain: true,
            data: {data: data},
            success: function (json) {
                // Hide #modal-verify by default:
                $('#modal-verify').hide();
                console.log('--- <  .async  > ---');
                console.dir(json);
                console.log('--- </ .async  > ---');

                if (json.cookie) {
                    console.log('--- cookie save ---');
                    cookieArray = JSON.parse(JSON.stringify(json.cookie));
                    console.log(cookieArray);

                    Object.keys(cookieArray).forEach(function (key) {
                        if (cookieArray[key] != null) Cookies.set(key, cookieArray[key], {expires: 356});
                    });
                }
                // TagIt
                if (json.tagit) {
                    var values = $.map(json.tagit, function (item) {
                        console.warn(item);
                        if (item.id !== -2)
                            return {id: item.id, label: item.label, value: item.label};
                    });
                    console.warn(values);
                    return values;
                }
                if (autoload) { // Infinite Scroll
                    var page_now = parseInt($('#dynamic-static').attr('data-page-now'));
                    var total = parseInt($('#dynamic-static').attr('data-total-pages'));
                    if (page_now == total) $('#load-more').remove();
                    console.warn('page now: ' + page_now);
                    $('[id^=page-]').last().find('#load-more').replaceWith(json.html);
                    $('#page-' + (page_now + 1)).addClass('faded in');
                    $('#dynamic-static').attr('data-page-now', (page_now + 1));
                    json['hide'] = true;
                }
                if (json.modal) $('#modal-' + json.selector).html(json.modal);
                if (json.selector === "two") $('#two .modal-header').remove();
                if (!json['hide'] && !data.hide) {
                    freeze();
                    $('#modal-one, #modal-two').removeClass('out').addClass('in');
                    if (json.selector === 'one') $('#one').modal('show');
                    else $('#' + json.selector).modal({backdrop: 'static', keyboard: false});
                    $('.modal-' + json.selector + '-content-loading').show();
                    setTimeout(function () {
                        $('.modal-' + json.selector + '-content').addClass('faded in').html(json.html);
                    }, 1000);
                }
                setTimeout(function () {
                    $('.modal-' + json.selector + '-content-loading').addClass('faded out');
                }, 400);
                setTimeout(function () {
                    $('.modal-' + json.selector + '-content-loading').hide();
                }, 1000);
                var modal_header = $('.modal-header').text().length;
                if (modal_header > 0) $('.modal-header').show();
                if (json.ckey && json.cval) {
                    $.ajax({
                        data: {ckey: json.ckey, cval: json.cval},
                        url: "<?= ROOT_CMS; ?>static.php",
                        type: "post"
                    });
                }
                if (json.success) {
                    $('.modal-header').hide();
                    if (data['clear'] && data_form) $(data_form).trigger("reset");
                    setTimeout(function () {
                        if (!json.preventClose) {
                            $('#modal-one, #modal-two').addClass('faded out');
                            modalClose();
                        } else {
                            // Only Close Modal Two
                            $('#two').addClass('faded out').html('').hide();
                        }
                        unfreeze();
                    }, 2400);
                } else {
                    setTimeout(function () {
                        $('.modal-footer').slideDown()
                    }, 1000);
                }
                if (json.jss) $('#dynamic-static').html('<script type="text/javascript">' + json.jss + '<\/script>');
                if (json.jsr) $('#dynamic-replace').html('<script type="text/javascript">' + json.jsr + '<\/script>');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (err) return false;
                if (jqXHR.responseText) console.log(jqXHR.responseText);
                modalClose();
                unfreeze();
                location.href = '#modal-error-7';
                <?php if (!$_SESSION['admin']) { ?>
                html2canvas(document.body).then(function (canvas) {
                    errorReport(jqXHR.responseText, canvas);
                });
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
        if (type === 'POST' && ($(this).is('button'))) {
            setTimeout(function () { // Re-Enable Buttons
                $(this).css('pointer-events', 'auto');
            }, 1000);
        }
    }
}
function errorReport(errorText, canvas) {
    Cookies.set('uri', '<?= $_SERVER['REQUEST_URI'] ?>', { expires: 356 });
    var errorData = {
        project: '<?= DIR ?>',
        root_username: '<?= ROOT_USERNAME ?>',
        uri: '<?= $_SERVER['REQUEST_URI'] ?>',
        session_id: '<?= session_id(); ?>',
        cookies: { <?php if (is_array($_COOKIE)) { foreach($_COOKIE as $k => $x) { $k = str_replace('-', '_', $k); $cook[] = ''.$k.': "'.$x.'"'; } echo implode(',', $cook); } ?> },
        lgc: '<?= LGC ?>',
        task: 'errorReport',
        img: canvas.toDataURL('image/jpeg'),
        error: 1,
        errorText: errorText,
        post: 1
    };
    console.log('errorReport: Sending Error Report...');
    console.log(errorData);
    $.ajax({
        type: 'POST',
        url: "<?= ROOT_CMS; ?>xhrError.php",
        cache: false,
        dataType: 'json',
        crossDomain: true,
        data: { data: errorData },
        success: function (data) {
            console.log(data);
        },
        error: function (jqXHR) {
            console.log(jqXHR.responseText);
        }
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
function hashProcess(element) {
    $('#modal-one, #modal-two').hide().modal('hide');
    var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
    $('#dynamic-static').attr('hash', hash);

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

        $('#modal-one, #modal-two').modal('show');
        $('.modal-one-content-loading').show();
        data = {'task': explode[0] + ',' + explode[1], 'lgc': '<?= LGC ?>', 'hash': removeFromHash[0], 'get': getValue};
        async('#modal-one, #modal-two', null, data);
    }
    $('.modal-backdrop').remove();
}
$(window).on('hashchange', function () {
    // Hash Process
    var that = $(this);
    var hash = window.location.hash.substring(1);
    if (hash === undefined) var clear = true;

    if (hash.indexOf('modal') !== -1) {
        console.warn('calling modalClose()');
        modalClose(clear);
    }
    hashProcess(that);
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
        console.warn(hash);
    }
}