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