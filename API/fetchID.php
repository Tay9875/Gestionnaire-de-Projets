<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = $connexion->prepare("SELECT DISTINCT id_u FROM users WHERE email='".$_SESSION['email']."';'");
        $requete->execute();
        $result = $requete->fetchAll();
        if ($result ){
            $_SESSION['id_u'] = $result;
            header("Location:collab_main.php");
        }
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>