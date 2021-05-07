<?php

class ShopController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Shop');
    }

    public function index()
    {
        $session = new Session();

        if ($session->getLogin()) {
            $mostSold = $this->model->getMostSold();
            $news = $this->model->getNews();
            
            $admin = $this->model->existsEmailAdmin($session->getUser()->email);
            
            $data = [
                'titulo'    => 'Bienvenid@ a nuestra tienda',
                'menu'      => true,
                'subtitle'  => 'Bienvenid@ a nuestra tienda',
                'subtitle2' => 'Artículos nuevos',
                'data'      => $mostSold,
                'news'      => $news,
                'admin'     => $admin
            ];
            $this->view('shop/index', $data);
        } else {
            header('location:' . ROOT);
        }
    }

    public function show($id, $back = '')
    {
        $session = new Session();
        $product = $this->model->getProductById($id);
        $data = [
            'titulo'    => 'Detalle del producto',
            'subtitle'  => $product->name,
            'menu'      => true,
            'admin'     => false,
            'back'      => $back,
            'errors'    => [],
            'data'      => $product,
            'user_id'   => $session->getUserId(),
        ];
        $this->view('shop/show', $data);
    }

    public function logout()
    {
        $session = new Session();
        $session->logout();
        header('location:'.ROOT);
    }

    public function whoami()
    {
        $session = new Session();
        if ($session->getLogin()) {
            $data = [
                'titulo'    => 'Quienes somos',
                'menu'      => true,
                'active'    => 'whoami',
            ];
            $this->view('shop/whoami', $data);
        } else {
            header('location:' . ROOT);
        }
    }

    public function contact()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';

            if ($name == '') {
                array_push($errors, 'El nombre es obligatorio');
            }
            if ($email == '') {
                array_push($errors, 'El email es obligatorio');
            } elseif ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, 'El correo electrónico no es válido');
            }
            if ($message == '') {
                array_push($errors, 'El mensaje es obligatorio');
            }

            if (count($errors) == 0) {
                if ($this->model->sendEmail($name, $email, $message)) {
                    $data = [
                        'titulo'    => 'Mensaje de Usuario',
                        'menu'      => true,
                        'errors'    => $errors,
                        'subtitle'  => 'Gracias por su mensaje',
                        'text'      => 'Gracias por su mensaje, en breve recibirá noticias nuestras',
                        'color'     => 'alert-success',
                        'url'       => 'shop',
                        'colorButton' => 'btn-success',
                        'textButton' => 'Regresar',
                    ];
                    $this->view('mensaje', $data);
                } else {
                    $data = [
                        'titulo'    => 'Mensaje de Usuario',
                        'menu'      => true,
                        'errors'    => $errors,
                        'subtitle'  => 'Error en el envío del correo electrónico',
                        'text'      => 'Existión un problema al enviar el correo electrónico. Por favor, pruebe más tarde o comuníquese con nuestro servicio de soporte.',
                        'color'     => 'alert-danger',
                        'url'       => 'shop',
                        'colorButton' => 'btn-danger',
                        'textButton' => 'Regresar',
                    ];
                    $this->view('mensaje', $data);
                }
            } else {
                $data = [
                    'titulo'    => 'Contacta con nosotros',
                    'menu'      => true,
                    'errors'    => $errors,
                    'active'    => 'contact',
                ];
                $this->view('shop/contact', $data);
            }
        } else {
            $session = new Session();

            if ($session->getLogin()) {
                $data = [
                    'titulo' => 'Contacta con nosotros',
                    'menu'   => true,
                    'active' => 'contact',
                ];
                $this->view('shop/contact', $data);
            } else {
                header('location:' . ROOT);
            }
        }
    }
}
