
<?php session_start(); 
$_SESSION['pageAvantinsc'] = $_SERVER['HTTP_REFERER'];
?>

<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupModalLabel">Inscription</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="inscription" action="ajout.php" method="post">
                        <div class="form-group">
                            <label for="signupPassword">Nom</label>
                            <input type="Nom" name="nom" class="form-control" id="signupNom" placeholder="Nom">
                        </div>
                        <div class="form-group">
                            <label for="signupPassword">Prenom</label>
                            <input type="prenom" name="prenom" class="form-control" id="signupPrenom" placeholder="Prenom">
                        </div>
                        <div class="form-group">
                            <label for="signupPassword">Pseudo</label>
                            <input type="pseudo" name="pseudo" class="form-control" id="signupPseudo" placeholder="Pseudo">
                        </div>
                        <div class="form-group">
                            <label for="signupEmail">Adresse Email</label>
                            <input type="email" name="email" class="form-control" id="signupEmail" aria-describedby="emailHelp" placeholder="Entrez votre email">
                        </div>
                        <div class="form-group">
                            <label for="signupPassword">Mot de Passe</label>
                            <input type="password" name="password" class="form-control" id="signupPassword" placeholder="Mot de passe">
                        </div>
                        <button type="submit" name="envoyer" value="envoyer" class="btn btn-primary">S'inscrire</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
