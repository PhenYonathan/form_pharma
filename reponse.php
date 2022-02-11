<?php 
    if(!isset($_POST['submit'])){
        header("Location:index.html");
    }
    else{
        $email = $_POST['mail'];
        $point = strpos($email, ".");
        $aroba = strpos($email, "@");
        if ($point === false || $aroba === false){
            echo 'aaaaaaaaaaaaaa';
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
</head>
<body>
    <form action="mail.php">
        <h1>Bonjour, vous êtes bien <?php echo $_POST['nom'] ?> ?</h1>
        <h2>Votre email est  <?php echo $_POST['mail'] ?></h2>
        <h2>Votre ordonnance est bien celle ci ? <br>
            <embed src="<?php $_POST['ordonnance'] ?>" width=800 height=500 type='application/pdf'/>
        </h2>
        <br>
        <label>Si toutes les informations sont correctes merci de </label>
        <input type="submit" value="Confirmer" disabled>
    </form>
    
</body>
</html>