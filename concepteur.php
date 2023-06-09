<?php error_reporting(1); session_start(); ?>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "escape_monkey";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
  die("La connexion a échoué: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="site.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/17e733a281.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script>
        $.noConflict();
        // Your custom JavaScript code that uses jQuery can follow here
        </script>
        <title>Escape Monkey</title>

    <style>
        #gameContainer {
            font-size: 15px;
            white-space: pre;
            overflow: auto;
        }
        #score {
            text-align: center;
        }
        body{
           
        }
    </style>
</head>
<body>
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
    <div id="gameContainer" class="d-flex justify-content-center text-center">
        <div id="maze"></div>
    </div>
    
    <span id="mazeSizeText">Maze size:</span><input type="number" id="mazeSize" min="9" value="11" step="2" onclick="adjustStep(this)" onkeydown="adjustStep(this)">
    <button id="createMazeButton" onclick="createMaze()">Create Maze</button>
    <button id="saveMazeButton" onclick="saveMaze()">Save Maze</button>
    <h2 id="score">Score: 0</h2>
    <div id="mazeDiv">
        <table id="mazeTable" border="1">
        </table>
    </div>
    <script>
        var maze = [];
        var size;  // Size of the maze
        var teleporters = []; //Positions of teleporters
        var playerPos = {}; //Position of player
        var score = 0;
        var moveCount = 0;
        var isGameStarted = false;

        const WALL = "🍀";
        const PATH = "⬜";
        const DOOR = "🚪";
        const MONKEY = "🐒";
        const BANANA = "🍌";
        const TELEPORTER = "🔄";

        function adjustStep(input) {
            var value = parseInt(input.value);
            if(value % 2 === 0) {
                input.value = value + 1;
            }
        }

        function createMaze() {
            size = document.getElementById("mazeSize").value;
            maze = [];  // Reset the maze array
            teleporters = [];
            playerPos = {x:1, y:1};
            score = 0;
            moveCount = 0;
            for (let i = 0; i < size; i++) {
                maze[i] = new Array(parseInt(size));
                for (let j = 0; j < size; j++) {
                    if (i === 0 || j === 0 || i === size - 1 || j === size - 1) {
                        maze[i][j] = WALL;
                    } else {
                        maze[i][j] = PATH;
                    }
                }
            }
            maze[playerPos.y][playerPos.x] = MONKEY;
            maze[size-2][size-2] = DOOR;
            displayMaze();
        }

        function displayMaze() {
            var table = document.getElementById("mazeTable");
            table.innerHTML = '';
            for (let y = 0; y < size; y++) {
                var row = table.insertRow();
                for (let x = 0; x < size; x++) {
                    var cell = row.insertCell();
                    cell.innerHTML = maze[y][x];
                    cell.onclick = function() { 
                        switch(maze[y][x]) {
                            case PATH:
                                maze[y][x] = WALL;
                                break;
                            case WALL:
                                maze[y][x] = BANANA;
                                break;
                            case BANANA:
                                // Only add a teleporter if there are less than 2 already
                                if (teleporters.length < 2) {
                                    maze[y][x] = TELEPORTER;
                                    teleporters.push({x, y});
                                } else {
                                    maze[y][x] = PATH;
                                }
                                break;
                            case TELEPORTER:
                                teleporters = teleporters.filter(pos => !(pos.x === x && pos.y === y));
                                maze[y][x] = PATH;
                                break;
                            default:
                                maze[y][x] = PATH;
                                break;
                        }
                        displayMaze(); 
                    };
                    if(isGameStarted) {
                        cell.style.border = "none";
                    }
                }
            }
            document.getElementById('score').textContent = 'Score: ' + score;
        }

        function saveMaze() {
            if (teleporters.length == 1) {
                alert("You must place either 0 or 2 teleporters before you can start the game");
                return;
            }
            document.getElementById('mazeSize').style.display = 'none';
            document.getElementById('createMazeButton').style.display = 'none';
            document.getElementById('saveMazeButton').style.display = 'none';
            document.getElementById('mazeSizeText').style.display = 'none';
            isGameStarted = true;
            displayMaze();
            document.onkeydown = checkKey;
        }

        function checkKey(e) {
            e = e || window.event;
            let newPosX = playerPos.x;
            let newPosY = playerPos.y;
            if (e.keyCode == '38') {
                // up arrow
                newPosY--;
            } else if (e.keyCode == '40') {
                // down arrow
                newPosY++;
            } else if (e.keyCode == '37') {
               // left arrow
                newPosX--;
            } else if (e.keyCode == '39') {
               // right arrow
                newPosX++;
            }
            if (maze[newPosY][newPosX] === PATH || maze[newPosY][newPosX] === BANANA || maze[newPosY][newPosX] === TELEPORTER || maze[newPosY][newPosX] === DOOR) {
                if (maze[newPosY][newPosX] === BANANA) {
                    score += 10;
                }
                if (maze[newPosY][newPosX] === TELEPORTER) {
                    score += 25;
                    let otherTeleporter = teleporters.find(pos => !(pos.x === newPosX && pos.y === newPosY));
                    newPosX = otherTeleporter.x;
                    newPosY = otherTeleporter.y;
                    for(let teleporter of teleporters){
                        maze[teleporter.y][teleporter.x] = PATH;
                    }
                    teleporters = [];
                }
                if (maze[newPosY][newPosX] === DOOR) {
                    alert("Mission terminée");
                    location.reload(); // refresh the page
                }
                moveCount++;
                if (moveCount % 3 === 0) {
                    score--;
                }
                maze[playerPos.y][playerPos.x] = PATH;
                playerPos.x = newPosX;
                playerPos.y = newPosY;
                maze[playerPos.y][playerPos.x] = MONKEY;
                displayMaze();
            }
        }

        createMaze();
    </script>
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
                © 2023 Tous droits réservés. Conçu par Team Sinj
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>