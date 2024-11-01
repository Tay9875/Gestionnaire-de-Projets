<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        if(isset($_POST['search'])){
            $research=$_POST['search'];

            $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $collab = $connexion->prepare("SELECT DISTINCT id_u, username, email FROM users WHERE email REGEXP '^".$research."';");
            $collab->execute();
        }
        elseif(isset($_POST['reset'])){
            $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $collab = $connexion->prepare("SELECT DISTINCT id_u, username, email FROM users ORDER BY email;");
            $collab->execute();
        }
        else{
            $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $collab = $connexion->prepare("SELECT DISTINCT id_u, username, email FROM users ORDER BY email;");
            $collab->execute();
        }
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>