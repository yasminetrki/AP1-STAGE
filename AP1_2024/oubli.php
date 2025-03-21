<?php
include '_conf.php';

function genererMotDePasse($longueur) {
    // Ensemble des caract�res utilisables pour le mot de passe
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    // Initialisation du mot de passe
    $motDePasse = '';
    // Taille totale du jeu de caract�res
    $tailleCaracteres = strlen($caracteres);
    // Boucle pour générer chaque caractère aléatoire
    for ($i = 0; $i < $longueur; $i++) {
        $indexAleatoire = random_int(0, $tailleCaracteres - 1);
        $motDePasse .= $caracteres[$indexAleatoire];
    }
    return $motDePasse;
}


if (isset($_POST['envoi_perdu'])) 
{
        $email=$_POST["email"];
        $login=$_POST["login"];
        $connexion = mysqli_connect($serveurBDD,$userBDD,$mdpBDD,$nomBDD);
        $requete="SELECT * FROM utilisateur
                WHERE email='$email' AND login='$login'";
          $resultat = mysqli_query($connexion, $requete); // on ex�cute la requ�te dans la variable resultat
           $trouve=0; //initialisation d'une variable trouve � 0 qui servira pour voir si on a trouv� une ligne dans la requ�te
            while($donnees = mysqli_fetch_assoc($resultat)) // pour chaque ligne dans la requ�te je stock �a dans un tableau $donnees avec comme colonne le nom des champs de la requ�te SQL
              {
                $trouve=1; //si on rentre dans la boucle c'est qu'on a trouv� 
              }
            //**** fin SQL
            if($trouve==1)
            {
                $newmdp=genererMotDePasse(10);
                $newmdphash=md5($newmdp);
               $requete="UPDATE `utilisateur` SET `motdepasse` = '$newmdphash' 
                     WHERE email='$email' AND login='$login'"; 

              
                if(!mysqli_query($connexion,$requete)) 
                    {
                    echo "erreur";
                    }
                else //si possibilite de faire la requete :
                    {
                   echo "MISE A JOUR MDP";
                    }
                
            }
           
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
                <button class="btn-menu" onclick="window.location.href='index.php'">Connexion</button>
            </div>
        </nav>
    </header>

     <main>
        <section id="formulaire" class="form-container">
            <h2>Mot de passe oublié</h2>
            <form action="oubli.php" method="post">
                <div class="form-group">
                    <label>Email :</label>
                    <input type="email" name="email" placeholder="Entrez votre email" value="<?php if (isset($email)) echo $email;?>" required>
                </div>
                     <div class="form-group">
                    <label>Login :</label>
                    <input type="text" name="login" placeholder="Entrez votre login"  value="<?php if (isset($login)) echo $login;?>" required>
                </div>

                <button type="submit" class="btn-submit" name="envoi_perdu" value="1">Envoyer pour recevoir un nouveau mot de passe par email</button>
                <?php 
                if (isset($trouve)) 
                {
                    if($trouve==0)
                    {
                        echo "<br>ERREUR email/login non trouve";
                    }
                    else {

                        $destinataire = "$email"; // Adresse du destinataire
                        $sujet = "Site CR STAGE : nouveau mot de passe"; // Sujet de l'e-mail
                        $message = "Bonjour, voici votre nouveau mot de passe sur le site des CR de stage : $newmdp"; // Corps de l'e-mail
                     
                        // Envoi de l'e-mail
                        if(mail($destinataire, $sujet, $message)) {
                            echo "L'e-mail a ete envoye avec succes.";
                        } else {
                            echo "Echec de l'envoi de l'e-mail.";
                          }
                    }
                }
                ?>
            </form>
        </section>
    </main>
</body>
</html>