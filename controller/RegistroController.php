<?php

class RegistroController
{
    private $registroModel;
    private $renderer;

    public function __construct($model, $renderer)
    {
        $this->registroModel = $model;
        $this->renderer = $renderer;
    }

    public function home()
    {
        $data = [];
        $this->renderer->render("registro", $data);
    }
    public function newAccount()
    {
        $nameComplete = $_POST["nombre"];
        $birth = $_POST["fecha_nacimiento"];
        $sex = $_POST["sexo"];
        $country = $_POST["pais"];
        $city = $_POST["ciudad"];
        $mail = $_POST["correo"];
        $nameUser = $_POST["nombre_usuario"];
        $photo = basename($_FILES['foto_perfil']['name']);
        $pass = $_POST["contrasenia"];
        $passValidate = $_POST["confirmar_contrasenia"];
        $data = [];

        $this->createAccount($pass, $passValidate, $nameComplete, $birth, $sex, $country, $city, $mail, $nameUser, $photo, $data);
    }

    private function createAccount($pass, $passValidate, $nameComplete, $birth, $sex, $country, $city, $mail, $nameUser, $photo, $data)
    {
        if ($this->validatePassword($pass, $passValidate)) {
            if ($this->registroModel->saveUser($nameComplete, $birth, $sex, $country, $city, $mail, $nameUser, $photo, $pass, $passValidate)) {
                $this->renderer->render("registroExitoso", $data);
            } else {
                $data["message"] = "El usuario ya existe";
                $this->renderer->render("registro", $data);
            }
        } else {
            $data["message"] = "Las contraseñas no coinciden";
            $this->renderer->render("registro", $data);
        }
    }

    private function validatePassword($pass, $passValidate)
    {
        return $pass === $passValidate;
    }
}