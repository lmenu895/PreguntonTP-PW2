<?php

class UserService
{
    private $database;
    private $model;

    public function __construct($database, $model)
    {
        $this->database = $database;
        $this->model=$model;
    }

    public function getPhoto($username){
        return $this->model->getUserPhoto($username);
    }
    public function getUserLevelByName($userName)
    {
        return $this->database->query("SELECT nivel FROM usuario WHERE Nombre_usuario = '$userName'");
    }

    public function updateLevelUserById($idUsuario)
    {
        $this->database->update("UPDATE usuario
                                 SET nivel = (cant_acertadas / cant_respondidas) * 100
                                 WHERE id = $idUsuario;");
    }
    public function updateCorrectAnswer($idUsuario)
    {
        $this->database->update("UPDATE usuario
                                 SET cant_acertadas = cant_acertadas + 1
                                 WHERE id = $idUsuario;");
    }
    public function updateUserMaxScore($idUser)
    {
        $puntajeMax = $this->getUserMaxScore($idUser);
        $puntos = $puntajeMax[0][0];
        return $this->database->update("UPDATE usuario SET puntaje_max = '$puntos' WHERE id = $idUser");
    }

    public function getUserGamesByName($username)
    {
        return $this->database->query("SELECT * FROM partida WHERE id_usuario =
                        (SELECT Id FROM usuario WHERE Nombre_usuario = '$username') ORDER BY id DESC LIMIT 50");
    }

    public function getUserMaxScore($idUser)
    {
        return $this->database->query("SELECT MAX(puntaje) FROM partida WHERE id_usuario=$idUser");
    }

}