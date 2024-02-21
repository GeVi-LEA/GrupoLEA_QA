<div id="loading">
    <?php require_once views_root . 'master/loader.php'; ?>
</div>

<?php require_once views_root . 'master/sidebar.php'; ?>


<main class="main-content">
    <div class="position-relative">
        <?php require_once views_root . 'master/header_bar.php'; ?>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <br /><br />
        <?php llamarController(); ?>

    </div>
    <!-- <br /> -->
    <!-- <br /> -->
    <?php require_once views_root . 'master/footer.php'; ?>
</main>

<div id="back-to-top" style="display: none;">
    <a class="btn btn-primary btn-xs p-0 position-fixed top" id="top" href="#top">
        <svg width="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 15.5L12 8.5L19 15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </a>
</div>


<?php require_once views_root . 'master/scripts.php'; ?>
<script>
var __url__ = "<?php echo root_url; ?>";
localStorage.setItem("_URL_", __url__);
</script>

<?php require_once views_root . 'master/app_toast.php'; ?>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="main_form"></div>
            </div>
        </div>
    </div>
</div>


<?php
require_once views_root . 'erp/notificaciones.php';

function llamarController()
{
    $_SESSION['title'] = '';
    if (isset($_GET['controller'])) {
        $nombre_controlador = $_GET['controller'] . 'Controller';
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $nombre_controlador = controller_principal;
    } else {
        show_error();
        exit();
    }

    if (class_exists($nombre_controlador)) {
        $controlador = new $nombre_controlador();
        if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
            $action = $_GET['action'];
            $controlador->$action();
        } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
            $default = action_default;
            $controlador->$default();
        } else {
            show_error();
        }
    } else {
        show_error();
    }
}

?>