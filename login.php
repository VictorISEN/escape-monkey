<?php
session_start();

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new POD('mysql:host=localhost;dbname=escape_monkey', 'root', '');

    $sql = "SELECT * FROM utilisateurs where email = '$email' ";
    $result = $db->prepare($sql);
    $result->execute();

    if($result->rowCount() >0){
        $data = $result->fetchAll();
        if (password_verify($pass, $data[0]["password"])){
            //faire bootscrap connexion effectuée
            $_SESSION['ID'] = $ID; //session lancé sous l'id du joueur

        }

    }
    else
    {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(email, password) VALUES ('$email', '$password')";
        $req = $db->prepare($sql);
        $req->excute();
    }
}

?>