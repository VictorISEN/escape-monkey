<?php
session_start();
session_destroy();
echo 'deconnecté';
header('Location: classement.php');

?>