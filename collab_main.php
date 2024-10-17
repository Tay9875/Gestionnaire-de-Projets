<?php
    session_start();
    //premier partie de verification: possibilité d'acces seulment si on s'est connecté au site
    if((!isset($_SESSION['email'])) || ($_SESSION['email'] == '')){
        header("Location:collab_connexion.php");
        exit();
    }
    else{

        //check if the get variable exists
        if (isset($_GET['demande']))
        {   if($_GET['demande']==1 || $_GET['demande']==2){
                require('./API/assignation_select.php');
                if(isset($_POST['delete'])){
                    $_SESSION['id_t']=$_POST['delete'];
                    require('./API/deleteTask.php');
                }
                elseif(isset($_POST['modify'])){
                    $_SESSION['id_t']=$_POST['modify'];
                    require('./API/modifyTask.php');
                }
                elseif(isset($_POST['button2'])){
                    require('./API/addTask.php');
                }

                if($_GET['demande']==1){//le mur du projet sélectionné
                    require('./API/mur_1.php');
                    require('./API/mur_2.php');
                    require('./API/mur_3.php');
                
                }
                elseif($_GET['demande']==2){//affichage des tâches de l'utilisateur seulement
                    require('./API/mur_personnel_1.php');
                    require('./API/mur_personnel_2.php');
                    require('./API/mur_personnel_3.php');
                }
            }elseif($_GET['demande']==3){require('./calendrier.php');}
            elseif($_GET['demande']==4){require('./editeur.php');}
            elseif($_GET['demande']==5){//perme la deconnexion e donc la destruction de la session
                session_destroy();
                header("Location:collab_accueil.html");
            }
        }else if(isset ($_GET['sous_demande'])){
            if($_GET['sous_demande']==1){//on demande l'affichage des projets crée par l'utilisateur
                require('./API/projets.php');

                //pour le bouton d'ajout de projet
                if(isset($_POST['projectButton'])){//si le bouton d'un projet est sélectionné on met ce projet comme projet 
                    $_SESSION['id_p']=$_POST['projectButton'];
                    header("Location:collab_main.php?demande=1");
                }
                elseif(isset($_POST['button1'])){
                    require('./API/addProject.php');//si le bouton d'ajout est sélectionné, on ajoute le projet
                }
            }
            else if($_GET['sous_demande']==2){

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

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Helvetica Neue:wght@400;700&display=swap" rel="stylesheet">

            <script src="https://kit.fontawesome.com/1b7208d25c.js" crossorigin="anonymous"></script>

    </head>
    <body style="background-image: url('images/wallpaper_1.jpg');">

        <header style="box-shadow: 2px 2px 30px black;">
            <nav style="top: 100px; left: 200px;">
                <img src="logo/6.png" style="top: 100px;">
                <a href="?sous_demande=1">Mes Projets &emsp;</a>
                <a href="?sous_demande=2">Mes collab &emsp;</a>
                <?php if ($_SESSION['id_p']!=0):?>
                    <a href="?demande=1">Mur &emsp;</a>
                    <a href="?demande=2">Mur personnel &emsp;</a>
                    <a href="?demande=3">Calendrier &emsp;</a>
                    <a href="?demande=4">Editeur &emsp;</a>
                    <a href="?demande=5">Déconnexion &emsp;</a>
                <?php endif ?>
            </nav>
            <div class="connexion">
                <p><?php echo $_SESSION['email']; ?></p>
                <div class="connexion-circle"></div>
            </div>
        </header>

        <div class="body row">
            <!-- AFFICHAGE DES PROJETS DISPONIBLES -->
            <?php if(isset($_GET['sous_demande'])):?>
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
            <?php endif ?>




            <!-- AFFICHAGE DES ELEMENTS DU PROJET -->
            <?php if($_SESSION['id_p']!=0): ?>
            <?php if(isset($_GET['demande'])): ?>
            <section class="col-md-4 left-container">
                <h2 style="color: #EEF1EF;">A faire</h2>
                <?php foreach($requete1 as $row){ ?>
                <div class="element-left">
                    <div class="info">
                        <p class="urgence"><?php echo htmlspecialchars($row['stat']); ?></p>
                        <div>
                            <form method="post">
                                <button type="submit" name="modify" value="<?php echo htmlspecialchars($row['id_t']); ?>"> <i class="fa-sharp fa-solid fa-pen"></i></button>
                                <button type="submit" name="delete" value="<?php echo htmlspecialchars($row['id_t']); ?>"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </div>
                    </div>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <?php if($row['a_rendre']!=null): ?>
                        <p>Date de rendu: <?php echo htmlspecialchars($row['a_rendre']); ?></p>
                    <?php endif ?>
                </div>
                <?php } ?>
                <?php if(isset($_POST['modify'])):?>
                    <form id="form" method="post" class="element">
                        <input type="text" name="description" placeholder="décrivez la tâche..." class="text" required><br>
                        <select id="assigned_to" name="assigned_to">
                            <?php foreach ($assigned_to as $row_a) { ?>
                                <option value="<?php echo htmlspecialchars($row_a['id_u']); ?>"><?php echo htmlspecialchars($row_a['username']); ?></option>
                            <?php } ?>
                        </select>
                        <select id="status" name="status" required>
                            <option value="1">A Faire</option>
                            <option value="2">En Cours</option>
                            <option value="3">Terminé</option>
                        </select><br>
                        <label>A rendre pour:</label>
                        <input type="date" id="date" name="date" class="date" required><br>
                        <button type="submit" name="button2" value="button2" class="ajout">+</button>
                    </form>
                <?php endif ?>
            </section>

            <section class="col-md-4 middle-container">
                <h2 style="color: #EEF1EF;">En cours</h2>
                <?php foreach($requete2 as $row){ ?>
                <div class="element-middle">
                    <div class="info">
                        <p class="urgence"><?php echo htmlspecialchars($row['stat']); ?></p>
                        <div>
                            <form method="post">
                                <button type="submit" name="modify" value="<?php echo htmlspecialchars($row['id_t']); ?>"><i class="fa-sharp fa-solid fa-pen"></i></button>
                                <button type="submit" name="delete" value="<?php echo htmlspecialchars($row['id_t']); ?>"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </div>
                    </div>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <?php if($row['a_rendre']!=null): ?>
                        <p>Date de rendu: <?php echo htmlspecialchars($row['a_rendre']); ?></p>
                    <?php endif ?>
                </div>
                <?php } ?>
            </section>

            <section class="col-md-4 right-container">
                <h2 style="color: #EEF1EF;">Terminé</h2>
                <?php foreach($requete3 as $row){ ?>
                <div class="element-right">
                    <div class="info">
                        <p class="urgence"><?php echo htmlspecialchars($row['stat']); ?></p>
                        <div>
                            <form method="post">
                                <button type="submit" name="modify" value="<?php echo htmlspecialchars($row['id_t']); ?>"><i class="fa-sharp fa-solid fa-pen"></i></button>
                                <button type="submit" name="delete" value="<?php echo htmlspecialchars($row['id_t']); ?>"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </div>
                    </div>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <?php if($row['a_rendre']!=null): ?>
                        <p>Date de rendu: <?php echo htmlspecialchars($row['a_rendre']); ?></p>
                    <?php endif ?>
                </div>
                <?php } ?>
            </section>



            <section class="col-md-4 left-container">
                <form id="form2" method="post" class="element">
                    <input type="text" name="description" placeholder="décrivez la tâche..." class="text" required><br>
                    <select id="assigned_to" name="assigned_to">
                        <?php foreach ($assigned_to as $row_a) { ?>
                            <option value="<?php echo htmlspecialchars($row_a['id_u']); ?>"><?php echo htmlspecialchars($row_a['username']); ?></option>
                        <?php } ?>
                    </select>
                    <select id="status" name="status" required>
                        <option value="1">A Faire</option>
                        <option value="2">En Cours</option>
                        <option value="3">Terminé</option>
                    </select><br>
                    <label>A rendre pour:</label>
                    <input type="date" id="date" name="date" class="date" required><br>
                    <button type="submit" name="button2" value="button2" class="ajout">+</button>
                </form>
            </section>
        <?php endif ?>
    <?php endif ?>
        </div>
    </body>

    <script type="text/javascript">
        function redirect(){
            location.href = 'collab_accueil.html'; // Redirection vers la prochaine étape du jeu
        }
    </script>
</html>
