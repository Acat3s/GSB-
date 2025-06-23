<?php
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

// Activer l'affichage des erreurs pour d?boguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// admin_liste_visiteurs.php
session_start();

/* V?rifier si l'utilisateur est administrateur
if (!isset($_SESSION['username']) || $_SESSION['username'] !== "admin") {
    header('Location: ../login/login.php');
    exit;
}
*/

// cnxBDDexion ? la base de donn?es
$cnxBDD=connexion();

// R�cup�rer tous les visiteurs tri�s par nom, puis pr�nom
$sql = "SELECT * FROM Utilisateur ORDER BY nom, prenom";
$result = mysqli_query($cnxBDD, $sql);

if (!$result) {
    die("Erreur de r�cup�ration des Utilisateurs : " . mysqli_error($cnxBDD));
}

$visiteurs = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Gestion de la suppression d'un visiteur
if (isset($_GET['supprimer'])) {
    $idVisiteur = $_GET['supprimer'];

    $sql = "DELETE FROM Utilisateur WHERE idVisiteur = '$idVisiteur'";

    if (mysqli_query($cnxBDD, $sql)) {
        header('Location: admin_liste_Utilisateur.php');
        exit;
    } else {
        echo "Erreur lors de la suppression du visiteur : " . mysqli_error($cnxBDD);
    }
}

// Gestion de la cl�ture des fiches de frais
if (isset($_GET['cloturer'])) {
    $idVisiteur = $_GET['cloturer'];

    $sql = "UPDATE FicheFrais SET etat = 'Cl�tur�e' WHERE idVisiteur = '$idVisiteur' AND etat = 'En cours'";

    if (mysqli_query($cnxBDD, $sql)) {
        header('Location: admin_liste_Utilisateurs.php');
        exit;
    } else {
        echo "Erreur lors de la mise � jour des fiches de frais : " . mysqli_error($cnxBDD);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des visiteurs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Liste des visiteurs</h1>
    <a href="../GF2.1/admin_gestion_visiteurs.php" class="add-button">Ajouter un visiteur</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Pr�nom</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code postal</th>
                <th>Date d'embauche</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($visiteurs)) { ?>
                <tr>
                    <td colspan="8">Aucun visiteur trouv�.</td>
                </tr>
            <?php
            } else {
                foreach ($visiteurs as $visiteur) { ?>
                    <tr>
                        <td><?= htmlspecialchars($visiteur['id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['prenom'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['adresse'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['ville'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['cp'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['dateEmbauche'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="../GF2.1/admin_gestion_visiteurs.php?idVisiteur=<?= htmlspecialchars($visiteur['id'], ENT_QUOTES, 'UTF-8')?>">Modifier</a> |
                            <a href="?supprimer=<?= htmlspecialchars($visiteur['id'], ENT_QUOTES, 'UTF-8') ?>" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a> |
                            <a href="?cloturer=<?= htmlspecialchars($visiteur['id'], ENT_QUOTES, 'UTF-8') ?>" onclick="return confirm('Cl�turer toutes les fiches de frais en cours ?');">Cl�turer</a>
                        </td>
                    </tr>
                <?php
                }
            } 
            ?>
        </tbody>
    </table>
</body>
</html>
