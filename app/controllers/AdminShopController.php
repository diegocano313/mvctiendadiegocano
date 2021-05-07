<?php

class AdminShopController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminShop');
    }

    public function index()
    {
        $session = new Session();

        if ($session->getLogin()) {
            $data = [
                'titulo'    => 'Bienvenid@ a la adminstración de nuestra tienda',
                'menu'      => false,
                'admin'     => true,
                'subtitle'  => 'Administración de la tienda',
            ];
            $this->view('admin/shop/index', $data);
        } else {
            header('location:' . ROOT . 'admin');
        }


    }
}
