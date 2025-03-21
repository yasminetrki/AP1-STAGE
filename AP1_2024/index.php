<?php
session_start(); 
include '_conf.php';

      if (isset($_GET['deco']))
            {
              session_destroy();
              //detruit la session apres clique sur bouton deconnexion
              echo "deconnectee";
            } 
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Stages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menu de navigation -->
    <header>
        <nav class="menu">
            <div class="logo">Suivi Stages</div>
            <div class="menu-buttons">
                <button class="btn-menu" onclick="window.location.href='oubli.php'">Mot de passe oublié</button>
            </div>
        </nav>
    </header>

     <main>
        <section id="formulaire" class="form-container">
            <h2>Connexion</h2>
            <form action="accueil.php" method="post">
                <div class="form-group">
                    <label>Login :</label>
                    <input type="text" name="login" placeholder="Entrez votre login" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe :</label>
                    <input type="password" name="motdepasse" placeholder="Entrez votre login" name="envoi" required>
                </div>
                <button type="submit" class="btn-submit" name="envoi" value="1">Se connecter</button>
            </form>
        </section>
    </main>
</body>
</html>