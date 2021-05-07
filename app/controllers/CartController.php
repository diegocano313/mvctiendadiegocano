<?php

class CartController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Cart');
    }

    public function addProduct($product_id, $user_id)
    {

        $errors = [];
        if ( ! $this->model->verifyProduct($product_id, $user_id)) {
            //var_dump("No existe ese producto en el carro de este usuario");
            if ( ! $this->model->addProduct($product_id, $user_id)) {
                array_push($errors, 'Error al insertar el producto en el carrito');
            }
            else {
                //var_dump("Producto añadido al carro de este usuario");
            }
        }
        else {
            //var_dump("Ya existe ese producto en el carro del usuario");
        }
        $this->index($errors);
    }

    public function index($errors = [])
    {
        $session = new Session();

        if ($session->getLogin()) {
            $user_id = $session->getUserId();
            $cart = $this->model->getCart($user_id);
            $data = [
                'titulo'    => 'Carrito',
                'menu'      => true,
                'user_id'   => $user_id,
                'data'      => $cart,
                'errors'    => $errors,
            ];
            $this->view('carts/index', $data);
        } else {
            header('location:'.ROOT);
        }
    }

    public function update()
    {
        if (isset($_POST['rows']) && isset($_POST['user_id'])) {
            $errors = [];
            $rows = $_POST['rows'];
            $user_id = $_POST['user_id'];
            for ($i = 0; $i < $rows; $i++) {
                $product_id = $_POST['i'.$i];
                $quantity = $_POST['c'.$i];
                if( ! $this->model->update($user_id, $product_id,$quantity)) {
                    array_push($errors, 'Error al actualizar el producto ' . $i+1);
                }
            }
            $this->index($errors);
        }
    }

    public function delete($product, $user)
    {
        $errors = [];
        if ( ! $this->model->delete($product, $user)) {
            array_push($errors, 'Error al borrar el registro en el carrito');
        }
        $this->index($errors);
    }

    public function checkout()
    {
        $session = new Session();
        if ( $session->getLogin()) {
            $user = $session->getUser();
            $data = [
                'titulo'    => 'Carrito - Datos de envío',
                'subtitle'  => 'Carrito - Verificar dirección de envío',
                'menu'      => true,
                'data'      => $user,
            ];
            $this->view('carts/address', $data);
        } else {
            $data = [
                'titulo'    => 'Carrito - Checkout',
                'subtitle'  => 'Checkout - Iniciar sesión',
                'menu'      => true,
            ];
            $this->view('carts/checkout', $data);
        }
    }

    public function verificarDatos(){
        $session = new Session();
        $user = $session->getUser();
        
        $data = [
            'titulo'    => 'Carrito | Validar datos',
            'subtitle'  => 'Usuario | Valide informacion de envio',
            'menu'      => true,
            'data'      => $user,
        ];
        $this->view('carts/verificarDatos', $data);
    }

    public function paymentmode()
    {
        $errors = array();
        // Procesar los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
            $last_name_1 = isset($_POST['last_name_1']) ? $_POST['last_name_1'] : '';
            $last_name_2 = isset($_POST['last_name_2']) ? $_POST['last_name_2'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $state = isset($_POST['state']) ? $_POST['state'] : '';
            $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
            $country = isset($_POST['country']) ? $_POST['country'] : '';


            $dataForm = [
                'first_name' => $first_name,
                'last_name_1' => $last_name_1,
                'last_name_2' => $last_name_2,
                'email' => $email,
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'zipcode' => $zipcode,
                'country' => $country
            ];

            /*$object = new stdClass();
            foreach ($array as $key => $value)
            {
                $object->$key = $value;
            }*/

            if (empty($first_name)) {
                array_push($errors, 'El nombre del usuario es obligatorio');
            }
            if (empty($last_name_1)) {
                array_push($errors, 'El apellido1 del usuario es obligatorio');
            }
            if (empty($last_name_2)) {
                array_push($errors, 'El apellido2 del usuario es obligatorio');
            }
            if (empty($email)) {
                array_push($errors, 'El email del usuario es obligatorio');
            }
            if (empty($address)) {
                array_push($errors, 'La direccion del usuario es obligatorio');
            }
            if (empty($city)) {
                array_push($errors, 'La ciudad del usuario es obligatorio');
            }
            if (empty($state)) {
                array_push($errors, 'La region del usuario es obligatorio');
            }
            if (empty($zipcode)) {
                array_push($errors, 'El codigo postal del usuario es obligatorio');
            }
            if (empty($country)) {
                array_push($errors, 'El pais del usuario es obligatorio');
            }
        }

        $session = new Session();
        $user = $session->getUser();
        
        if (count($errors) == 0) {
            $data = [
                'titulo'    => 'Carrito | Validar datos',
                'subtitle'  => 'Usuario | Valide informacion de envio',
                'menu'      => true,
                'data'      => $user,
            ];
            //$this->view('carts/verificarDatos', $data);
            $this->model->guardarAddress($user);
            $this->view('carts/paymentmode', $data);
        }
        else {
            $data = [
                'titulo'    => 'Carrito - Datos de envío',
                'subtitle'  => 'Carrito - Verificar dirección de envío',
                'errors'   => $errors,
                'menu'      => true,
                'data'      => $user,
            ];
            $this->view('carts/address', $data);
        }
    }

    public function verify()
    {
        $session = new Session();
        $user = $session->getUser();
        $cart = $this->model->getCart($user->id);
        $payment = $_POST['payment'] ?? '';
        $data = [
            'titulo'    => 'Carrito | verificar los datos',
            'subtitle'    => 'Carrito | verificar los datos',
            'payment'   => $payment,
            'user'      => $user,
            'data'      => $cart,
            'menu'      => true,
        ];
        $this->view('carts/verify', $data);
    }

    public function thanks()
    {
        $session = new Session();
        $user = $session->getUser();
        if ($this->model->closeCart($user->id, 1)) {
            $data = [
                'titulo'    => 'Carrito | Gracias por su compra',
                'data'      => $user,
                'menu'      => true,
            ];
            $this->view('carts/thanks', $data);
        } else {
            $data = [
                'titulo'    => 'Error durante la actualización del carrito',
                'menu'      => false,
                'subtitle'  => 'Error en la actualización de los productos del carrito',
                'text'      => 'Existió un problema al actualizar el estado del carrito. Por favor pruebe más tarde o comuníquese con nuestro servicio de soporte',
                'color'     => 'alert-danger',
                'url'       => 'login',
                'colorButton' => 'btn-danger',
                'textButton' => 'Regresar',
            ];
            $this->view('mensaje', $data);
        }
    }

    public function sales()
    {
        $sales = $this->model->sales();
        $data = [
            'titulo'    => 'Ventas',
            'menu'      => false,
            'admin'     => true,
            'data'      => $sales,
        ];
        $this->view('admin/carts/index', $data);
    }

    public function show($date, $id)
    {
        $cart = $this->model->show($date, $id);
        $data = [
            'titulo'    => 'Detalle de ventas',
            'menu'      => false,
            'admin'     => true,
            'data'      => $cart,
        ];
        $this->view('admin/carts/show', $data);
    }

    public function chartDailySales()
    {
        $sales = $this->model->dailySales();
        $data = [
            'titulo'    => 'Ventas diarias',
            'menu'      => false,
            'admin'     => true,
            'data'      => $sales,
        ];
        $this->view('admin/carts/dailysales', $data);
    }
}
