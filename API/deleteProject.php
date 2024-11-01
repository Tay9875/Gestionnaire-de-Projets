<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        if(isset($_POST['deleteProject'])){
            $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id_p=$_SESSION['id_p'];
            //retire projet
            $delete_P=$connexion->prepare("DELETE FROM projects WHERE id_p=$id_p;");
            if($delete_P->execute()){
                //retire taches
                $delete_P2=$connexion->prepare("DELETE FROM tasks WHERE id_p=$id_p;");
                if($delete_P2->execute()){
                    //retire assignation
                    $delete_P3=$connexion->prepare("DELETE FROM assignation WHERE id_p=$id_p;");
                    $delete_P3->execute();
                    header("Location:collab_pre_main.php");
                }
            }
        }
        //ajouter foncionnalites qui delete les taches
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
