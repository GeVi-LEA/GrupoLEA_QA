<div class="d-flex flex-column login">
      <div class="align-self-center flex-column">
            <img src="assets/img/logo_lea.png" />
      </div>
      <form class="d-flex flex-column align-items-center" id="formularioLogin" method="POST" action="<?= root_url ?>?controller=Login&action=login">
            <div class="input-group form-group w-75">
                  <div class="input-group-prepend">
                        <span class="input-group-text iconos"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="user" maxlength="10" id="user" placeholder="usuario">
            </div>
            <div class="input-group form-group w-75">
                  <div class="input-group-prepend ">
                        <span class="input-group-text iconos"><i class="fas fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" name="password" id="password" placeholder="password">
            </div>

            <div class="form-group">
                  <input type="submit" value="Entrar" class="btn float-right loginBtn">
            </div>
      </form>
</div>
<div class="text-center recupera">
      <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
      <?php if (isset($_SESSION['error']['usuario']) && !empty($_SESSION['error']['usuario'])): ?>
      <div class="error">
            <ul id="error">
                  <li><b><?= $_SESSION['error']['usuario']; ?></b></li>
            </ul>
      </div>
      <?php else: ?>
      <div>
            <a href="" data-toggle="modal" data-target="#recuperaModal">¿Olvidaste tu contraseña?</a>
      </div>
      <div class="error">
            <ul id="error">
                  <li><b><?= isset($_SESSION['error']['password']) ? $_SESSION['error']['password'] : null; ?></b></li>
                  <li><b><?= isset($_SESSION['error']['envioCorreo']) ? $_SESSION['error']['envioCorreo'] : null; ?></b></li>
                  <li><b><?= isset($_SESSION['error']['codigo']) ? $_SESSION['error']['codigo'] : null; ?></b></li>
                  <li><b><?= isset($_SESSION['error']['updatePass']) ? $_SESSION['error']['updatePass'] : null; ?></b></li>
            </ul>
      </div>
      <?php endif; ?>

      <?php elseif (isset($_SESSION['ok']) && !empty($_SESSION['ok'])): ?>
      <div class="ok">
            <ul id="ok">
                  <li><b><?= isset($_SESSION['ok']['updatePass']) ? $_SESSION['ok']['updatePass'] : null; ?></b></li>
                  <li><b><?= isset($_SESSION['ok']['envioCorreo']) ? $_SESSION['ok']['envioCorreo'] : null; ?></b></li>
            </ul>
      </div>
      <?php
            endif;
           Utils::deleteSession('ok');
           Utils::deleteSession('error');
           ?>
</div>
</div>