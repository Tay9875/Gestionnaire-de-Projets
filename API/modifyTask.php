<?php
    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        echo $_SESSION['id_t'];
        echo "<script>alert('Description cliqué!');</script>";

        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                
        $updateD=$connexion->prepare("UPDATE tasks SET description=:description WHERE id_t=:id_t");
        $updateD->bindParam(':description', $_POST['modifyD']);
        $updateD->bindParam(':id_t', $_SESSION['id_t']);//le bouton de modification a une valeur differente en fonction de la tache cliqué

        $updateD->execute();
        echo "<script>alert('Description changé!');</script>";
        header('Location: '.$_SERVER['REQUEST_URI']);
            /*
            elseif(isset($_POST['modifyStatus'])){
                echo "<script>alert('Status cliqué!');</script>";
                $updateS=$connexion->prepare("UPDATE tasks SET status=:status WHERE id_t=:id_t");
                $updateS->bindParam(':status', $_POST['status']);
                $updateS->bindParam(':id_t', $_SESSION['id_t']);
                $updateS->execute();
                echo "<script>alert('Status changé!');</script>";
            }

            elseif(isset($_POST['modifyARendre'])){
                echo "<script>alert('A Rendre cliqué!');</script>";
                $updateR=$connexion->prepare("UPDATE tasks SET a_rendre=:a_rendre WHERE id_t=:id_t");
                $updateR->bindParam(':a_rendre', $_POST['date']);
                $updateR->bindParam(':id_t', $_SESSION['id_t']);
                $updateR->execute();
                echo "<script>alert('A Rendre changé!');</script>";
            }*/
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }?>