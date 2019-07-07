var scrollSelector = $('.scroll-x');
var current_x = 0;
var ScrollX_pixelPer = 30;
var delta;
/* Mousewheel scroll horizontally: */
function currentScrollWidth(element) {
    var newScrollLeft = $(element).scrollLeft(),
    width = $(element).width(),
    scrollWidth = $(element).get(0).scrollWidth;
    scrollFullWidth = scrollWidth - (width + newScrollLeft / 33);

    return scrollFullWidth;
}

function fadedIn(element) {
    setTimeout(function () {
        if (element.is(':visible')) {
            return false;
        } else {
            element.addClass('faded in').show();
            setTimeout(function () {
                element.removeClass('faded in');
            }, 700);
        }
    }, 500);
}
function fadedOut(element) {
    element.addClass('faded out');
    setTimeout(function () {
        element.removeClass('faded out').hide();
    }, 700);
}
scrollSelector.on("scroll", function(e) {
    var scrollLeftArrow = $(this).prev('.scroll-arrow-container').children('.scroll-arrow.left');
    var scrollRightArrow = $(this).prev('.scroll-arrow-container').children('.scroll-arrow.right');
    var scrollFullWidth = currentScrollWidth($(this));
    scrollLeft = e.originalEvent.srcElement.scrollLeft;
    console.log('full:' +scrollFullWidth);

    // Left arrow:
    if (scrollLeft > 89) {
        fadedIn(scrollLeftArrow);
    } else {
        fadedOut(scrollLeftArrow);
    }
    // Right arrow:
    if (scrollLeft > scrollFullWidth) {
        fadedOut(scrollRightArrow);
    } else {
        fadedIn(scrollRightArrow);
    }
    console.log(scrollLeft);
    console.log(scrollFullWidth);
});
scrollSelector.on("mousewheel", function(e) {
    e.preventDefault();
    var scrollFullWidth = currentScrollWidth($(this));
    var scrollRightArrow = $(this).prev('.scroll-arrow-container').children('.scroll-arrow');
    // Get the deltaY (always +/- 33.33333206176758) and multiply by the pixel increment
    delta = ScrollX_pixelPer * (parseInt(e.originalEvent.deltaY) / 33);

    if (current_x < 0) {
        current_x = 0;
    } else if ((scrollFullWidth - 90) > current_x || delta < 0) {
        current_x += delta;
    } else { // Edge hit, therefore do a last scroll and hide right arrow:
        $(this).scrollLeft(current_x + 90);
        return false;
    }
    console.warn('scrollFullWidth: ' + scrollFullWidth);
    console.warn('current_x: ' + current_x);

    // Apply the new position.
    $(this).scrollLeft(current_x);
});
$(".scroll-arrow").on("click", function(e) {
    e.preventDefault();
    var scrollX_div = $(this).parent().next('.scroll-x');
    var scrollFullWidth = currentScrollWidth(scrollX_div);

    if ($(this).is('.right')) {
        console.warn('scrollFullWidth: ' + scrollFullWidth);
        console.warn('current_x + 90: ' + (current_x + 90));

        if (scrollFullWidth > (current_x + 90)) {
            current_x += 200;
        } else {
            scrollX_div.scrollLeft(current_x + 90);
            return false;
        }
    } else {
        current_x -= 200;
    }
    scrollX_div.scrollLeft(current_x);
});