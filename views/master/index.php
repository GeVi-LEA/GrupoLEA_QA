<?php
define('root', __DIR__);
session_start();
ob_start();
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
require_once './../../config/parameters.php';
require_once './../../config/autoload.php';
require_once './../../config/db.php';
require_once './../../utils/utils.php';

// if (isset($_GET['ajax'])) {
// llamarController();
// } else {

?>

<!doctype html>
<html lang="sp" data-theme="light">

<head>
    <meta charset="utf-8" />
    <title><?= (isset($_SESSION['title'])) ? $_SESSION['title'] : '' ?> | LEAGroup ERP <?php echo (AMBIENTE); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="LEAGroup ERP" name="description" />
    <meta content="LEA" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo URL; ?>assets/images/favicon.ico">

    <link rel="stylesheet" href="<?php echo URL; ?>assets/css/jquery-confirm.css">
    <script src="<?php echo URL; ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/popper.min.js"></script>
    <?php require_once views_root . 'master/head-css.php'; ?>

    <!-- Toastr -->
    <link href="<?php echo URL; ?>assets/libs/toastr/toastr.min.css" rel="stylesheet">
    <script src="<?php echo URL; ?>assets/libs/toastr/toastr.min.js"></script>

    <!-- Moment -->
    <script src="<?php echo URL; ?>assets/js/moment.js"></script>
    <style>

    </style>
    <script>
    $(document).ready(function() {
        setTimeout(() => {
            $(document).prop('title', $("#master_title").text() + " | " + $(document).prop('title').split("|")[1]);
        }, 300);
        try {

            llamaNotificaciones();
        } catch (error) {

        }
        let __url__ = "<?php echo root_url; ?>";
        localStorage.setItem("_URL_", __url__);
    });
    </script>

</head>

<body class="body">

    <?php require_once views_root . 'master/body.php'; ?>

</body>

</html>
<?php
// }
?>