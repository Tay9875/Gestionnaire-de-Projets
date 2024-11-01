<?php
    session_start();
    //premier partie de verification: possibilité d'acces seulment si on s'est connecté au site
    if((!isset($_SESSION['email'])) || ($_SESSION['email'] == '')){
        header("Location:collab_connexion.php");
        exit();
    }
    else{
        require('./API/projets.php');

        //pour le bouton d'ajout de projet
        if(isset($_POST['projectButton'])){//si le bouton d'un projet est sélectionné on met ce projet comme projet 
            $_SESSION['id_p']=$_POST['projectButton'];
            header("Location:collab_main.php?demande=1");
        }
        elseif(isset($_POST['button1'])){
            require('./API/addProject.php');//si le bouton d'ajout est sélectionné, on ajoute le projet
            header("Location:collab_pre_main.php");
        }
        elseif(isset($_GET['demande'])){
            if($_GET['demande']==5){//perme la deconnexion e donc la destruction de la session
                session_destroy();
                header("Location:collab_accueil.html");
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Menu</title>
        <!--Stylesheet CSS-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="collab_main.css">
            <link rel="stylesheet" type="text/css" href="collab_pre_main.css">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Helvetica Neue:wght@400;700&display=swap" rel="stylesheet">

            <script src="https://kit.fontawesome.com/1b7208d25c.js" crossorigin="anonymous"></script>

    </head>
    <body style="background-image: url('images/wallpaper_1.jpg');">

        <header style="box-shadow: 2px 2px 30px black;">
            <nav style="top: 100px; left: 200px;">
                <img src="logo/6.png" style="top: 100px;">
                <a href="collab_pre_main.php">Mes Projets &emsp;</a>
                <a href="?demande=5">Déconnexion &emsp;</a>
            </nav>
            <div>
                <p><?php echo $_SESSION['email']; ?></p>
            </div>
        </header>

        <div class="body row">
            <!-- AFFICHAGE DES PROJETS DISPONIBLES -->
                <?php foreach($requete as $row){ ?>
                <div class="col-md-4">
                    <div class="element">
                        <h6><?php echo htmlspecialchars($row['name']); ?></h6>
                        <p3>Créé par <?php echo htmlspecialchars($row['created_by']); ?></p3><br>
                        <p3>Dernière modification: <?php echo htmlspecialchars($row['updated_at']); ?></p3><br>
                        <form method="post">
                            <button type="submit" name="projectButton" value="<?php echo htmlspecialchars($row['id_p']);?>">Utiliser</button>
                        </form>
                    </div>
                </div>
                <?php } ?>

                <section class="col-md-4">
                    <form id="form1" method="post" class="element">
                        <h6>Ajouter un projet</h6>
                        <input type="text" name="name" placeholder="le titre du projet..." class="text" required>
                        <button type="submit" name="button1" value="Ajouter" class="ajout">+</button>
                    </form>
                </section>
        </div>
    </body>

    <script type="text/javascript">
        function redirect(){
            location.href = 'collab_accueil.html'; // Redirection vers la prochaine étape du jeu
        }
    </script>
</html>