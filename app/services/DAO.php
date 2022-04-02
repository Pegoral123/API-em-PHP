<?php

class DAO
{
    private $pdo;    

    function conecta(){
        try{
            //new PDO('mysql:host=localhost;port=8888;dbname=test', $user, $pass);
            $pdo = new PDO(DRIVE .":host=".HOST.";port=".PORT.";dbname=".DB , USER, PASS);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e)
        {
            echo("<b>Erro PDO:</b> ". $e->getMessage() ."</br>");
            $pdo = null;
        }
        return $pdo;
    }
}
 