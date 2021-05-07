<?php include_once (VIEWS.'header.php')?>
<div class="card" id="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Iniciar Sesión</a></li>
            <li class="breadcrumb-item">Datos de Envío</li>
            <li class="breadcrumb-item"><a href="#">Forma de Pago</a></li>
            <li class="breadcrumb-item"><a href="#">Verificar datos</a></li>
        </ol>
    </nav>
    <div class="card-header">
        <h1><?= $data['subtitle'] ?></h1>  
    </div>
    <div class="card-body">
        <div class="form-group text-left">
            <label for="first_name">Nombre:</label>
            <input type="text" name="first_name" id="first_name" class="form-control"
            required placeholder="Escriba su nombre" value="<?= $data['data']->first_name ?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="last_name_1">Primer apellido:</label>
            <input type="text" name="last_name_1" id="last_name_1" class="form-control" required placeholder="Escriba su primer apellido"
                   value="<?= $data['data']->last_name_1?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="last_name_2">Segundo apellido:</label>
            <input type="text" name="last_name_2" id="last_name_2" class="form-control" placeholder="Escriba su segundo apellido"
                   value="<?= $data['data']->last_name_2?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" required placeholder="Escriba su correo electrónico"
                   value="<?= $data['data']->email?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="address">Dirección:</label>
            <input type="text" name="address" id="address" class="form-control" required placeholder="Escriba su dirección"
                   value="<?= $data['data']->address?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="city">Ciudad:</label>
            <input type="text" name="city" id="city" class="form-control" required placeholder="Escriba su ciudad"
                   value="<?= $data['data']->city ?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="state">Provincia:</label>
            <input type="text" name="state" id="state" class="form-control" required placeholder="Escriba su provincia"
                   value="<?= $data['data']->state ?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="zipcode">Código postal:</label>
            <input type="text" name="zipcode" id="zipcode" class="form-control" required placeholder="Escriba su código postal"
                   value="<?= $data['data']->zipcode ?>" readonly>
        </div>
        <div class="form-group text-left">
            <label for="country">País:</label>
            <input type="text" name="country" id="country" class="form-control" required placeholder="Escriba su país"
                   value="<?= $data['data']->country?>" readonly>
        </div>
        <div class="form-group text-left">
            <a href="<?= ROOT ?>cart/checkout" class="btn btn-success" role="button">Modificar Datos</a>
            <a href="<?= ROOT ?>cart/paymentmode" class="btn btn-success" role="button">Pasar a pago</a>
        </div>
    </div>

</div>
<?php include_once (VIEWS.'footer.php')?>

