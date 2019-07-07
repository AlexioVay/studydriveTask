<?php
ini_set('max_execution_time', 300);
// Minify & Merge: CSS + JS
require_once 'paths.php';
// Call Minifier API:
require_once 'libs/Minifier/minifier.php';
$project = unserialize(PROJECTS);

// "Static" Vars:
$jsF = ['datepicker_de'];
$jsFDefault = ['dragscroll', 'scrollX'];
$cssF = ['default', 'croppie'];

function filename($type, $string) {
    $filename = null;
    $file = explode($type.'/', $string);
    if (!empty($file[1])) $filename = $file[1];
    else $filename = $string;

    return $filename;
}
function mergeFiles(Array $array, $type, $savePath, $saveName) {
    $buffer = null;
    $output = null;
    foreach ($array as $x) {
        $filename = filename($type, $x);
        $comment = '// '.$filename.'';
        if ($type == 'css') $comment = '/* '.$filename.' */';

        $buffer = file_get_contents($x);
        $output .= ''.$comment.'
'.$buffer.'

';
    }
    $fileSaveName = $saveName.'.min.'.$type;
    $fileSave = $savePath.$type.'/'.$fileSaveName;
    file_put_contents($fileSave, $output);
    // Upload to Remote Server:
    $uploadMessage = FTPUpload($fileSave, DIR_CMS.'/'.$type.'/' . $fileSaveName);

    return $uploadMessage;
}
function FTPUpload($LocalPath, $RemotePath) {
    # FTP
    $server = 'ftp://'.ROOT_USERNAME.'.kasserver.com/'.$RemotePath;
    # FTP Credentials
    $ftp_user = ROOT_USERNAME;
    $ftp_password = 'mlpplm00';
    # Upload File
    $ch = curl_init();
    $ftp_file = fopen($LocalPath, 'r');
    curl_setopt($ch, CURLOPT_URL, $server);
    curl_setopt($ch, CURLOPT_USERPWD, $ftp_user.':'.$ftp_password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_UPLOAD, 1);
    curl_setopt($ch, CURLOPT_INFILE, $ftp_file);
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($LocalPath));
    curl_exec($ch);

    return $RemotePath . ' uploaded.<br>';
}

$i = 1;
foreach($project as $k => $p) {
    // Minify
    $dir = $k;
    $rca = 'C:/xampp/htdocs/' . DIR_CMS . '/';
    $ra = 'C:/xampp/htdocs/' . $dir . '/';
    $rc = 'http://localhost/' . DIR_CMS . '/';
    $r = 'http://localhost/' . $dir . '/';
    $jsFiles = null;
    if ($i == 1) {
        foreach ($jsF as $x) $jsFiles[$rca . 'js/dev/' . $x . '.js'] = $rca . 'js/' . $x . '.min.js';
        foreach ($jsFDefault as $x) $jsFiles[$rca . 'js/dev/' . $x . '.js'] = $rca . 'js/dev/' . $x . '.min.js';
        if (is_array($jsFiles)) {
            minifyJS($jsFiles);
        }
    }

    $cssFiles = null;
    if ($i == 1) foreach ($cssF as $x) $cssFiles[$rca . 'css/dev/' . $x . '.css'] = $rca . 'css/' . $x . '.min.css';
    $cssFiles[$ra . 'css/dev/custom.css'] = $ra . 'css/custom.min.css'; // Custom Project File
    if (is_array($cssFiles)) {
        minifyCSS($cssFiles);
    }
    // Upload custom.min.css
    echo FTPUpload($ra . 'css/custom.min.css', $dir.'/css/custom.min.css');

    if ($i == 1) {
        // JavaScript: Merge Multiple Files to 1 Single File:
        $buffer = null;
        $merge = null;
        // - - - JS - - -
        // JS Default Bundle Merge
        $js = null;
        $type = 'js';
        $js[] = $rca . 'js/dev/jquery.min.js';
        #$js[] = $rca . 'js/dev/bootstrap.min.js';
        $js[] = $rca . 'js/dev/dragscroll.min.js';
        $js[] = $rca . 'js/dev/js.cookie.min.js';
        echo mergeFiles($js, $type, $rca, 'default');
        // JS Custom Bundle Merge
        # account
        $js = null;
        $js[] = $rca . 'js/dev/croppie.min.js';
        $js[] = $rca . 'js/dev/nouislider.min.js';
        echo mergeFiles($js, $type, $rca, 'account');
        # mobile
        $js = null;
        $js[] = $rca . 'js/dev/snap.min.js';
        echo mergeFiles($js, $type, $rca, 'mobile');



        // - - - CSS - - -
        // CSS Custom Bundle Merge
        $css = null;
        $css[] = $rc . 'css/dev/croppie.min.css';
        $css[] = $rc . 'css/dev/nouislider.min.css';
        echo mergeFiles($css, 'css', $rca, 'account');
        // CSS Default Bundle Merge
        $type = 'css';
        $css = null;
        #$css[] = $rc . 'css/dev/bootstrap.min.css';
        $css[] = $rc . 'css/default.min.css';
        echo mergeFiles($css, 'css', $rca, 'default');
    }

    echo '<u>'.$i.':</u> '.$dir.' <strong>'.date('H:i:s').' done</strong><br>';
    $i++;
}

exit();
