<?php

class LoginController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Login');
    }

    public function index()
    {
        if (isset($_COOKIE['mvctienda'])) {

            $value = explode('//', $_COOKIE['mvctienda']);
            $dataForm = [
                'user'  => $value[0],
                'password' => $value[1],
                'remember' => 'on'
            ];
        } else {
            $dataForm = null;
        }

        $data = [
            'titulo' => 'Login',
            'menu'   => false,
            'data'   => $dataForm,
        ];
        $this->view('login', $data);
    }

    public function olvido()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $data = [
                'titulo'    => 'Olvido de la contraseña',
                'menu'      => false,
                'errors'    => [],
                'subtitle'  => '¿Olvidaste tu contraseña?'
            ];
            $this->view('olvido', $data);
        } else {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            if ($email == '') {
                array_push($errors, 'El correo electrónico es obligatorio');
            }
            if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, 'El correo electrónico no es válido');
            }
            if (count($errors) == 0) {
                if ( ! $this->model->existsEmail($email)) {
                    array_push($errors, 'El correo electrónico no existe en la base de datos');
                } else {
                    if ($this->model->sendEmail($email)) {
                        $data = [
                            'titulo'    => 'Cambio de la contraseña de acceso',
                            'menu'      => false,
                            'errors'    => [],
                            'subtitle'  => 'Cambio de contraseña',
                            'text'      => 'Se ha enviado un correo a <b>' . $email .
                                '</b> para que pueda cambiar su clave de acceso. No olvide revisar su 
                                carpeta de spam. Cualquier duda que tenga puede comunicarse con nosotros',
                            'color'     => 'alert-success',
                            'url'       => 'login',
                            'colorButton' => 'btn-success',
                            'textButton'  => 'Regresar',
                        ];
                        $this->view('mensaje', $data);
                    } else {
                        $data = [
                            'titulo'    => 'Error en el envío del correo electrónico',
                            'menu'      => false,
                            'errors'    => [],
                            'subtitle'  => 'Error en el envío del correo electrónico',
                            'text'      => 'Existió un problema al enviar el correo electrónico. Por favor
                                pruebe más tarde o comuníquese con nuestro servicio de soporte',
                            'color'     => 'alert-danger',
                            'url'       => 'login',
                            'colorButton' => 'btn-danger',
                            'textButton'  => 'Regresar',
                        ];
                        $this->view('mensaje', $data);
                    }
                }
            }
            if (count($errors) > 0) {
                $data = [
                    'titulo'    => 'Olvido de la contraseña',
                    'menu'      => false,
                    'errors'    => $errors,
                    'subtitle'  => '¿Olvidaste tu contraseña?',
                ];
                $this->view('olvido', $data);
            }
        }
    }

    public function registro()
    {
        $errors = [];
        $dataForm = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
            $last_name_1 = isset($_POST['last_name_1']) ? $_POST['last_name_1'] : '';
            $last_name_2 = isset($_POST['last_name_2']) ? $_POST['last_name_2'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
            $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $state = isset($_POST['state']) ? $_POST['state'] : '';
            $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
            $country = isset($_POST['country']) ? $_POST['country'] : '';

            $dataForm = [
                'first_name'    => $first_name,
                'last_name_1'   => $last_name_1,
                'last_name_2'   => $last_name_2,
                'email'         => $email,
                'password'      => $password1,
                'address'       => $address,
                'city'          => $city,
                'state'         => $state,
                'zipcode'      => $zipcode,
                'country'       => $country
            ];

            if ($first_name == '') {
                array_push($errors, 'El nombre es requerido');
            }
            if ($last_name_1 == '') {
                array_push($errors, 'El primer apellido es requerido');
            }
            if ($email == '') {
                array_push($errors, 'El email es requerido');
            }
            if ($password1 = '') {
                array_push($errors, 'La contraseña es requerida');
            }
            if ($password2 = '') {
                array_push($errors, 'Repetir la contraseña es requerida');
            }
            if ($address == '') {
                array_push($errors, 'La dirección es requerida');
            }
            if ($city == '') {
                array_push($errors, 'La ciudad es requerida');
            }
            if ($state == '') {
                array_push($errors, 'La provincia es requerida');
            }
            if ($zipcode == '') {
                array_push($errors, 'El código postal es requerido');
            }
            if ($country == '') {
                array_push($errors, 'El país es requerido');
            }
            if ($password1 != $password2) {
                array_push($errors, 'Ambas claves deben ser iguales');
            }
            if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, 'El correo electrónico no es válido');
            }
            if (count($errors) == 0) {
                if ($this->model->createUser($dataForm)) {
                    $data = [
                        'titulo' => 'Bienvenido a la tienda virtual',
                        'menu'   => false,
                        'errors' => [],
                        'subtitle' => 'Bienvenido/a a nuestra tienda virtual',
                        'text'    => 'Gracias por registrarse con nosotros',
                        'color'   => 'alert-success',
                        'url'     => 'menu',
                        'colorButton' => 'btn-success',
                        'textButton' => 'Iniciar'
                    ];
                    $this->view('mensaje', $data);
                } else {
                    $data = [
                        'titulo' => 'Bienvenido a la tienda virtual',
                        'menu'   => false,
                        'errors' => [],
                        'subtitle' => 'Error en el registro',
                        'text'    => 'Existió un error en registro. Posiblemente ya existe ese correo electrónico en nuestra base de datos. Verifíquelo',
                        'color'   => 'alert-danger',
                        'url'     => 'login',
                        'colorButton' => 'btn-danger',
                        'textButton' => 'Regresar'
                    ];
                    $this->view('mensaje', $data);
                }
            } else {
                $data = [
                    'titulo' => 'Registro',
                    'menu'   => false,
                    'errors' => $errors,
                    'dataForm' => $dataForm
                ];
                $this->view('register', $data);
            }

        } else {
            $data = [
                'titulo' => 'Registro',
                'menu'   => false
            ];
            $this->view('register', $data);
        }
    }

    public function changePassword($id)
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
            $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

            if ($id == '') {
                array_push($errors, 'El usuario no existe');
            }
            if ($password1 = '') {
                array_push($errors, 'La contraseña es requerida');
            }
            if ($password2 = '') {
                array_push($errors, 'Repetir la contraseña es requerida');
            }
            if ($password1 != $password2) {
                array_push($errors, 'Ambas claves deben ser iguales');
            }

            if (count($errors)) {
                $data = [
                    'titulo'    => 'Cambia tu contraseña de acceso',
                    'menu'      => false,
                    'errors'    => $errors,
                    'data'      => $id,
                    'subtitle'  => 'Cambia tu contraseña de acceso'
                ];
                $this->view('changepassword', $data);
            } else {
                if ($this->model->changePassword($id, $password1)) {
                    $data = [
                        'titulo' => 'Modificar la clave de acceso',
                        'menu'   => false,
                        'errors' => [],
                        'subtitle' => 'Modificación de contraseña',
                        'text'    => 'La contraseña ha sido cambiada correctamente. Bienvenido de nuevo',
                        'color'   => 'alert-success',
                        'url'     => 'login',
                        'colorButton' => 'btn-success',
                        'textButton' => 'Regresar'
                    ];
                    $this->view('mensaje', $data);
                } else {
                    $data = [
                        'titulo' => 'Error al modificar la contraseña',
                        'menu'   => false,
                        'errors' => [],
                        'subtitle' => 'Error al modificar la contraseña',
                        'text'    => 'Existió un error al modificar la contraseña. Repítalo de nuevo más tarde',
                        'color'   => 'alert-danger',
                        'url'     => 'login',
                        'colorButton' => 'btn-danger',
                        'textButton' => 'Regresar'
                    ];
                    $this->view('mensaje', $data);
                }
            }
        } else {
            $data = [
                'titulo'    => 'Cambia tu contraseña de acceso',
                'menu'      => false,
                'data'      => $id,
                'subtitle'  => 'Cambia tu contraseña de acceso'
            ];
            $this->view('changepassword', $data);
        }
    }

    public function verifyUser()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = isset($_POST['user']) ? $_POST['user'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $remember = isset($_POST['remember']) ? 'on' : 'off';

            $errors = $this->model->verifyUser($user, $password);

            $value = $user . '//' . $password;
            if ($remember == 'on') {
                $date = time() + (60 * 60 * 24 * 7);
            } else {
                $date = time() - 1;
            }
            setcookie('mvctienda', $value, $date);

            $dataForm = [
                'user'  => $user,
                'remember' => $remember
            ];

            if ( ! $errors) {
                $data = $this->model->getUserByEmail($user);
                $session = new Session();
                $session->login($data);
                header("location:" . ROOT . 'shop');
            } else {
                $data = [
                    'titulo'    => 'Login',
                    'menu'      => false,
                    'errors'    => $errors,
                    'data'      => $dataForm
                ];
                $this->view('login', $data);
            }

        } else {
            $this->index();
        }
    }
}
