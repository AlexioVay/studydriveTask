<?php
    require_once 'account.min.js';
?>

var uploadCrop;

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            uploadCrop.croppie("bind", {url: e.target.result});
            $("#upload-preview").addClass("ready");
        }
        reader.readAsDataURL(input.files[0]);
    }
}

<?php
if ($data['vheight'])
    echo 'var vheight = '.$data['vheight'].';
    ';
else
    echo 'var vheight = 240;
    ';
?>
uploadCrop = $("#upload-preview");
uploadCrop.croppie({
        enforceBoundary: true,
        enableOrientation: true,
        quality: 1,
        size: 'viewport',
        viewport: {
        width: 240,
        height: vheight,
        type: "square"
    },
    boundary: { width: 280, height: (vheight + 40) },
    exif: true
});
var overlay = $('.cr-overlay').attr('style');
uploadCrop.on('update', function (ev, data) {
        setTimeout(function () {
        overlay = $('.cr-overlay').attr('style');
    }, 200);
    if (overlay !== undefined) {
        $('body').attr('data-upload', 1);
    }
});
<?php
$data['html'] = null;
if ($_SESSION['fb'] && $_SESSION['step'] < 3) {
    $data['html'] = 'http://graph.facebook.com/'.$_SESSION['fb_uid'].'/picture?width=700&height=700';
    $data['height'] = 379;
} else {
    $path = 'upload/users/'.$_SESSION['uid'].'.jpg';
    if (file_exists(ROOT_ABS . $path)) {
        $pimg_url = ROOT . 'upload/users/' . $_SESSION['uid'] . '.jpg'.$_SESSION['pimg_cache'];
        $data['html'] = $pimg_url;
    }
    $data['height'] = 700;
}

$preload_image = true;
if ($preload_image && isset($data) && (!empty($data['html']) && !empty($data['height']))) {
// Load image into croppie element
?>
    console.log('<?= $data['html']; ?>');
    uploadCrop.croppie('bind', {
        url: '<?= $data['html']; ?>',
        points: [0, 0, <?= $data['height']; ?>, 0]
    });
<?php
}
?>

$("#upload").on("change", function () {
    $('body').attr('data-upload', 1);
    readFile(this);
});
function output(node) {
    var existing = $("#result .croppie-result");
    if (existing.length > 0) {
        existing[0].parentNode.replaceChild(node, existing[0]);
    } else {
    $("#result")[0].appendChild(node);
    }
}
function popupResult(result) {
    var html;
    if (result.html) {
        html = result.html;
    }
    if (result.src) {
        $("#result").html("<img id='canvas' src='" + result.src + "' />");
    }
}