<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    //la vérification isset du bouton est directement sur la page principale
    if(empty($_POST['description'])){//vérification que le champ texte ne soit pas vide
        echo "<script>alert('Il n'y a pas de titre');</script>";
    }else{
        $description = htmlentities($_POST['description'], ENT_QUOTES, "UTF-8");
        $status = htmlentities($_POST['status'], ENT_QUOTES, "UTF-8");
        $assigned_to = 2;

        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!$connexion){
            echo "<script>alert('Erreur de connexion a la base de données!');</script>";
        }
        else{//insere la tâche dans la table dédiée
            $requete_Ajout_tasks = $connexion->prepare("INSERT INTO tasks(description,status,assigned_to,created_by,id_p) VALUES (:description,:status,:assigned_to,:created_by,:id_p);");

            $requete_Ajout_tasks->bindParam(':description',$description);
            $requete_Ajout_tasks->bindParam(':status',$status);
            $requete_Ajout_tasks->bindParam(':created_by',$_SESSION['id_u']);
            $requete_Ajout_tasks->bindParam(':assigned_to',$assigned_to);
            $requete_Ajout_tasks->bindParam(':id_p',$_SESSION['id_p']);

            
            if($requete_Ajout_tasks->execute()) {
                echo "<script>alert('Tâche rajouté avec succés');</script>";
            }
            else{
                echo "<script>alert('Erreur de connexion a la base de données!');</script>";
            }
        }
    }
?>