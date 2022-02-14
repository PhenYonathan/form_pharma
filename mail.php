<link rel="stylesheet" href="style.css">

<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once 'vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
        <h1>Vous venez de recevoir l\'ordonannce de : '.$_SESSION["s_nom"].'</h1>
        <h2>Mail : '.$_SESSION["s_mail"].'</h2>
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
        $mail->Username = $_ENV['username'];
        $mail->Password = $_ENV['pswd'];
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
        $mail->addAttachment($_SESSION["s_ordonnance"]);
        $mail->Body= $message;
//        Au cas ou HTML non pris en compte
        $mail->AltBody= $message;

        $mail->send();
        echo '
        <div class="login-box">
            <h1>Votre message a bien été envoyer</h1>
            
            <div class="mapouter">
            <div class="gmap_canvas">
                <iframe width="800" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Pharmacie%20de%20la%20Gare,%2074%20Av.%20Jean%20Jaur%C3%A8s,%2078500%20Sartrouville&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                <style>.mapouter{position:relative;text-align:right;height:500px;width:800px;}</style>
                <style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:800px;}</style>
            </div>
        </div>
        </div>';

        session_destroy();

        unlink($_SESSION["s_ordonnance"]);
    }catch(Exception){
        echo "Votre message n'a pas pu être envoyer. Erreur : {$mail->ErrorInfo}";
        echo '<a href="index.php">Retour au menu</a>';
    }

?>