<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

//Debut de la session
session_start();

$cnxBDD=connexion();

//Recuperation des variables de connexion
$idconn = $_GET['login'];
$passwdconn = $_GET['password'];

//Requete qui test si le login et le mot de passe sont présents dans la table Utilisateur
$sql = "SELECT id, roleUtilisateur FROM Utilisateur WHERE login='$idconn' AND password='$passwdconn'";
$result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

if($result->num_rows > 0){
    $row=mysqli_fetch_assoc($result);
    $role=$row['roleUtilisateur'];
    // Switch en fonction du role de l'utilisateur
    switch($role){
        case "V":
            // Affectation de l'id et du login à la variable de session
            $_SESSION['id_visiteur']=$row['id'];
            $_SESSION['username_visiteur']=$idconn;
            // Redirection vers la page d'accueil visiteur
            header('Location: ../GF3/affichageFichesFrais.php');
            exit;
        case "C":
            // Affectation de l'id et du login à la variable de session
            $_SESSION['id_comptable']=$row['id'];
            $_SESSION['username_comptable']=$idconn;
            // Redirection vers la page d'accueil comptable
            header('Location: ../GF6/GF6-accueil_comptable.php');
            exit;
        case "A":
            // Affectation de l'id et du login à la variable de session
            $_SESSION['id_admin']=$row['id'];
            $_SESSION['username_admin']=$idconn;
            // Redirection vers la page d'accueil admin
            header('Location: ../GF1/admin_liste_visiteurs.php');
            exit;
        default:
            header('Location: login.php');
            exit;
        }
} else {
    header('Location: erreur_login.php');
    die("Échec de la connexion.");
}

$cnxBDD->close();