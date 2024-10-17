<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Inscription</title>
        <!--Stylesheet CSS-->
            <link rel="stylesheet" type="text/css" href="collab_menu.css">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Muli&family=Helvetica Neue&family=Open Sans:wght@400;700&display=swap" rel="stylesheet">

            <link rel="stylesheet" type="text/css" href="collab_conn_inscri.css">



    </head>
    <body class="inscription">
        <div class="container inscription">
            <form method="post">
                <a href="collab_accueil.html"><img src="logo/6.png" class="logo"></a><br>
                <h1>Bienvenue sur collab</h1>
                <p>Commencez a mieux gérer vos projets, gratuitement.</p>
                <input type="text" id="username" name="username" placeholder="nom"><br><br>
                <input type="text" id="email" name="email" placeholder="nom@email.com"><br><br>
                <input type="pw" id="pw" name="pw" placeholder="mot de passe"><br><br>
                <input type="pw2" id="pw2" name="pw2" placeholder="confirmez le mot de passe"><br><br>
                <input type="submit" name="button" class="button" value="Inscription"><br>
                <hr>
                <p>Déjà un compte? <a href="collab_connexion.php">Se connecter</a></p>
            </form>

            <?php

                    $serveur="localhost";
                    $dbname="db_collab";
                    $user="XXXX";
                    $password="XXXX";

                    if(isset($_POST['button']) && ($_REQUEST['username']!=null || $_REQUEST['email']!=null || $_REQUEST['pw']!=null || $_REQUEST['pw2'])!=null) {
                        if($_POST["pw"] == $_POST["pw2"]){
                            try{
                                $connexion=new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
                                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $username =  $_REQUEST['username'];
                                $email = $_REQUEST['email'];
                                $pw = $_REQUEST['pw'];
                                $pw_hash=password_hash($pw, PASSWORD_DEFAULT);

                                $sth=$connexion->prepare("
                                    INSERT INTO users(username, email, pw)VALUES('$username','$email','$pw_hash');");

                                $sth->execute();
                                $_SESSION['email'] = $email;

                                $requeteID = $connexion->prepare("SELECT DISTINCT id_u,username FROM users WHERE email='".$_SESSION['email']."';'");

                                $requeteID->execute();

                                    foreach ($requeteID as $row) {
                                        $_SESSION['id_u'] = $row['id_u'];
                                        $_SESSION['username'] = $row['username'];
                                        header("Location:collab_main.php");
                                    }
                            }

                            catch(PDOException $erreur){
                                echo "<script>alert('Impossible de traiter les données.');</script>"; 
                            }
                        }
                        else{
                            echo "<script>alert('Les mots de passe rentrés ne sont pas identiques!');</script>"; 
                        }

                    }
                    elseif(isset($_POST['button']) && ($_REQUEST['username']==null || $_REQUEST['email']==null || $_REQUEST['pw']==null || $_REQUEST['pw2'])!=null){
                        echo "<script>alert('Un ou plusieurs champs n'ont pas été completé(s)!');</script>"; 
                    }
                ?>
        </div>
    </body>
</html>
