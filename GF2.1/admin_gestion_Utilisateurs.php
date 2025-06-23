<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

session_start();

// Connexion à la base de données
$cnxBDD = connexion();

// Initialisation des variables
$idUtilisateur = $nom = $prenom = $adresse = $ville = $codePostal = $dateEmbauche = $motDePasse = $roleUtilisateur = ''; 
$mode = 'ajouter'; // Par défaut, mode ajout

// Si modification, charger les données
if (isset($_GET['id'])) {
    $idUtilisateur = $_GET['id'];
    $sql = "SELECT * FROM Utilisateur WHERE id = '$idUtilisateur'";
    
    $result = mysqli_query($cnxBDD, $sql);

    if ($result) {
        $Utilisateur = mysqli_fetch_assoc($result);
    } else {
        echo "Erreur : " . mysqli_error($cnxBDD);
    }

    if ($Utilisateur) {
        $nom = $Utilisateur['nom'];
        $prenom = $Utilisateur['prenom'];
        $adresse = $Utilisateur['adresse'];
        $codePostal = $Utilisateur['cp'];
        $ville = $Utilisateur['ville'];
        $dateEmbauche = $Utilisateur['dateEmbauche'];
        $motDePasse = $Utilisateur['password'];
        $roleUtilisateur = $Utilisateur['id_Role'];
        $mode = 'modifier';
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUtilisateur = $_POST['idUtilisateur'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $codePostal = $_POST['cp'] ?? '';
    $dateEmbauche = $_POST['dateEmbauche'] ?? '';
    $motDePasse = $_POST['password'] ?? '';
    $roleUtilisateur = $_POST['id_Role'] ?? '';
    $login = substr(strtoupper($prenom), 0, 1) . strtoupper($nom);

    if ($mode === 'ajouter') {
        $sql = "INSERT INTO Utilisateur (nom, prenom, adresse, ville, cp, dateEmbauche, password, roleUtilisateur, login) 
                VALUES ('$nom', '$prenom', '$adresse', '$ville', '$codePostal', '$dateEmbauche', MD5('$motDePasse'), '$roleUtilisateur', '$login')";

        $result = mysqli_query($cnxBDD, $sql);

        if (!$result) {
            echo "Erreur d'insertion : " . mysqli_error($cnxBDD);
        }
    } elseif ($mode === 'modifier') {
        $sql = "UPDATE Utilisateur 
                SET nom = '$nom', prenom = '$prenom', adresse = '$adresse', ville = '$ville', cp = '$codePostal', 
                    dateEmbauche = '$dateEmbauche', password = '$motDePasse', roleUtilisateur = '$roleUtilisateur', login = '$login' 
                WHERE id = '$idUtilisateur'";
                
        $result = mysqli_query($cnxBDD, $sql);

        if (!$result) {
            echo "Erreur de mise à jour : " . mysqli_error($cnxBDD);
        }
    }

    header('Location: admin_liste_visiteurs.php');
    exit;
}

// Réinitialisation des champs
if (isset($_POST['reset'])) {
    $idUtilisateur = $nom = $prenom = $adresse = $ville = $codePostal = $dateEmbauche = $motDePasse = '';
    $mode = 'ajouter';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des visiteurs</title>
   <!-- <link rel="stylesheet" href="../styles.css"> -->
</head>
<body>

    <h1>Gestion des visiteurs</h1>
    
    <form method="post" action="">
        <input type="hidden" name="idUtilisateur" value="<?= htmlspecialchars($idVisiteur, ENT_QUOTES, 'UTF-8') ?>">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($adresse, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($ville, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="codePostal">Code postal :</label>
        <input type="text" id="cp" name="cp" value="<?= htmlspecialchars($codePostal, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="dateEmbauche">Date dembauche :</label>
        <input type="date" id="dateEmbauche" name="dateEmbauche" value="<?= htmlspecialchars($dateEmbauche, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="motDePasse">Mot de passe :</label>
        <input type="password" id="password" name="password" value="" required><br>
        
        <label for="roleUtilisateur">Role Utilisateur :</label>
        <select name="id_Role" id="id_Role">
            <option value="A">Admin</option>
            <option value="C">Comptable</option>
            <option value="V">Visiteur</option>
        </select>
        <button type="submit" name="ajouter">ajouter</button>
        <button type="submit" name="reset">Réinitialiser</button>
    </form>
</body>
</html>
