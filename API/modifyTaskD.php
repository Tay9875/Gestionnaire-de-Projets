<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!$connexion){
            echo "<script>alert('Erreur de connexion à la base de données');</script>";
        }
        else{
            $updateD=$connexion->prepare("UPDATE tasks SET description=:description WHERE id_t=:id_t");
            $updateD->bindParam(':description', $_POST['description']);
            $updateD->bindParam(':id_t', $_SESSION['id_t']);//le bouton de modification a une valeur differente en fonction de la tache cliqué

            $updateD->execute();
            echo "<script>alert('Decription changé!');</script>";
        }
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }?>
