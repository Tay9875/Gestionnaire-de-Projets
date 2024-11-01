<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $assigned_to=$connexion->prepare("SELECT DISTINCT users.id_u, username, email FROM users, assignation WHERE assignation.id_u=users.id_u AND assignation.id_p='".$_SESSION['id_p']."';");
        $assigned_to->execute();
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
