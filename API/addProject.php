<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    if(empty($_POST['name'])){
        echo "<script>alert('Il n'y a pas de titre');</script>";
    }else{
        $name = htmlentities($_POST['name'], ENT_QUOTES, "UTF-8");

        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!$connexion){
            echo "<script>alert('Erreur de connexion a la base de données depuis main!');</script>";
        }
        else{
            $requete = $connexion->prepare("INSERT INTO projects(name,created_by) VALUES (:name,:created_by);");
            $requete->bindParam(':name',$name);
            $requete->bindParam(':created_by',$_SESSION['id_u']);

            if ($requete->execute()) {
                //A ajouter: une partie qui ajoue pour la assignation
                $temoin=$_SESSION['id_u'];
                $requeteB = $connexion->prepare("SELECT id_p FROM projects WHERE created_by = $temoin AND created_at = (SELECT max(created_at) FROM projects WHERE created_by = $temoin);");
                $requeteB->execute();
                foreach ($requeteB as $row) {
                    $id_p = $row['id_p'];
                    $requete2 = $connexion->prepare("INSERT INTO assignation(id_u,id_p) VALUES(:id_u,:id_p);");
                    $requete2->bindParam(':id_u',$_SESSION['id_u']);
                    $requete2->bindParam(':id_p',$id_p);
                    $requete2->execute();
                }
            } else {
                echo "Impossible de créer l'enregistrement";
            }
        }
    }
?>
