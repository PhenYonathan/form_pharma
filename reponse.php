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
            <h1>Bonjour, vous êtes bien <?php echo $_POST['nom'] ?> ?</h1>
            <h2>Votre email est  <?php echo $_POST['mail'] ?></h2>
            <h3>Votre ordonnance est bien celle ci ?</h3>
            <img class="img_pres" src="assets/img_temp.jpg" alt="">

            <hr class="marge">

            <div class="confirm">
                <label>Si toutes les informations sont correctes merci de </label>
                <input type="submit" value="Confirmer">
            </div>
        </form>
    </div>

</body>
</html>