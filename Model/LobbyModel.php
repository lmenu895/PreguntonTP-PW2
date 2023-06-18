<?php

class LobbyModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUserGenre($userName)
    {
        $query = "SELECT Genero FROM usuario WHERE nombre_usuario = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $stmt->close();
        return $row['Genero'];
    }

    public function getFiveUserGames($userName)
    {
        return $this->database->query("SELECT * FROM partida WHERE id_usuario =
                        (SELECT Id FROM usuario WHERE Nombre_usuario = '$userName') ORDER BY id DESC LIMIT 5");
    }
    public function getUserMaxScore($userName){
        return $this->database->query("SELECT puntaje_max FROM usuario WHERE Nombre_usuario = '$userName'");
    }

    public function getAllQuestions(){
        return $this->database->query("SELECT * FROM pregunta");
    }
}