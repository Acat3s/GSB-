<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

// affichageFichesFrais.php
session_start();

//Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_visiteur'])) {
    header('Location: login.php');
    exit;
}

// Connexion à la base de données
$cnxBDD=connexion();

// Récupérer les fiches de frais du visiteur connecté
$idVisiteur = $_SESSION['id_visiteur'];
$sql = "SELECT * FROM FicheFrais WHERE idVisiteur = '$idVisiteur' ORDER BY annee DESC, mois DESC";
$result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

if(!$result) {
    die("Erreur de récupération des fiches de frais : " . mysqli_error($cnxBDD));
}

$fiches = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Gestion de la déconnexion
if (isset($_GET['deconnexion'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vos fiches de frais</title>
    <style>
    .roundButton {
        background-color:rgb(41, 113, 247);
        color: black;
        font-size: 30px;
        width: 30px;
        height: 30px;
        border-radius: 50%;  /* Rend le bouton rond */
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
    }

    .roundButton:hover {
        background-color: rgb(41, 113, 247);
    }

    td, th {
        width: 150px;  /* Largeur de chaque cellule */
        border: 1px solid #ccc;  /* Bordure des cellules */
        padding: 8px;  /* Espacement intérieur */
        text-align: center;  /* Centrer le texte horizontalement */
        vertical-align: middle; /* Centrer le texte verticalement */
    }

</style>
</head>
<body>
    <div style='display: flex; line-height: 25px'>
        <div style='width: 90%'>
            <h1 style='color: #79A8D3'>Affichage des Fiches de Frais</h1>
        </div>
        <div style='width: 10%'>
            <img src="../image/logo_GSB.png" width="100">
        </div>    
    </div>
    <div style="height: 50px; background-color: rgb(218, 233, 255); display: flex; align-items: center;">
        <p style="font-size: 25px; color: rgb(54, 144, 228); margin-right: 20px;">Fiches de frais de : <?php echo $_SESSION['username_visiteur']; ?></p>
        <?php
        $testfiche = false;
        foreach($fiches as $fiche) {
            if ($fiche['mois'] == date("m") && $fiche['annee'] == date("Y")) {
                $testfiche = true;
                break;
            }
        }
        if (!$testfiche) {
        ?>
            <p style='font-size: 18px; color: black;'>Ajouter</p>
            <button class="roundButton" onclick="window.location.href='../GF4/GF4-formulaire_nouvelle_fiche_de_frais.php?id=<?= $idVisiteur ?>'">+<i class="fas fa-plus"></i></button>
        <?php
        }
        ?>
    </div>
    <?php
    if (empty($fiches)){
    ?>
        <br>
        <tr>
            <td colspan="4">Aucune fiche de frais trouvée.</td>
        </tr>
    <?php
    }else{
    ?>
        <table style='border-collapse: collapse;'>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant Total</th>
                    <th>État</th>
                    <th>Voir</th>
                    <th>Supprimer</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($fiches as $fiche){
                ?>
                    <tr>
                        <td><?= htmlspecialchars($fiche['mois'] . '/' . $fiche['annee'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= number_format($fiche['montantValide'], 2, ',', ' ') ?></td>
                        <td><?= htmlspecialchars($fiche['idEtat'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <form action="../GF5/GF5-suivi_fiche_de_frais.php" method="POST">
                                <input type="hidden" name="mois" value="<?= $fiche['mois'] ?>">
                                <input type="hidden" name="annee" value="<?= $fiche['annee'] ?>">
                                <button type="submit">Voir</button>
                            </form>
                        </td>
                        <?php
                        if($fiche['idEtat'] === 'CR'){
                        ?>
                            <td>
                                <form action="supprimer_fiche.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette fiche ?');">
                                    <input type="hidden" name="id" value="<?= $fiche['id'] ?>">
                                    <button type="submit">Supprimer</button>
                                </form>
                            </td>
                            <td>
                                <form action="../GF4/GF4-formulaire_modification_fiche_de_frais.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $fiche['idVisiteur'] ?>">
                                    <input type="hidden" name="mois" value="<?= $fiche['mois'] ?>">
                                    <input type="hidden" name="annee" value="<?= $fiche['annee'] ?>">
                                    <button type="submit">Modifier</button>
                                </form>
                            </td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    }
    ?>
    <br>
    <div style="display: flex; justify-content: center; align-items: center;">
        <button onclick="window.location.href='?deconnexion=true'">Se déconnecter</button>
    </div>
</body>
</html>
