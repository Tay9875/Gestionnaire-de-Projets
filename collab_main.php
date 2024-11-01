<?php
    session_start();
    //premier partie de verification: possibilité d'acces seulment si on s'est connecté au site
    if((!isset($_SESSION['email'])) || ($_SESSION['email'] == '')){
        header("Location:collab_connexion.php");
        exit();
    }
    elseif($_SESSION['id_p'] == ''){
        header("Location:collab_pre_main.php");
        exit();
    }
    else{
        require('./API/projectInfo.php');
        //check if the get variable exists
        if (isset($_GET['demande'])){
            require('./API/collabs.php');
            if($_GET['demande']==1 || $_GET['demande']==2){
                require('./API/assignation_select.php');
                if(isset($_POST['delete'])){
                    $_SESSION['id_t']=$_POST['delete'];
                    require('./API/deleteTask.php');
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
            }
            elseif($_GET['demande']==3){//perme la deconnexion et donc la destruction de la session
                session_destroy();
                header("Location:collab_accueil.html");
            }

            //dans les sidebars
            if(isset($_POST['add'])){
                require('./API/addAssignation.php');
            }

            if(isset($_POST['changeName'])){
                require('./API/updateProjectName.php');
            }

            if(isset($_POST['changeUsername'])){
                require('./API/updateUserName.php');
            }

            if(isset($_POST['deleteFromProject'])){
                require('./API/deleteAssignation.php');
            }

            if(isset($_POST['deleteProject'])){
                require('./API/deleteProject.php');
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
            <link rel="stylesheet" type="text/css" href="collab_sidebar.css">

            <style>
                /* SCROLLBAR CSS */
                /* width */
                ::-webkit-scrollbar {
                  width: 5px;
                }

                /* Track */
                ::-webkit-scrollbar-track { 
                  border-radius: 15px;
                }
                 
                /* Handle */
                ::-webkit-scrollbar-thumb {
                  background: #363537; 
                  border-radius: 15px;
                }


                /* Handle on hover */
                ::-webkit-scrollbar-thumb:hover {
                  background: linear-gradient(#E13661 10%, #FD4C55); 
                }
            </style>

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Helvetica Neue:wght@400;700&display=swap" rel="stylesheet">

            <script src="https://kit.fontawesome.com/1b7208d25c.js" crossorigin="anonymous"></script>

    </head>
    <body style="background-image: url('images/wallpaper_1.jpg');">

        <header style="box-shadow: 2px 2px 30px black;">
            <nav style="top: 100px; left: 200px;">
                <img src="logo/6.png" style="top: 100px;">
                <a href="collab_pre_main.php"><i class="fa-solid fa-arrow-left-long"></i> &emsp;</a>
                <?php if ($_SESSION['id_p']!=0):?>
                    <a onclick="openNav(1)">Mes collab &emsp;</a>
                    <a href="?demande=1">Mur &emsp;</a>
                    <a href="?demande=2">Mur personnel &emsp;</a>
                    <a onclick="openNav(2)"><i class="fa-solid fa-gear"></i> &emsp;</a>
                    <a href="?demande=3">Déconnexion &emsp;</a>
                <?php endif ?>
            </nav>
        </header>

        <div id="mySidebar" class="sidebar">
          <? php require('./API/assignation_select.php'); ?>
          <a href="javascript:void(0)" class="closebtn" onclick="closeNav(1)"><i class="fa-solid fa-square-xmark"></i></a>

          <h2 style="margin: 10px;">Trouvez des collab.ers</h2>
          
          <!-- Research bar -->
          <form method="post" class="mini-bar">
              <input class="mini" type="text" name="search" placeholder="Recherchez un profil">
              <button class="mini fa-solid fa-rotate-left" type="submit" name="reset"></button>
          </form>

            <?php foreach ($collab as $row_c) { ?>
              <div class="sidebar-element">
                  <p><?php echo htmlspecialchars($row_c['username']); ?></p>
                  <div class="info">
                    <form method="post">
                        <button class="fa-solid fa-circle-plus" type="submit" name="add" value="<?php echo htmlspecialchars($row_c['id_u']); ?>"></button>
                    </form>
                    <i class="fa-solid fa-phone-flip" onclick="call()"></i>
                  </div>
              </div>
              <?php } ?>
        </div>

        <!-- Settings sidebar -->
        <div id="mySidebar2" class="sidebar">
          <a href="javascript:void(0)" class="closebtn" onclick="closeNav(2)"><i class="fa-solid fa-square-xmark"></i></a>

          <h2 style="margin: 10px;">Settings</h2>
          <div class="sidebar-padding">
            <b><p><p style="font-size: 20px;"><?php echo $_SESSION['name']; ?></p></p></b>
            <div>
                <?php require('./API/projectAssignation.php');
                foreach ($project_assigned_to as $ass){ ?>
                    <button style="margin-top: 5px"><?php echo htmlspecialchars($ass['username']); ?></button>
                <?php } ?>
            </div><br>
            <form method="post">
                <label for="name">Changer nom du projet</label><br>
                <div class="mini-bar">
                    <input class="mini" type="text" name="name" placeholder=" ..." required>
                    <button class="mini fa-solid fa-check" type="submit" name="changeName"></button>
                </div>
            </form>
            <hr>

              <b><p><?php echo $_SESSION['username']; ?></p>
              <p><?php echo $_SESSION['email']; ?></p></b>
              
              <form method="post">
                <label for="name">Changer nom utilisateur</label><br>
                <div class="mini-bar">
                    <input class="mini" type="text" name="username" placeholder=" ..." required>
                    <button class="mini fa-solid fa-check" type="submit" name="changeUsername"></button>
                </div>
              </form><br><br>
              
                <p style="margin: 5px;"><i class="fa-regular fa-envelope"></i>  Changer email</p>
                <p style="margin: 5px;"><i class="fa-solid fa-lock"></i>  Changer le mot de passe</p>

              <br><br><br>
              <form method="post">
                  <button type="submit" name="deleteFromProject" style="margin-bottom: 5px;">Se retirer du projet</button>
                  <button type="submit" name="deleteProject">Supprimer le projet</button>
              </form>
            </div>
        </div>

        <div class="body row">
            <!-- AFFICHAGE DES ELEMENTS DU PROJET -->
        <?php if($_SESSION['id_p']!=0): ?>
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
                    
                    <div class="info">
                        <?php if($row['a_rendre']!=null): ?>
                        <p>Date de rendu: <?php echo htmlspecialchars($row['a_rendre']); ?></p>
                        <?php endif ?>
                        <button class="ajout" value="<?php echo htmlspecialchars($row['id_u']); ?>"><?php echo htmlspecialchars($row['username']); ?></button>
                    </div><br>

                    <!-- si demande de modification, le formulaire se place dans l'lelement -->
                    <?php if(isset($_POST['modify']) && $row['id_t']==$_POST['modify']):
                        $_SESSION['id_t']=$_POST['modify'];?>

                        <form method="post" class="mini-bar">
                            <input class="mini" type="text" name="modifyD" placeholder="décrivez la tâche..." required><br>
                            <?php echo $_POST['modifyD'];?>
                            <button class="mini fa-solid fa-arrow-right"  type="submit" name="modifyDescription"></button>
                        </form>

                        <?php if(isset($_POST['modifyDescription'])){
                            require('./API/modifyTask.php');
                        }?>
                        
                        <br><!--
                        <form method="post">
                            <select id="status" name="status" required>
                                <option value="1">A Faire</option>
                                <option value="2">En Cours</option>
                                <option value="3">Terminé</option>
                            </select><br>
                            <button class="fa-solid fa-arrow-right"  type="submit" name="modifyStatus"></button>
                        </form>
                        <form method="post">
                            <label>A rendre pour:</label>
                            <input type="date" id="date" name="date" class="date" required><br>
                            <button class="fa-solid fa-arrow-right" type="submit" name="modifyARendre"></button>
                        </form>-->
                    <?php endif ?>

                    <div class="row file">
                        <div class="col-sm-1">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="col-sm-1 file-left">
                            <i class="fa-regular fa-file"></i>
                        </div>
                    </div>
                    
                </div>
                <?php } ?>
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
                    
                    <div class="info">
                        <?php if($row['a_rendre']!=null): ?>
                            <p>Date de rendu: <?php echo htmlspecialchars($row['a_rendre']); ?></p>
                        <?php endif ?>
                        <button class="ajout" value="<?php echo htmlspecialchars($row['id_u']); ?>"><?php echo htmlspecialchars($row['username']); ?></button>
                    </div><br>

                    <div class="row file">
                        <div class="col-sm-1">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="col-sm-1 file-middle">
                            <i class="fa-regular fa-file"></i>
                        </div>
                    </div>

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
                    
                    <div class="info">
                        <?php if($row['a_rendre']!=null): ?>
                            <p>Date de rendu: <?php echo htmlspecialchars($row['a_rendre']); ?></p>
                        <?php endif ?>
                        <button class="ajout" value="<?php echo htmlspecialchars($row['id_u']); ?>"><?php echo htmlspecialchars($row['username']); ?></button>
                    </div><br>

                    <div class="row file">
                        <div class="col-sm-1">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="col-sm-1 file-right">
                            <i class="fa-regular fa-file"></i>
                        </div>
                    </div>

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
        </div>
    </body>

    <script type="text/javascript">
        /*window.addEventListener('keydown',function(e) {
            if (e.keyIdentifier=='U+000A' || e.keyIdentifier=='Enter' || e.keyCode==13) {
                if (e.target.tagName=='INPUT' && e.target.type=='text') {
                    e.preventDefault();

                    return false;
                }
            }
        }, true);*/

        function openNav(num) {
            if(num==1){
                document.getElementById("mySidebar").style.width = "250px";
                document.getElementById("main").style.marginLeft = "250px";
            }
            else if(num==2){
                document.getElementById("mySidebar2").style.width = "250px";
                document.getElementById("main").style.marginLeft = "250px";
            }
          
        }

        function closeNav(num) {
            if(num==1){
                document.getElementById("mySidebar").style.width = "0";
                document.getElementById("main").style.marginLeft= "0";
            }
            else if(num==2){
                document.getElementById("mySidebar2").style.width = "0";
                document.getElementById("main").style.marginLeft= "0";
            }
        }

        function call(){
            location.href = 'https://www.microsoft.com/fr-fr/microsoft-teams/log-in';
        }

        function redirect(){
            location.href = 'collab_accueil.html'; // Redirection vers la prochaine étape du jeu
        }
    </script>
</html>