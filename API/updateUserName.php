<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        if(isset($_POST['changeUsername'])){
            $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id_u=$_SESSION['id_u'];
            $updateUsername=$connexion->prepare("UPDATE users SET username=:username WHERE id_u=$id_u");
            $updateUsername->bindParam(':username', $_POST['username']);
            $updateUsername->execute();
        }
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
