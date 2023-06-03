<?php 

session_start();
if(isset($_POST["envoyer"])){
		try{
			$servername ='localhost'; 
	        $username ='root';
	        $password ='root'; 
	        $database ='escape_monkey';
	
	        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);             
			
			$pseudo = $_POST['pseudo']; //on recupere chaque données du formulaire
            $password = $_POST['password'];
            $email = $_POST['email'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];

            
            $reqajouter = "INSERT INTO utilisateurs (Pseudo, email, Password, nom, prenom) VALUES ('$pseudo','$email', '$password','$nom','$prenom')";
			// on crée le profil dans la BD adherent
            if ($conn->query($reqajouter) === TRUE) {
                echo "Ajout termine";
            } 
			$conn= NULL;
		}                 
		catch(Exception $e){
			die("Erreur : " . $e->getMessage());
        }
	}

?>