<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id_p=$_SESSION['id_p'];
        $id_u=$_SESSION['id_u'];
        $delete=$connexion->prepare("DELETE FROM assignation WHERE id_u=$id_u AND id_p=$id_p;");
        $delete->execute();
        header("Location:collab_pre_main.php");
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>