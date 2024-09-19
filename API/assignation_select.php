<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $assigned_to=$connexion->prepare("SELECT id_u, username, email FROM users;");
        $assigned_to->execute();
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>