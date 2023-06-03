<?php error_reporting(0); session_start(); ?>
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
        <a class="navbar-brand" href="site.html">Escape Monkey</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="site.html">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a propos.html">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="classement.html">Classement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="regles.html">Règles du jeu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="FAQ.html">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contactez-nous</a>
                </li>
            </ul>
            <ul class="navbar-nav">
            <?php   
            if(isset($_SESSION['email'])){
                echo 'oe ma gueule';
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
                        <tr>
                            <th scope="row">1</th>
                            <td>Player 1</td>
                            <td>1234</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Player 2</td>
                            <td>1176</td>
                        </tr>
                        <!-- Continuez à ajouter des rangs de joueurs ici -->
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
