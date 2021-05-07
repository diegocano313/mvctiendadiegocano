<?php

class AdminController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Admin');
    }

    public function index()
    {
        $data = [
            'titulo'    => 'Administración',
            'menu'      => false,
            'data'      => [],
        ];

        $this->view('admin/index', $data);
    }

    public function verifyUser()
    {
        $errors = [];
        $dataForm = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = isset($_POST['user']) ? $_POST['user'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $dataForm = [
                'user'  => $user,
                'password' => $password
            ];
            if (empty($user)) {
                array_push($errors, 'El usuario es obligatorio');
            }
            if (empty($password)) {
                array_push($errors, 'La contraseña es obligatoria');
            }
            if (count($errors) == 0) {
                $errors = $this->model->verifyUser($dataForm);
                if (empty($errors)) {
                    $session = new Session();
                    $session->login($dataForm);
                    header('location:' . ROOT . 'adminShop');
                }
            }
        }
        $data = [
            'titulo'    => 'Administración Inicio',
            'menu'      => false,
            'admin'     => true,
            'errors'    => $errors,
            'data'      => $dataForm,
        ];
        $this->view('admin/index', $data);
    }

    public function logout()
    {
        $session = new Session();
        $session->logout();
        header('location:'.ROOT);
    }
}