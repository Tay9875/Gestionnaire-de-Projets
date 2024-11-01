<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        if(isset($_POST['changeName'])){
            $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id_p=$_SESSION['id_p'];
            $updateName=$connexion->prepare("UPDATE projects SET name=:name WHERE id_p=$id_p");
            $updateName->bindParam(':name', $_POST['name']);
            $updateName->execute();
        }
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>