<?php

class SearchController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Search');
    }

    public function products()
    {
        $search = $_POST['search'] ?? '';
        if ($search != '') {
            $products = $this->model->getProducts($search);
            if (count($products) > 0) {
                $data = [
                    'titulo'    => 'Buscador de productos',
                    'subtitle'  => 'Resultado de la búsqueda',
                    'data'      => $products,
                    'menu'      => true,
                ];
                $this->view('search/search', $data);
            } else {
                $data = [
                    'titulo'    => 'No hay productos',
                    'menu'      => true,
                    'subtitle'  => 'No hay productos',
                    'text'      => 'La búsqueda no ha arrojado ningún resultado',
                    'color'     => 'alert-danger',
                    'url'       => 'shop',
                    'colorButton' => 'btn-danger',
                    'textButton'=> 'Regresar',
                ];
                $this->view('mensaje', $data);
            }
        } else {
            header('location:' . ROOT . 'shop');
        }
    }
}
