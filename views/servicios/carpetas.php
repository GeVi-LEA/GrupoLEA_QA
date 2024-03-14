<?php

require_once base . '/composer/vendor/autoload.php';

require_once utils_root . 'folder_tree/src/jQueryFM/Helper.php';
require_once utils_root . 'folder_tree/src/jQueryFM/FileProvider/Base.php';
require_once utils_root . 'folder_tree/src/jQueryFM/FileProvider/FS.php';

require_once utils_root . 'folder_tree/src/jQueryFM/FileManager.php';
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$manager = new jQueryFM_FileManager(views_root . 'servicios/uploads/' . $servicios['numUnidad']);
// $manager                = new jQueryFM_FileManager(URL . '/views/servicios/uploads/' . $servicios['numUnidad']);
$manager->ajax_endpoint = $actual_link . '&isolated=true';
$manager->icons_url     = URL . 'utils/folder_tree/assets/img/fileicons';

// Basic file explorer
$basic                = new jQueryFM_FileManager(views_root . 'servicios/uploads/' . $servicios['numUnidad']);
$basic->ajax_endpoint = $actual_link . '&isolated=true';
$basic->allow_editing = true;
$basic->allow_upload  = true;
$basic->allow_folders = true;
$basic->icons_url     = $manager->icons_url;

if (isset($_GET['isolated'])) {
    $manager->process_request();
    return;
}

?>

<link href="<?= URL ?>/utils/folder_tree/assets/css/jquery_fm.min.css" rel="stylesheet">
<meta charset="utf-8">
<title>jQuery File Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- <link href="<?= URL ?>/utils/folder_tree/assets/css/jquery_fm.min.css" rel="stylesheet"> -->

<style>

</style>
<script>
var urlcarpeta = "<?= $actual_link ?>";
</script>
<!-- <script src="<?= URL ?>/utils/folder_tree/static/js/jquery.js"></script> -->
<div class="container">

    <div class="page-header">
        <h1><strong>Número de unidad:</strong> <?= (($servicios['numUnidad']) ? $servicios['numUnidad'] : 'numUnidad') ?></h1>
    </div>
    <!-- <h2>Full featured</h2>
    <div id="full"></div> -->

    <h2>Carpeta de archivos</h2>

    <div id="basic"></div>

</div>

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> -->
<script>
window.jQuery || document.write('<script src="<?= URL ?>/utils/folder_tree/static/js/jquery.js"><\/script>')
</script>
<!-- Only if we want fancy modal windows for prompt and confirm -->
<script src="<?= URL ?>/utils/folder_tree/assets/js/modal.min.js"></script>
<script src="<?= URL ?>/utils/folder_tree/assets/js/jquery_fm.min.js"></script>
<?php
// echo $manager->render('full');

echo $basic->render('basic');
?>