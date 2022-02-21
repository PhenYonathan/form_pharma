<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_POST['submit'])){
    $email = $_POST['mail'];
    $point = strpos($email, ".");
    $aroba = strpos($email, "@");
    if ($point === false || $aroba === false){
        echo "<script type='text/javascript'> alert('Votre email doit comporter un point et un @.'); </script>";
    }

    if($_FILES['ordonnance']['error'] > 0){
        echo "<script type='text/javascript'> alert('Une erreur s\'est produite lors de la séléction de l\'ordonannce'); </script>";
    }

    $maxSize = 4000000;
    $valideFiles = array('.jpg', '.jpeg', '.png', '.pdf');
    $fileSize = $_FILES['ordonnance']['size'];
    $fileName = $_FILES['ordonnance']['name'];

    if($fileSize > $maxSize){
        echo "<script type='text/javascript'> alert('Votre fichier est trop gros, merci de choisir un fichier de moins de 8MO'); </script>";
    }

    $fileExt = "." . strtolower(substr(strrchr($fileName, '.' ),1));
    if(!in_array($fileExt, $valideFiles)){
        echo "<script type='text/javascript'> alert('Votre fichier doit être en .jpg, .jpeg, .png ou .pdf'); </script>";
    }

    if(isset($_POST['recaptcha-response'])) {

        $url = "https://www.google.com/recaptcha/api/siteverify?secret={$_ENV['apiKeySecret']}&response={$_POST['recaptcha-response']}";

        if(function_exists('curl_version')){
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        }else{
            $response = file_get_contents($url);
        }

        if (empty($response) || is_null($response)){
//            header("location:index.php");
            echo "<script type='text/javascript'> alert('null'); </script>";
            echo '<script>window.location.href = "index.php";</script>';
        }else{
            $data = json_decode($response);
            if ($data->success){
                $message = '
        <style>
    html {
        height: 100%;
    }
    img{
        height: 100px;
    }
    .login-box{
        text-align: center;
    }
    body {
        margin:0;
        padding:0;
        font-family: sans-serif;
        background: linear-gradient(#ffffff, #daffc5);
    }
    .login-box {
        position: absolute;
        top: 50%;
        left: 50%;
        padding: 40px;
        transform: translate(-50%, -50%);
        background: rgba(0,0,0,.5);
        box-sizing: border-box;
        box-shadow: 0 15px 25px rgba(0,0,0,.6);
        border-radius: 10px;
    }

    .login-box h2 {
        margin: 0 0 30px;
        padding: 0;
        color: #fff;
        text-align: center;
    }
    .login-box h1 {
        margin: 0 0 30px;
        padding: 0;
        color: #fff;
        text-align: center;
    }
    p{
        color: white;
    }
        </style>
        
        <div class="login-box">
    <h1>Vous venez de recevoir l\'ordonannce de : '.$_POST['nom'].'</h1>
    <h2>Mail : '.$_POST['mail'].'</h2>
    <p>Veuillez retrouver l\'ordonnance en piéce jointe.</p>
    <hr>
    <p>Merci de nous avoir fais confiance pour la mise en place de votre formulaire.</p>
    <img src="https://www.typia.fr/wp-content/uploads/2016/01/logo.png">
</div>
        ';

                $mail = new PHPMailer(true);

                try{
//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

//        Configuration de l'envoi
                    $mail->isSMTP();
                    $mail->Host = $_ENV['host'];
                    $mail->SMTPAuth = true;
//                    $mail->Username = $_ENV['username'];
//                    $mail->Password = $_ENV['pswd'];
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = $_ENV['port'];

                    $mail->CharSet = "utf8";

                    $mail->addAddress($_ENV['mailTo']);
                    $mail->addCC($_ENV['mailCc']);
//        FROM
                    $mail->setFrom("formulaire@site.fr");

//        Message
                    $mail->isHTML();
                    $mail->Subject= "Ordonannce envoyer via formulaire";
//                    $mail->addAttachment($_FILES['ordonnance']);
                    $mail->Body= $message;
//        Au cas ou HTML non pris en compte
                    $mail->AltBody= $message;

                    $mail->send();

                    header("location:reponse.php");
                } catch (Exception){
                    echo "Votre message n'a pas pu être envoyer. Erreur : {$mail->ErrorInfo}";
                    echo '<a href="index.php">Retour au menu</a>';
                }

            echo "<script type='text/javascript'> alert('message envoyé'); </script>";
            }
            else{
                echo "<script type='text/javascript'> alert('Timeout ou tentative d\'intrusion veuillez réessayer'); </script>";
                echo '<script>window.location.href = "index.php";</script>';
            }
        }
    }
    else{
        echo "<script type='text/javascript'> alert('un robot ?'); </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyez votre ordonnce</title>

    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <div class="left">
        <div class="header">
            <h2 class="animation a1">Bonjour</h2>
            <h4 class="animation a2">Veuillez entrer les informations ci-dessous</h4>
        </div>
        <form class="form" name="form_pharam" action="index.php" method="POST" enctype="multipart/form-data">
            <input name="nom"           type="text"     class="form-field animation a3" placeholder="Votre nom"         required>
            <input name="mail"          type="email"    class="form-field animation a4" placeholder="Votre email"       required>
            <input name="ordonnance"    type="file"     class="form-field animation a5" placeholder="Votre ordonnance"  required>

            <!--            <input type="submit" name="submit" class="button animation a7" value="Envoyer">-->
            <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
            <button class="button animation a6" name="submit">Envoyer</button>
        </form>
    </div>
    <div class="right"></div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $_ENV["apiKey"] ?>"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute("<?php echo $_ENV["apiKey"] ?>", {action: 'submit'}).then(function(token) {
            document.getElementById("recaptchaResponse").value = token
        });
    });
</script>


</body>
</html>