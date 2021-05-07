<?php include_once (VIEWS.'header.php') ?>
    <div class="card p-4 bg-light">
        <div class="card-header">
            <h1 class="text-center">Modificación de un usuario administrador</h1>
        </div>
        <div class="card-body">
            <form action="<?= ROOT ?>adminuser/update/<?= $data['user']->id ?>" method="POST">
                <div class="form-group text-left">
                    <label for="name">Usuario:</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="Escribe el nombre completo" required
                           value="<?= (isset($data['user']->name)) ? $data['user']->name : '' ?>">
                </div>
                <div class="form-group text-left">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="Escribe el email" required
                           value="<?= (isset($data['user']->email)) ? $data['user']->email : '' ?>">
                </div>
                <div class="form-group text-left">
                    <label for="password1">Clave de acceso:</label>
                    <input type="password" name="password1" id="password1" class="form-control" placeholder="Clave de acceso (Dejar en blanco si no desea cambiarla)">
                </div>
                <div class="form-group text-left">
                    <label for="password2">Repita su clave de acceso:</label>
                    <input type="password" name="password2" id="password2" class="form-control" placeholder="Repita su clave de acceso">
                </div>
                <div class="form-group">
                    <label for="status">Selecciona un estado</label>
                    <select name="status" id="status" class="form-control">
                        <option value="" disabled>Selecciona el estado del usuario</option>
                        <?php foreach ($data['status'] as $status): ?>
                            <option value="<?= $status->value ?>"
                                <?= $status->value == $data['user']->status ? 'selected' : '' ?>
                            >
                                <?= $status->description ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group text-left">
                    <input type="submit" value="Modificar" class="btn btn-success">
                    <a href="<?= ROOT ?>adminusers" class="btn btn-info">Regresar</a>
                </div>
            </form>
        </div>
    </div>
<?php include_once (VIEWS.'footer.php') ?>
