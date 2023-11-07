<div class ="col-5 d-flex flex-column login">
    <div class="align-self-center flex-column">
        <Strong class="d-block p-2 titulo-recupera">Recuperar contraseña:</Strong>
    </div>
    <form class="d-flex flex-column align-items-center" id="formularioLogin" method="POST" action="<?= root_url ?>?controller=Login&action=recuperarPass">
       <input type="text" value="<?=$_GET['codigo']?>" name="get" id="get" hidden>
        <div class="input-group form-group w-75">
            <div class="input-group-prepend">
                <span class="input-group-text iconos"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" name="user" maxlength="10" id="user" value="<?=$_SESSION['usuario']->user?>" readonly=""">
        </div>
        <div class="input-group form-group w-75">
            <div class="input-group-prepend ">
                <span class="input-group-text iconos"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" name="password" id="password" placeholder="Nuevo password">
        </div>
        <div class="input-group form-group w-75">
            <div class="input-group-prepend ">
                <span class="input-group-text iconos"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" placeholder="Confirma password">
        </div>

        <div class="form-group">
            <input type="submit" value="Recuperar" id=btnRecuperar" class="btn float-right loginBtn">
        </div>
    </form>
</div>
<div class="text-center recupera">
   
    </div>
</div>
