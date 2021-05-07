<?php include_once 'header.php' ?>
<div class="card p-4 bg-light">
    <div class="card-header">
        <h1 class="text-center"><?= $data['subtitle'] ?></h1>
    </div>
    <div class="card-body">
        <form action="<?= ROOT ?>login/changePassword/<?= $data['data'] ?>" method="POST">
            <input type="hidden" name="id" value="<?= $data['data'] ?>">
            <div class="form-group text-left">
                <label for="password1">Clave de acceso:</label>
                <input type="password" name="password1" id="password1" class="form-control" required placeholder="Escriba su clave de acceso">
            </div>
            <div class="form-group text-left">
                <label for="password2">Repita clave de acceso:</label>
                <input type="password" name="password2" id="password2" class="form-control" required placeholder="Repita su clave de acceso">
            </div>
            <div class="form-group text-left">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="submit" value="Cambiar clave" class="btn btn-success btn-block">
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= ROOT ?>login/" class="btn btn-info btn-block">Regresar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include_once 'footer.php' ?>
