<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = $connexion->prepare("SELECT name FROM projects WHERE id_p='".$_SESSION['id_p']."';");
        $name->execute();

        $row = $name->fetch(PDO::FETCH_ASSOC);

        $_SESSION['name']=$row['name'];

    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>