<?php
session_start();
$_SESSION['pageAvantconn'] = $_SERVER['HTTP_REFERER'];
$servername = "localhost";
$username = "root";
$password = "root";
$database = "escape_monkey";

try {
    $db = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

$emailErr = $passwordErr = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $email)) {
            $emailErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    }
    }


function test_input($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data; // Ajoutez cette ligne pour renvoyer la valeur filtrée
}
?>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Connexion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" method="POST" action="login.php">
                        <div class="form-group">
                            <label for="loginEmail">Adresse Email</label>
                            <input type="email" name="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="Entrez votre email">
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Mot de Passe</label>
                            <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Mot de passe">
                        </div>
                        <button type="submit" value="submit" name="submit" class="btn btn-primary">Se connecter</button>
                        <span class="error">* <?php echo $passwordErr;?></span><br>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
