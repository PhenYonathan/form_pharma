<?php 
    if(!isset($_POST['submit'])){
        header("Location:index.html");
    }
    else{
        $email = $_POST['mail'];
        $point = strpos($email, ".");
        $aroba = strpos($email, "@");
        if ($point === false || $aroba === false){
            echo "<script type='text/javascript'> alert('Votre email doit comporter un point et un @.'); </script>";
            echo '<script>window.location.href = "index.html";</script>';
        }

        if($_FILES['ordonnance']['error'] > 0){
            echo "<script type='text/javascript'> alert('Une erreur s\'est produite lors de la séléction de l\'ordonannce'); </script>";
            echo '<script>window.location.href = "index.html";</script>';
        }

        $maxSize = 4000000;
        $valideFiles = array('.jpg', '.jpeg', '.png', '.pdf');
        $fileSize = $_FILES['ordonnance']['size'];
        $fileName = $_FILES['ordonnance']['name'];

        if($fileSize > $maxSize){
            echo "<script type='text/javascript'> alert('Votre fichier est trop gros, merci de choisir un fichier de moins de 8MO'); </script>";
            echo '<script>window.location.href = "index.html";</script>';
        }

        $fileExt = "." . strtolower(substr(strrchr($fileName, '.' ),1));
//        if(!in_array($fileExt, $valideFiles)){
//            echo "<script type='text/javascript'> alert('Votre fichier doit être en .jpg, .jpeg, .png ou .pdf'); </script>";
//            echo '<script>window.location.href = "index.html";</script>';
//        }

        $tempName = $_FILES['ordonnance']['tmp_name'];
        $newName = "Ordonnance_de_".$_POST['nom'];
        $fileName = "files/" . $newName . $fileExt;
        $resultat = move_uploaded_file($tempName, $fileName);

        session_start();
        $_SESSION["s_nom"] = $_POST['nom'];
        $_SESSION["s_mail"] = $_POST['mail'];
        $_SESSION["s_ordonnance"] = $fileName;
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Vérifications</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-box">
        <form class="recap" action="mail.php">
            <h1>Bonjour, vous êtes bien <?php echo $_SESSION["s_nom"] ?> ?</h1>
            <h2>Votre email est  <?php echo $_SESSION["s_mail"] ?></h2>
            <h3>Votre ordonnance est bien celle ci ?</h3>
            <?php
                if($fileExt == ".pdf"){
                    echo "<iframe width='100%' height='500px' src='$fileName'></iframe>";
                }else{
                    echo "<img class='img_pres' src='$fileName'>";
                }
            ?>

            <hr class="marge">

            <div class="confirm">
                <label style="color: white">Si toutes les informations sont correctes merci de </label>
                <input class="btn_send" type="submit" value="Confirmer">
            </div>
        </form>
    </div>

</body>
</html>