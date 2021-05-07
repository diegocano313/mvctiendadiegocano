<?php

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = MySQLdb::getInstance()->getDatabase();
    }

    public function verifyUser($data)
    {
        $errors = [];
        $password = hash_hmac('sha512', $data['password'], ENCRIPTKEY);
        $sql = 'SELECT * FROM admins WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $data['user'], PDO::PARAM_STR);
        $query->execute();
        $admins = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($admins) == 0) {
            array_push($errors, 'El usuario no existe');
        } elseif (count($admins) > 1) {
            array_push($errors, 'El correo electrónico está duplicado');
        } elseif ($password != $admins[0]->password) {
            array_push($errors, 'La clave introducida no es correcta');
        } elseif ($admins[0]->status == 0) {
            array_push($errors, 'El usuario está desactivado');
        } elseif ($admins[0]->deleted == 1) {
            array_push($errors, 'El usuario está dado de baja');
        } else {
            $sql2 = 'UPDATE admins SET login_at=:login WHERE id=:id';
            $query2 = $this->db->prepare($sql2);
            $params = [
                'login' => date('Y-m-d H:i:s'),
                'id'    => $admins[0]->id,
            ];
            if (!$query2->execute($params)) {
                array_push($errors, 'Error al modificar la fecha del último acceso');
            }
        }
        return $errors;
    }
}
