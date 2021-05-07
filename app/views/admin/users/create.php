<?php include_once (VIEWS.'header.php') ?>
<div class="card p-4 bg-light">
    <div class="card-header">
        <h1 class="text-center">Alta de un usuario administrador</h1>
    </div>
    <div class="card-body">
        <form action="<?= ROOT ?>adminUser/create" method="POST">
            <div class="form-group text-left">
                <label for="name">Usuario:</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Escribe el nombre completo" required
                       value="<?= (isset($data['data']['name'])) ? $data['data']['name'] : '' ?>">
            </div>
            <div class="form-group text-left">
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" class="form-control"
                       placeholder="Escribe el email" required
                       value="<?= (isset($data['data']['email'])) ? $data['data']['email'] : '' ?>">
            </div>
            <div class="form-group text-left">
                <label for="password1">Clave de acceso:</label>
                <input type="password" name="password1" id="password1" class="form-control" required placeholder="Escriba su clave de acceso">
            </div>
            <div class="form-group text-left">
                <label for="password2">Repita su clave de acceso:</label>
                <input type="password" name="password2" id="password2" class="form-control" required placeholder="Repita su clave de acceso">
            </div>
            <div class="form-group text-left">
                <input type="submit" value="Enviar" class="btn btn-success">
                <a href="<?= ROOT ?>adminusers" class="btn btn-info">Regresar</a>
            </div>
        </form>
    </div>
</div>
<?php include_once (VIEWS.'footer.php') ?>
