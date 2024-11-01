<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="XXXX";
    $password="XXXX";

    try{
        if($_POST['add']!=$_SESSION['id_u']){
            $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id_u=$_POST['add'];

            $requete_AddAs = $connexion->prepare("SELECT * FROM assignation WHERE id_p='".$_SESSION['id_p']."' AND id_u=$id_u;");
            $requete_AddAs->execute();

            $row = $requete_AddAs->fetch(PDO::FETCH_ASSOC);

            if(!$row){//alors le projet n'a pas été assigné a l'utilisateur qu'on cherche à assigner
                $requeteB = $connexion->prepare("INSERT INTO assignation(id_u,id_p) VALUES(:id_u,:id_p);");
                $requeteB->bindParam(':id_u',$id_u);
                $requeteB->bindParam(':id_p',$_SESSION['id_p']);
                $requeteB->execute();
                header('Location: '.$_SERVER['REQUEST_URI']);
            }
        }

    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
