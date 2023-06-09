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
            overflow: hidden;
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
                    <a class="nav-link" href="site.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a propos.php">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="classement.php">Ranking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="regles.php">Rules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="FAQ.php">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact us</a>
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
                <a class="nav-link" href="#" data-toggle="modal" data-target="#signupModal">Sign up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Log in</a>
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
    
    <div id="score" class="text-dark">Score: 0 | Niveau: 1</div>
    <script>
        const WALL = "🍀";
        const PATH = "⬜";
        const DOOR = "🚪";
        const MONKEY = "🐒";
        const BANANA = "🍌";
        const TELEPORTER = "🕳️";

        let monkeyPosition = {x: 1, y: 1};
        let teleporterPositions = [{x: 0, y: 0}, {x: 0, y: 0}];
        let score = 0;
        let moveCounter = 0;
        let teleportersUsed = false;
        let mazeSizes = [9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29];
        let currentMazeIndex = 0;

        function createEmptyMaze(width, height) {
            let maze = Array(height).fill().map(() => Array(width).fill(WALL));
            return maze;
        }

        function isValidCell(maze, x, y) {
            return (x >= 0 && y >= 0 && x < maze[0].length && y < maze.length);
        }

        function isVisited(maze, x, y) {
            return maze[y][x] === PATH;
        }

        function generateMaze(maze, x, y) {
            const directions = [[0, -2], [2, 0], [0, 2], [-2, 0]];
            maze[y][x] = PATH;

            for (let i = directions.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [directions[i], directions[j]] = [directions[j], directions[i]];
            }

            for (let [dx, dy] of directions) {
                const nx = x + dx, ny = y + dy;
                if (isValidCell(maze, nx, ny) && !isVisited(maze, nx, ny)) {
                    maze[y + dy / 2][x + dx / 2] = PATH;
                    generateMaze(maze, nx, ny);
                }
            }
        }

        function placeBananas(maze, width, height) {
            for (let i = 0; i < Math.floor(Math.random() * (width * height) / 10); i++) {
                let bananaX, bananaY;
                do {
                    bananaX = Math.floor(Math.random() * width);
                    bananaY = Math.floor(Math.random() * height);
                } while (maze[bananaY][bananaX] !== PATH);
                maze[bananaY][bananaX] = BANANA;
            }
        }

        function placeTeleporters(maze, width, height) {
            teleportersUsed = false;
            for(let i = 0; i < 2; i++) {
                let teleporterX, teleporterY;
                do {
                    teleporterX = Math.floor(Math.random() * width);
                    teleporterY = Math.floor(Math.random() * height);
                } while (maze[teleporterY][teleporterX] !== PATH);
                maze[teleporterY][teleporterX] = TELEPORTER;
                teleporterPositions[i] = {x: teleporterX, y: teleporterY};
            }
        }

        function displayMaze(maze, x, y) {
            maze[y][x] = DOOR;
            maze[monkeyPosition.y][monkeyPosition.x] = MONKEY;
            document.getElementById("maze").textContent = maze.map(row => row.join('')).join('\n');
        }

        function moveMonkey(direction) {
            const dx = (direction === 'left' ? -1 : (direction === 'right' ? 1 : 0));
            const dy = (direction === 'up' ? -1 : (direction === 'down' ? 1 : 0));
            let newX = monkeyPosition.x + dx;
            let newY = monkeyPosition.y + dy;

            if (!isValidCell(maze, newX, newY)) {
                return;
            }

            if (maze[newY][newX] === TELEPORTER) {
                score += 25;
                teleportersUsed = true;

                const otherTeleporter = teleporterPositions.find((pos) => pos.x !== newX || pos.y !== newY);

                newX = otherTeleporter.x;
                newY = otherTeleporter.y;

                for (let teleporter of teleporterPositions) {
                    maze[teleporter.y][teleporter.x] = PATH;
                }
                teleporterPositions = [];
            } else if(maze[newY][newX] === DOOR){
                currentMazeIndex += 1;
                if(currentMazeIndex >= mazeSizes.length){
                    alert("Mission terminée");
                    window.location.href = "site.html";
                    return;
                } else {
                    alert("Labyrinthe réussi");
                    initMaze();
                    return;
                }
            } else if (maze[newY][newX] === WALL) {
                return;
            } else if (maze[newY][newX] === BANANA) {
                score += 10;
            }
            
            moveCounter += 1;
            if(moveCounter >= 3){
                score -= 1;
                moveCounter = 0;
            }
            
            


            document.getElementById("score").textContent = "Score: " + score + " | Niveau: " + (currentMazeIndex + 1);
            maze[monkeyPosition.y][monkeyPosition.x] = PATH;
            monkeyPosition.x = newX;
            monkeyPosition.y = newY;
            displayMaze(maze, mazeSizes[currentMazeIndex] - 2, mazeSizes[currentMazeIndex] - 2);
            const updateScore = async (score) => {
                try {
                    const response = await fetch('update_score.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `score=${score}`,
                    });

                    if (response.ok) {
                    console.log('Score updated successfully');
                    } else {
                    console.error('Error updating score:', response.statusText);
                    }
                } catch (error) {
                    console.error('Error updating score:', error);
                }
                };

                // Usage: Call the `updateScore` function passing the score value
                updateScore(score);

            <?php 
            if(isset($_COOKIE['ID'])){
                $playerID = $_COOKIE['ID'];

                // Récupérer le score actuel
                $currentScore = $_POST['score'];// Votre méthode pour obtenir le score actuel
                echo $currentScore;

                // Mettre à jour le score dans la base de données
                $updateScoreSQL = "UPDATE utilisateurs SET Score = $currentScore WHERE ID = $playerID";
                $conn->query($updateScoreSQL);
                
                // Récupérer le meilleur score
                $updateHighScoreSQL = "UPDATE utilisateurs SET High_Score = $currentScore WHERE ID = $playerID";
                $conn->query($updateHighScoreSQL);
                
                $highScoreSQL = "SELECT High_Score FROM utilisateurs WHERE ID = $playerID";
                $result = $conn->query($highScoreSQL);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $highScore = $row["High_Score"];
                    }
                }

                // Comparer le score actuel avec le meilleur score
                
                    // Mettre à jour le meilleur score dans la base de données
                
                $updateHighScoreSQL = "UPDATE utilisateurs SET High_Score = $currentScore WHERE ID = $playerID";
                $conn->query($updateHighScoreSQL);
                
            }
            ?>
        }

        function initMaze(){
            monkeyPosition = {x: 1, y: 1};
            teleporterPositions = [{x: 0, y: 0}, {x: 0, y: 0}];

            maze = createEmptyMaze(mazeSizes[currentMazeIndex], mazeSizes[currentMazeIndex]);

            generateMaze(maze, 1, 1);
            placeBananas(maze, mazeSizes[currentMazeIndex], mazeSizes[currentMazeIndex]);
            placeTeleporters(maze, mazeSizes[currentMazeIndex], mazeSizes[currentMazeIndex]);

            displayMaze(maze, mazeSizes[currentMazeIndex] - 2, mazeSizes[currentMazeIndex] - 2);
        }

        let maze = createEmptyMaze(mazeSizes[currentMazeIndex], mazeSizes[currentMazeIndex]);
        generateMaze(maze, 1, 1);
        placeBananas(maze, mazeSizes[currentMazeIndex], mazeSizes[currentMazeIndex]);
        placeTeleporters(maze, mazeSizes[currentMazeIndex], mazeSizes[currentMazeIndex]);
        displayMaze(maze, mazeSizes[currentMazeIndex] - 2, mazeSizes[currentMazeIndex] - 2);

        document.body.addEventListener("keydown", function(e) {
            switch (e.key) {
                case "ArrowUp": e.preventDefault(); moveMonkey("up"); break;
                case "ArrowDown": e.preventDefault(); moveMonkey("down"); break;
                case "ArrowLeft": e.preventDefault(); moveMonkey("left"); break;
                case "ArrowRight": e.preventDefault(); moveMonkey("right"); break;
            }
        });
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
