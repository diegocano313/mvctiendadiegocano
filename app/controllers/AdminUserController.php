<?php

class AdminUserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminUser');
    }

    public function index()
    {
        $session = new Session();
        $users = $this->model->getUsers();

        if ($session->getLogin()) {
            $data = [
                'titulo'    => 'Administración de usuarios',
                'menu'      => false,
                'admin'     => true,
                'data'      => $users,
            ];

            $this->view('admin/users/index', $data);
        } else {
            header('location:' . ROOT . 'admin');
        }

    }

    public function store($dataForm, $errors){
         if (count($errors) == 0) {
            if ($this->model->createAdminUser($dataForm)) {
                header('location:' . ROOT . 'adminuser');
            } else {
                $data = [
                    'titulo'    => 'Error en la creación del usuario administrador',
                    'menu'      => false,
                    'errors'    => [],
                    'subtitle' => 'Error al crear un nuevo usuario administrador',
                    'text' => 'Existió un error al crear un nuevo usuario administrador.',
                    'color' => 'alert-danger',
                    'url' => 'adminuser',
                    'colorButton' => 'btn-danger',
                    'textButton' => 'Volver'
                ];
                $this->view('mensaje', $data);
            }
        } else {
            $data = [
                'titulo'    => 'Administración de usuarios - Alta',
                'menu'      => false,
                'admin'     => true,
                'errors'    => $errors,
                'data'  => $dataForm,
            ];

            $this->view('admin/users/create', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
            $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

            $dataForm = [
                'name' => $name,
                'email' => $email,
                'password' => $password1,
            ];

            if (empty($name)) {
                array_push($errors, 'El nombre del usuario es obligatorio');
            }
            if (empty($email)) {
                array_push($errors, 'El correo electrónico del usuario es obligatorio');
            }
            if (empty($password1)) {
                array_push($errors, 'La contraseña es obligatoria');
            }
            if (empty($password2)) {
                array_push($errors, 'La verificación de la contraseña es obligatoria');
            }
            if ($password1 != $password2) {
                array_push($errors, 'Las contraseñas no coinciden');
            }

            $this->store($dataForm, $errors);

            /*
            if (count($errors) == 0) {
                if ($this->model->createAdminUser($dataForm)) {
                    header('location:' . ROOT . 'adminuser');
                } else {
                    $data = [
                        'titulo'    => 'Error en la creación del usuario administrador',
                        'menu'      => false,
                        'errors'    => [],
                        'subtitle' => 'Error al crear un nuevo usuario administrador',
                        'text' => 'Existió un error al crear un nuevo usuario administrador.',
                        'color' => 'alert-danger',
                        'url' => 'adminuser',
                        'colorButton' => 'btn-danger',
                        'textButton' => 'Volver'
                    ];
                    $this->view('mensaje', $data);
                }
            } else {
                $data = [
                    'titulo'    => 'Administración de usuarios - Alta',
                    'menu'      => false,
                    'admin'     => true,
                    'errors'    => $errors,
                    'data'  => $dataForm,
                ];

                $this->view('admin/users/create', $data);
            }*/

        } else {
            $data = [
                'titulo'    => 'Administración de usuarios - Alta',
                'menu'      => false,
                'admin'     => true,
                'data'      => [],
            ];

            $this->view('admin/users/create', $data);
        }
    }

    public function edit($id){
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
            $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';

            if (empty($name)) {
                array_push($errors, 'El nombre del usuario es obligatorio');
            }
            if (empty($email)) {
                array_push($errors, 'El correo electrónico del usuario es obligatorio');
            }
            if($status == '') {
                array_push($errors, 'Selecciona el estado del usuario');
            }
            if ( ! empty($password1) || ! empty($password2)) {
                if ($password1 != $password2) {
                    array_push($errors, 'Las contraseñas no coinciden');
                }
            }

            if (empty($errors)) {
                $this->update($errors, $id, $name, $email, $password1, $status);
            }
        }
        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');
        $data = [
            'titulo'    => 'Administración de usuarios - Actualización',
            'menu'      => false,
            'admin'     => true,
            'status'    => $status,
            'user'      => $user,
            'errors'    => $errors
        ];
        $this->view('admin/users/update', $data);
    }

    public function update($errors, $id, $name, $email, $password, $status)
    {                
        $data = [
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
            'password' => $password,
            'status'=> $status,
        ];
        $errors = $this->model->setUser($data);
        if (empty($errors)) {
            header('location:' . ROOT . 'adminUser');
        }
    }

    public function destroy($id){
        $errors = $this->model->delete($id);
        if(empty($errors)) {
            header('location:'.ROOT.'adminUser');
        }
    }

    public function delete($id)
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->destroy($id);
        }
        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');
        $data = [
            'titulo'    => 'Administración de usuarios - Eliminación',
            'menu'      => false,
            'admin'     => true,
            'status'    => $status,
            'user'      => $user,
            'errors'    => $errors
        ];
        $this->view('admin/users/delete', $data);
    }
}
