<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Connexion</title>
        <!--Stylesheet CSS-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="collab_menu.css">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Muli&family=Helvetica Neue&family=Open Sans:wght@400;700&display=swap" rel="stylesheet">

            <link rel="stylesheet" type="text/css" href="collab_conn_inscri.css">

    </head>
    <body>
        <div class="container connexion">
            <form method="post">
                <h1>Connectez-vous</h1>
                <p>Et participez à de nouveaux projets.</p>
                <input type="text" id="email" name="email" placeholder="nom@email.com"><br><br>
                <input type="pw" id="pw" name="pw" placeholder="mot de passe"><br><br>
                <input type="submit" name="button" class="button" value="Connexion"><br>
                <hr>
                <p>Pas de compte? <a href="collab_inscription.php">S'inscrire</a></p>
            </form>

            <?php

                    $serveur="localhost";
                    $dbname="db_collab";
                    $user="root";
                    $password="0000";

                    if(isset($_POST['button'])){
                        if(empty($_POST['email'])){
                            echo "Le champ email est vide.";
                        }else{
                            if(empty($_POST['pw'])){
                                echo "Le champ du mot de passe est vide.";
                            }
                            else{
                                $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8"); 
                                $pw = htmlentities($_POST['pw'], ENT_QUOTES, "UTF-8");
                                //$hash=password_hash($pw,PASSWORD_DEFAULT);//pour verifier la version hashé du mot de passe

                                $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
                                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                if(!$connexion){
                                    echo "<script>alert('Erreur de connexion a la base de données!');</script>";
                                }
                                else{
                                    $requete = $connexion->prepare("SELECT * FROM users WHERE email = '".$email."' AND pw = '".$pw."'");

                                    $requete->execute();

                                    $result = $requete->fetchAll();

                                    if ( $result ){
                                        //on ouvre la session avec $_SESSION:
                                        //la session peut être appelée différemment et son contenu aussi peut être autre chose que le pseudo
                                        $_SESSION['email'] = $email;

                                        $requeteID = $connexion->prepare("SELECT DISTINCT id_u,username FROM users WHERE email='".$_SESSION['email']."';'");

                                        $requeteID->execute();

                                            foreach ($requeteID as $row) {
                                                $_SESSION['id_u'] = $row['id_u'];
                                                $_SESSION['username'] = $row['username'];
                                                $_SESSION['id_p'] = 0;//tant que aucun proje n'a été sélectionné
                                                header("Location:collab_main.php");
                                            }
                                        
                                    }
                                    else echo "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
                                }

                            }
                        }
                    }
                ?>
        </div>
        <div class="space"></div>
    </body>
</html>