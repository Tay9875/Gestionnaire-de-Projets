<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id_p=$_SESSION['id_p'];

        $requete2 = $connexion->prepare("SELECT DISTINCT * FROM tasks,status,users WHERE tasks.status=status.id_s AND tasks.status=2 AND tasks.assigned_to=users.id_u AND tasks.id_p=$id_p AND tasks.assigned_to='".$_SESSION['id_u']."' ORDER BY status, id_t;'");
        $requete2->execute();
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
