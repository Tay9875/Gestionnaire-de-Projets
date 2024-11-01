<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    //la vérification isset du bouton est directement sur la page principale
    if(empty($_POST['description'])){//vérification que le champ texte ne soit pas vide
        echo "<dialog open style='border-radius: 5px;border: none;position: fixed;bottom: 10px;left: 85%;'>
                  <p>Il n'y a pas de titre</p>
                  <form method='dialog'>
                    <button>OK</button>
                  </form>
                </dialog>";
    }else{
        $description = htmlentities($_POST['description'], ENT_QUOTES, "UTF-8");
        $status = htmlentities($_POST['status'], ENT_QUOTES, "UTF-8");
        $date = htmlentities($_POST['date'], ENT_QUOTES, "UTF-8");
        $assigned_to = 2;

        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!$connexion){
            echo "<script>alert('Erreur de connexion a la base de données!');</script>";
        }
        else{//insere la tâche dans la table dédiée
            $requete_Ajout_tasks = $connexion->prepare("INSERT INTO tasks(description,status,assigned_to,created_by,id_p,a_rendre) VALUES (:description,:status,:assigned_to,:created_by,:id_p,:a_rendre);");

            $requete_Ajout_tasks->bindParam(':description',$description);
            $requete_Ajout_tasks->bindParam(':status',$status);
            $requete_Ajout_tasks->bindParam(':created_by',$_SESSION['id_u']);
            $requete_Ajout_tasks->bindParam(':assigned_to',$assigned_to);
            $requete_Ajout_tasks->bindParam(':id_p',$_SESSION['id_p']);
            $requete_Ajout_tasks->bindParam(':a_rendre',$date);


            
            if($requete_Ajout_tasks->execute()) {}
            else{
                echo "<script>alert('Erreur de connexion a la base de données!');</script>";
            }
        }
    }
?>
