<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = $connexion->prepare("SELECT DISTINCT projects.id_p as id_p, projects.name as name, users.username as created_by, projects.updated_at as updated_at FROM users,projects,assignation WHERE users.id_u=projects.created_by AND assignation.id_p=projects.id_p AND assignation.id_u='".$_SESSION['id_u']."' ORDER BY projects.updated_at;'");
        $requete->execute();
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
