<?php
session_start();

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new PDO('mysql:host=localhost;dbname=escape_monkey', 'root', 'root');
    $sql = "SELECT * FROM utilisateurs where email = '$email' ";
    $result = $db->prepare($sql);
    $result->execute();

    if($result->rowCount() >0){
        $data = $result->fetchAll();
        if ($password == $data[0]['password']){
            //faire bootscrap connexion effectuée
            $_SESSION['email'] = $email; //session lancé sous l'id du joueur
            echo 'caca';
            header('Location: classement.php');
        }else{
            echo 'prout';
        }

    }
    else
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(email, password) VALUES ('$email', '$password')";
        $req = $db->prepare($sql);
        $req->excute();
    }
}

?>