<link rel="stylesheet" href="style.css">

<?php
session_start();

     $to = "yonathgm@outlook.fr";
     $sujet = "Envoi de l'ordonnance";
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

    use PHPMailer\PHPMailer\PHPMailer;

    require_once "include/phpmailer/Exception.php";
    require_once "include/phpmailer/PHPMailer.php";
    require_once "include/phpmailer/SMTP.php";

    $mail = new PHPMailer(true);

    try{
//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

//        Configuration de l'envoi
        $mail->isSMTP();
        $mail->Host = "smtp.mailtrap.io";
        $mail->SMTPAuth = true;
        $mail->Username = "b429018729c404";
        $mail->Password = 'b39e8f28bb5bd6';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;

        $mail->CharSet = "utf8";

        $mail->addAddress("yonathgm@outlook.fr");
        $mail->addCC("cc@mail.fr");
//        FROM
        $mail->setFrom("formulaire@site.fr");

//        Message
        $mail->isHTML();
        $mail->Subject= "Ordonannce envoyer via formulaire";
//        $mail->addAttachment($_SESSION["s_ordonnance"], 'ordonnance_de_'.$_SESSION["s_nom"]);
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
        unlink($_SESSION["s_ordonnance"]);
    }catch(Exception){
        echo "Votre message n'a pas pu être envoyer. Erreur : {$mail->ErrorInfo}";
        echo '<a href="index.html">Retour au menu</a>';
    }

?>