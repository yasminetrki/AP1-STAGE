<?php
session_start(); 
include '_conf.php';
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

<?php

$serveurBDD="localhost";
$userBDD="root";
$mdpBDD="";
$nomBDD="ap1_2024";

// Si il y a une variable de formulaire POST 'envoi' (c'est le nom du bouton submit de la page d'index')
if (isset($_POST['envoi'])) 
{
    // Je récupère mes variables login et mdp envoyées par le formulaire POST de l'index
    $login = $_POST['login'];
    $mdp = $_POST['motdepasse'];

    // On prépare la connexion avec les variables mises dans le fichier conf
    $connexion = mysqli_connect($serveurBDD,$userBDD,$mdpBDD,$nomBDD);

    // Sélection de tous les champs de la table UTILISATEUR en faisant une restriction sur le login et mot de passe (md5)
    $requete="SELECT * FROM utilisateur WHERE login = '$login' AND motdepasse= '$mdp'";
    $resultat = mysqli_query($connexion, $requete);
    $trouve=0; // Initialisation d'une variable trouve à 0 qui servira pour voir si on a trouvé une ligne dans la requête

    while($donnees = mysqli_fetch_assoc($resultat)) // Pour chaque ligne dans la requête, je stocke ça dans un tableau $donnees
    {
        $trouve=1; // Si on rentre dans la boucle c'est qu'on a trouvé !
        $type=$donnees['type'];
        $login=$donnees['login'];
        $id=$donnees['num'];
        
        // Je crée mes sessions (variables qui restent d'une page à l'autre)
        $_SESSION["id"]=$id; 
        $_SESSION["login"]=$login;
        $_SESSION["type"]=$type;
    }

    if($trouve==0)
    {
        echo "Erreur de connexion : login/mdp non présent dans la BDD <br>";
        echo "<a href='index.php'>Retourner à l'index</a>";
    }
}

// Si il y a une valeur de session Login, cela signifie que la connexion est présente
if (isset($_SESSION["login"])) {
    if ($_SESSION["type"] == 0) { // Si c'est un élève (type == 0)
        include '_menuEleve.php';

        echo "<div style='text-align: center; font-size: 2.5em; font-weight: bold; margin-top: 50px;'>
                Bienvenue sur votre compte élève
              </div><br><br>";
        echo "<div style='text-align: center; font-size: 1.5em;'>Vous êtes connecté en tant que " . $_SESSION["login"] . "</div><br><br>";
    } else { // Si c'est un professeur
        include '_menuProf.php';

        echo "<h2 class='welcome-message'>Bienvenue sur votre espace professeur</h2>";

        // Ajout d'un tableau de bord
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Espace Professeur</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    background-color: #f4f4f4;
                    text-align: center;
                }
                .dashboard {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                    gap: 20px;
                    margin-top: 20px;
                }
                .card {
                    background: white;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                    width: 250px;
                    text-align: center;
                    transition: 0.3s;
                }
                .card:hover {
                    box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.2);s
                }
                .card a {
                    text-decoration: none;
                    color: #007bff;
                    font-weight: bold;
                }
                .welcome-message {
                    font-size: 2em;
                    color: #333;
                }
            </style>
        </head>
        <body>
        </body>
        </html>
        <?php
    }
}
?>
