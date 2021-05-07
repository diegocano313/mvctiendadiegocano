<?php

class Login
{
    private $db;

    public function __construct()
    {
        $this->db = MySQLdb::getInstance()->getDatabase();
    }

    public function existsEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount();
    }

    
    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function sendEmail($email)
    {
        $user = $this->getUserByEmail($email);
        $fullName = $user->first_name . ' ' . $user->last_name_1 . ' ' . $user->last_name_2;
        $msg = $fullName . ', accede al siguiente enlace para cambiar tu contraseña. <br>';
        $msg .= '<a href="' . ROOT . 'login/changePassword/' . $user->id . '">Cambia tu clave de acceso</a>';
        $headers = 'MIME-Version: 1.0\r\n';
        $headers .= 'Content-type:text/html; charset=UTF-8\r\n';
        $headers .= 'From: MVCTienda\r\n';
        $headers .= 'Reply-to: administracion@mvctienda.local';

        $subject = 'Cambiar contraseña en MVCTienda';
        return mail($email, $subject, $msg, $headers);
    }

    public function createUser($data)
    {
        $response = false;
        if ( ! $this->existsEmail($data['email'])) {
            // Como el email no existe, se crea el registro
            $password = hash_hmac('sha512', $data['password'], ENCRIPTKEY);

            $sql = 'INSERT INTO users (first_name, last_name_1, last_name_2, email, address, city, state, zipcode, country, password)
                    VALUES (:first_name, :last_name_1, :last_name_2, :email, :address, :city, :state, :zipcode, :country, :password)';
            $query = $this->db->prepare($sql);
            $params = [
                ':first_name' => $data['first_name'],
                ':last_name_1' => $data['last_name_1'],
                ':last_name_2' => $data['last_name_2'],
                ':email' => $data['email'],
                ':address' => $data['address'],
                ':city' => $data['city'],
                ':state' => $data['state'],
                ':zipcode' => $data['zipcode'],
                ':country' => $data['country'],
                ':password' => $password,
            ];
            $response = $query->execute($params);
        }

        return $response;
    }

    public function changePassword($id, $password)
    {
        $pass = hash_hmac('sha512', $password, ENCRIPTKEY);
        $sql = 'UPDATE users SET password=:password WHERE id=:id';
        $params = [
            ':password' => $pass,
            ':id'       => $id
        ];
        $query = $this->db->prepare($sql);
         return $query->execute($params);
    }

    public function verifyUser($user, $password)
    {
        $errors = [];
         $user = $this->getUserByEmail($user);
         $pass = hash_hmac('sha512', $password, ENCRIPTKEY);

         if ( ! $user) {
             array_push($errors, 'El usuario no existe en nuestros registros');
         } elseif ($user->password != $pass) {
             array_push($errors, 'La contraseña no es correcta');
         }

         return $errors;

    }
}
