<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id_t=$_SESSION['id_t'];
        $delete=$connexion->prepare("DELETE FROM tasks WHERE id_t=$id_t;");
        $delete->execute();
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
