<?php error_reporting(1); session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/17e733a281.js" crossorigin="anonymous"></script>
    <title>Classement | Escape Monkey</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="site.php">Escape Monkey</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="site.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a propos.php">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="classement.php">Classement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="regles.php">Règles du jeu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="FAQ.php">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contactez-nous</a>
                </li>
            </ul>
            <ul class="navbar-nav">
            <?php
            if(isset($_COOKIE['email'])){ 
                
                echo '<li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#decoModal">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-openvpn" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M15.618 20.243l-2.193 -5.602a3 3 0 1 0 -2.849 0l-2.193 5.603"></path>
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                </svg>  ';
                echo $_COOKIE['pseudo'];
                echo '</a>';
                echo '</li>';
                
            } else {
                echo '<li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#signupModal">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Connexion</a>
            </li>';
        
        

            }
            ?>
                
            </ul>
        </div>
    </nav>

    
    
    <?php 
    require 'inscription.php';

    require 'connexion.php';
    ?>
     <div class="modal fade" id="decoModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form class="form" method="POST" action="deconnexion.php">
                        <div class="form-group">
                            <label for="loginEmail">Name: <?php echo $_COOKIE['nom']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="loginEmail">Surname : <?php echo $_COOKIE['prenom']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Email : <?php echo $_COOKIE['email']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Highscore : <?php echo $_COOKIE['High_Score'];?></label>
                        </div>
                        <button type="submit" value="submit" name="submit" class="btn btn-primary">Deconnexion</button>
                        <span class="error">* <?php echo $passwordErr;?></span><br>
                </div>
            </div>
        </div>
    </div>

    <?php 
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "escape_monkey";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    ?>
        
        <!-- Identique à la barre de navigation de la page principale -->
    <section class="container my-5">
        <div class="row">
            <div class="col-lg-12" style="height: 300px;">
                <h1 class="display-4">Ranking Escape Monkey</h1>
                <p class="lead">Check out the best Escape Monkey players !</p>
                <hr class="my-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Player name</th>
                            <th scope="col">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Insérez ici les rangs des joueurs sous la forme d'éléments de liste -->
                        <!-- Exemple: -->
                        <?php 
                        $sql = "SELECT pseudo, High_Score FROM utilisateurs ORDER BY High_Score DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            $rank = 1;
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $rank++ . "</th>";
                                echo "<td>" . $row["pseudo"]. "</td>";
                                echo "<td>" . $row["High_Score"]. "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "0 results";
                        }
                        $conn->close();
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-warning text-center text-white">
        <div class="container p-4">
            <section class="mb-4">
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
            </section>
            <section class="mb-4">
                <p>Escape Monkey est un jeu de labyrinthe passionnant qui vous emmène dans une aventure à travers le désert. Rejoignez-nous et aidez notre singe à s'échapper!</p>
            </section>
            <section class="mb-4">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Contactez-nous</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#!" class="text-white">Adresse</a></li>
                        <li><a href="#!" class="text-white">Téléphone</a></li>
                        <li><a href="#!" class="text-white">Email</a></li>
                    </ul>
                </div>
            </section>
            <hr class="my-4">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2023 Tous droits réservés. Conçu par  TeamSinj
            </div>
        </div>
    </footer>

    <!-- Identique au footer de la page principale -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
