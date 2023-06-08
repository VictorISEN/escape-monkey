<?php
// Check if the score is received through POST
if (isset($_POST['score'])) {
    $score = $_POST['score'];

    // Perform any necessary validations on the score value

    // Update the score in the database
    if (isset($_COOKIE['ID'])) {
        $playerID = $_COOKIE['ID'];

        // Create a new database connection
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "escape_monkey";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the database connection
        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }

        // Update the score for the player with the given ID
        $updateScoreSQL = "UPDATE utilisateurs SET Score = $score WHERE ID = $playerID";

        if ($conn->query($updateScoreSQL) === TRUE) {
            echo "Score updated successfully";
        } else {
            echo "Error updating score: " . $conn->error;
        }

        // Récupérer le meilleur score actuel pour le joueur
        $selectHighScoreSQL = "SELECT High_Score FROM utilisateurs WHERE ID = $playerID";
        $result = $conn->query($selectHighScoreSQL);
        if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentHighScore = $row["High_Score"];
        
        // Comparer le score actuel avec le meilleur score
        if ($score > $currentHighScore) {
            // Mettre à jour le meilleur score dans la base de données
            $updateHighScoreSQL = "UPDATE utilisateurs SET High_Score = $score WHERE ID = $playerID";
            if ($conn->query($updateHighScoreSQL) === TRUE) {
                echo "High score updated successfully";
            } else {
                echo "Error updating high score: " . $conn->error;
            }
        }
    }


        // Close the database connection
        $conn->close();
    } else {
        echo "Player ID not found";
    }
} else {
    echo "Score not received";
}
?>
