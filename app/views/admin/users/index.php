<?php include_once (VIEWS.'header.php') ?>
<div class="card p-4 bg-light">
    <div class="card-header">
        <h1 class="text-center">Lista de usuarios</h1>
    </div>
    <div class="card-body">
        <table  class="table table-striped text-center" width="100%">
            <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Modificar</th>
                <th>Borrar</th>
            </thead>
            <tbody>
                <?php foreach ($data['data'] as $user): ?>
                    <tr>
                        <td class="text-center"><?= $user->id ?></td>
                        <td class="text-center"><?= $user->name ?></td>
                        <td class="text-center"><?= $user->email ?></td>
                        <td><a href="<?= ROOT ?>adminUser/edit/<?= $user->id ?>" class="btn btn-info">Modificar</a></td>
                        <td><a href="<?= ROOT ?>adminUser/delete/<?= $user->id ?>" class="btn btn-danger">Borrar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-6">
                <a href="<?= ROOT ?>adminUser/create" class="btn btn-success">
                    Crear usuario <i class="fas fa-user-plus"></i>
                </a>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
</div>
<?php include_once (VIEWS.'footer.php') ?>
