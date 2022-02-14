<?php

     $to = "yonathgm@outlook.fr";
     $sujet = "Envoi de l'ordonnance";
     $message = $_POST['nom'];

    // $headers = [
    //     "From" => "formulaire@site.fr",
    //     "Content-Type" => "test/html; charset=utf8"
    // ];

    // $sendmail = mail($to, $sujet, $message, $headers);

    // if ($sendmail)
    //     echo '<p>Votre message a bien été envoyé.</p>';

    use PHPMailer\PHPMailer\PHPMailer;

    require_once "include/phpmailer/Exception.php";
    require_once "include/phpmailer/PHPMailer.php";
    require_once "include/phpmailer/SMTP.php";

    $mail = new PHPMailer(true);

    try{
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();
        $mail->Host = "localhost";
        $mail->Port = 1234;

        $mail->CharSet = "utf8";

        $mail->addAddress("yonathgm@outlook.fr");
        $mail->addCC("cc@mail.fr");
//        FROM
        $mail->setFrom("formulaire@site.fr");

//        Message
        $mail->isHTML();
        $mail->Subject= "Ordonannce envoyer via formaulaire";
        $mail->Body= $message;
//        Au cas ou HTML non pris en compte
        $mail->AltBody= $message;

        $mail->send();
        echo "<script type='text/javascript'> alert('Message envoyé !'); </script>";
    }catch(Exception){
        echo "<script type='text/javascript'> alert('Votre message n'a pas pu être envoyer. Erreur : {$mail->ErrorInfo}'); </script>";
    }

?>