<?php include_once (VIEWS.'header.php') ?>
<div class="card p-4 bg-light">
    <div class="card-header">
        <h1 class="text-center">Eliminación de un producto</h1>
    </div>
    <div class="card-body">
        <form action="<?= ROOT ?>adminproduct/delete/<?= $data['product']->id ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group text-left">
                <label for="type">Tipo de producto:</label>
                <select class="form-control" name="type" id="type" disabled>
                    <option value="">Selecciona el tipo de producto</option>
                    <?php foreach($data['type'] as $type): ?>
                        <option value="<?= $type->value ?>"
                            <?= (isset($data['product']->type) && $data['product']->type == $type->value) ? ' selected' : '' ?>
                        >
                            <?= $type->description ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group text-left">
                <label for="name">Nombre:</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Escribe el nombre del producto" disabled
                       value="<?= (isset($data['product']->name)) ? $data['product']->name : '' ?>">
            </div>
            <div class="form-group text-left mt-3">
                <input type="submit" value="Enviar" class="btn btn-success">
                <a href="<?= ROOT ?>adminproduct" class="btn btn-info">Regresar</a>
            </div>
        </form>
    </div>
</div>
<?php include_once (VIEWS.'footer.php') ?>

