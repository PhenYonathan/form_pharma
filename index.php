<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyez votre ordonnance</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="img_head">
         <h1>Pharmacie de la gare - Fonction mail</h1>
    </header>

    <div class="login-box">
        <h2>Envoyez votre ordonnance</h2>
        <form name="form_pharam" action="reponse.php" method="POST" enctype="multipart/form-data">
            <div class="user-box">
                <input type="text" name="nom" required>
                <label for="">Votre nom :</label>
            </div>
            <br>
            <div class="user-box">
                <input type="email" name="mail" required>
                <label for="">Votre mail :</label>
            </div>
            <br>
            <div class="user-box">
                <label for="">Votre ordonnance</label> <br>
                <input type="file" name="ordonnance" accept="image/png, image/jpeg, image/jpg, .pdf" required>
            </div>

<!--            <div class="user-box">-->
<!--                <div class="g-recaptcha" data-sitekey=--><?php //echo $_ENV["apiKey"] ?><!-- ></div>-->
<!--            </div>-->
            <br>
            <input class="btn_send" type=submit name="submit" value="Envoyer">
        </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>