<?php
    session_start();

    $serveur="localhost";
    $dbname="db_collab";
    $user="root";
    $password="0000";

    try{
        $connexion =new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = $connexion->prepare("SELECT DISTINCT projects.name as name, projects.created_by as created_by, projects.updated_at as updated_at FROM users,projects,assignation WHERE users.id_u=assignation.id_u AND assignation.id_p=projects.id_p AND users.email='".$_SESSION['email']."' ORDER BY projects.updated_at;'");
        $requete->execute();
    }
    catch(PDOException $e){
        echo "<script>alert('Erreur de connexion a la base de données!');</script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Menu</title>
        <!--Stylesheet CSS-->
            <link rel="stylesheet" type="text/css" href="collab_menu.css">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Helvetica Neue:wght@400;700&display=swap" rel="stylesheet">

    </head>
    <body>
        <header class="fixed">
            <img src="logo/6.png">
            <button onclick="redirect()">Déconnexion</button>
        </header>

        <br><br><br><br>

        <div class="body">
            <section id="left-container">
                <button class="inner">
                    <?php foreach($requete as $row){ ?>
                    <div class="element">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p>Créé par <?php echo htmlspecialchars($row['created_by']); ?></p>
                        <p>Dernière modification: <?php echo htmlspecialchars($row['updated_at']); ?></p>
                    </div>
                    <?php } ?>
                </button>
            </section>

            <section id="top-container">
                <b><div class="title"><h1>Mes Collaborateurs</h1></div></b>
                <div class="inner">
                    <div class="element">
                        <p>Nom</p>
                    </div>
                    <div class="element">
                        <p>Nom</p>
                    </div>
                </div>
            </section>

            <section id="middle-container">
                <img src="logo/10.png">
            </section>

            <section id="right-container">
                <div class="title"><h1>Gerer mon compte</h1></div>
                <div class="inner parameter-container">
                    <div class="left">
                        <img src="logo/11.png">
                    </div>
                    <div class="right">
                        <p>Email: <?php echo $_SESSION["email"]; ?></p>
                        <input type="submit" class="button" value="Changer mot de passe"><br>
                    </div>
                </div>
            </section>

            <section id="bottom-container">
                <div class="inner">
                </div>
            </section>
        </div>
    </body>

    <script type="text/javascript">
        function redirect(){
            location.href = 'collab_accueil.html'; // Redirection vers la prochaine étape du jeu
        }
    </script>
</html>