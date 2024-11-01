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
                <input type="text" id="username" name="username" placeholder="nom" required><br><br>
                <input type="text" id="email" name="email" placeholder="nom@email.com" required><br><br>
                <input type="password" id="pw" name="pw" placeholder="mot de passe" required><br><br>
                <input type="password" id="pw2" name="pw2" placeholder="confirmez le mot de passe" required><br><br>
                <input type="submit" name="button" class="button" value="Inscription"><br>
                <hr>
                <p>Déjà un compte? <a href="collab_connexion.php">Se connecter</a></p>
            </form>

            <?php

                    $serveur="localhost";
                    $dbname="db_collab";
                    $user="XXXX";
                    $password="XXXX";

                    if(isset($_POST['button']) && ($_REQUEST['username']!=null && $_REQUEST['email']!=null && $_REQUEST['pw']!=null && $_REQUEST['pw2']!=null)) {
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
                                        $_SESSION['id_p'] = 0;
                                        header("Location:collab_pre_main.php");
                                    }
                            }

                            catch(PDOException $erreur){
                                echo "<div style='position: fixed; top: 0px; left: 0px; width: 100%; z-index: 2;padding: 15px; background-color: #FF6F4B;text-align: center;'><p style='color: white;'>Impossible de traiter les données</p></div>"; 
                            }
                        }
                        else{
                            echo "<div style='position: fixed; top: 0px; left: 0px; width: 100%; z-index: 2;padding: 15px; background-color: #FF6F4B;text-align: center;'><p style='color: white;'>Les mots de passe rentrés ne sont pas identiques!</p></div>"; 
                        }

                    }
                    elseif(isset($_POST['button']) && ($_REQUEST['username']==null || $_REQUEST['email']==null || $_REQUEST['pw']==null || $_REQUEST['pw2'])!=null){
                        echo "<div style='position: fixed; top: 0px; left: 0px; width: 100%; z-index: 2;padding: 15px; background-color: #FF6F4B;text-align: center;'><p style='color: white;'>Un ou plusieurs champs n'ont pas été completé(s)!</p></div>"; 
                    }
                ?>
        </div>
    </body>
</html>
