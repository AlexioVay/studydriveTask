// - - - Initialize - - -
body = $('body');
// Add 'fade in' and remove it afterwards:
function isEmpty(str) {
    return typeof str == "string" && !str.trim() || typeof str == "undefined" || str === null || str === undefined || str == 0;
}
function faded(element) {
    element.addClass('faded in');

    setTimeout(function () {
        element.removeClass('faded in');
    }, 500);
}
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

    if (type === 'tel')
        e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{3})/g, '$1 ').trim();

    if (LGC == 'de') {
        if (name === 'zip')
            e.target.value = e.target.value.replace(/[^\dA-Z]/g, '');
    }
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
$('.btn-info, .btn-default').on('click', function () {
    var val = $(this).html();
    var span = $('span', this).length;

    if (span < 1)
        $(this).html(val + '<span class="loader"></span>');
});



// - - - Modal - - -
// Serialize Objects
function modalClose(clear) {
    $('.modal-header, .modal-one-content').text('').hide();
    $('.modal-one-content').hide();
    $('#dynamic-static').attr('data-page-now-async', '');
    $('.modal-backdrop').remove();
    body.removeClass('modal-open').attr('style', '');
    $('#modal-one .modal-footer, #modal-two .modal-footer').hide();
    $('.modal-one-content-loading').show();
    $('#modal-one, #modal-two').html('').modal('hide');
    $('#modal-one .modal, #modal-two .modal').remove();
    if (clear) history.pushState("", document.title, window.location.pathname + window.location.search);
}
// Modal Hide
body.on('hidden.bs.modal', function (e) {
    var modal_id = e.target.id;
    var old_hash = $('#dynamic-static').attr('hash');
    var hash = window.location.hash.substring(1);
    if (old_hash === hash) var clear = true;

    // Only close modal one if modal two not there:
    var close_both = true;
    var modal_two = $('#modal-two').html().length;
    var modal_one = 0;
    setTimeout(function () {
        modal_one = $('#modal-one').html().length;
        if (modal_two > 0) {
            close_both = false;
            $('#modal-two').hide();
            $('#modal-two').html('').modal('hide');
            if (modal_one === 0) close_both = true;
        }
        if (close_both) modalClose(clear);
    }, 10);
    if (modal_one < 1 && modal_two < 1) unfreeze();
});
body.on('shown.bs.modal', function (e) {
    body.attr('style', '');
    $('#modal-one .modal, #modal-two .modal').attr('style', 'display: block; padding-right: 0 !important');
    setTimeout(function () {
        $(this).find('input:first-child').focus();
    }, 1000);
    $('.modal-backdrop').not('.modal-backdrop:first').remove(); // Prevent multiple layers of .modal-backdrop
    $('#modal-one, #modal-two').show();
});
body.on('click', 'a[data-dismiss=modal]', function (e) {
    unfreeze();
});
//Freeze page content scrolling
function freeze() {
    if ($("html").css("position") != "fixed") {
        var top = $("html").scrollTop() ? $("html").scrollTop() : $("body").scrollTop();
        $("html").css({"width": "100%", "height": "100%", "position": "fixed", "top": -top});
    }
}
//Unfreeze page content scrolling
function unfreeze() {
    if ($("html").css("position") == "fixed") {
        $("html").css("position", "static");
        $("html, body").scrollTop(-parseInt($("html").css("top")));
        $("html").css({"position": "", "width": "", "height": "", "top": "", "overflow-y": ""});
    }
}