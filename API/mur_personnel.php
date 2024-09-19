<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete1 = $connexion->prepare("SELECT DISTINCT * FROM tasks,status WHERE tasks.status=status.id_s AND tasks.status=1 AND tasks.assigned_to='".$_SESSION['id_p']."' ORDER BY status, id_t;'");
        $requete1->execute();

        $requete2 = $connexion->prepare("SELECT DISTINCT * FROM tasks,status WHERE tasks.status=status.id_s AND tasks.status=2 AND tasks.assigned_to='".$_SESSION['id_p']."' ORDER BY status, id_t;'");
        $requete2->execute();

        $requete3 = $connexion->prepare("SELECT DISTINCT * FROM tasks,status WHERE tasks.status=status.id_s AND tasks.status=3 AND tasks.assigned_to='".$_SESSION['id_p']."' ORDER BY status, id_t;'");
        $requete3->execute();
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>