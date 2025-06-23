<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Affichage de la fiche de frais</title>
        <style>
            table {
                border: 1px solid white; /* Définir la bordure du tableau */
                border-collapse: collapse; /* Fusionne les bordures pour éviter les espaces */
            }
            td {
                color: white; /* Couleur du texte */
                width: 100px; /* Largeur de la cellule */
                height: 40px; /* Hauteur de la cellule */
                border: 1px solid white; /* Bordure autour des cellules */
                padding: 2px; /* Espace à l'intérieur de la cellule */
                text-align: center; /* Centre le texte horizontalement */
            }
        </style>
    </head>
    <body>
        <div style='display: flex; line-height: 25px'>
            <div style='width: 90%'>
                <h1 style='color: rgb(248, 143, 44)'>Affichage de la fiche de frais</h1>
            </div>
            <div style='width: 10%'>
                <img src="../image/logo_GSB.png" width="100">
            </div>    
        </div>
        <?php
        ini_set('display_errors', 1);
        include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

        // Connexion à la base de données
        $cnxBDD=connexion();
        
        // Fonction pour récupérer les données de la fiche de frais
        function select_quantite($idFicheFrais, $forfait, $cnxBDD){
            $quantite = $cnxBDD->query(
                "SELECT quantite
                FROM LigneFraisForfait 
                WHERE idFicheFrais = $idFicheFrais AND idForfait = '$forfait'"
                )->fetch_assoc()['quantite'];

            return $quantite;
        }

        // Test si les 3 valeurs sont initialisées
        if(isset($_POST['nom']) && isset($_POST['annee']) && isset($_POST['mois'])){
            $idvis=$_POST['nom'];
            $annee=$_POST['annee'];
            $mois=$_POST['mois'];

            //Récupération de l'id de la fiche de frais
            $idFicheFrais=$cnxBDD->query(
                "SELECT id FROM FicheFrais 
                 WHERE idVisiteur IN (SELECT id FROM Utilisateur WHERE login ='$idvis') 
                 AND annee=$annee AND mois=$mois"
            )->fetch_assoc()['id'];

            //Récupération de la quantité d'Étape dans la base de données
            $etape=select_quantite($idFicheFrais, 'ETP', $cnxBDD);
            
            //Récupération de la quantité de Kilomètres dans la base de données
            $km=select_quantite($idFicheFrais, 'KM', $cnxBDD);

            //Récupération de la quantité de Nuitee dans la base de données
            $nuitee=select_quantite($idFicheFrais, 'NUI', $cnxBDD);

            //Récupération de la quantité de Repas dans la base de données
            $repas=select_quantite($idFicheFrais, 'REP', $cnxBDD);

            //Récupération de la quantité de Justificatifs dans la base de données
            $nbJustif=$cnxBDD->query(
                "SELECT nbJustificatifs
                FROM FicheFrais
                WHERE id=$idFicheFrais"
            )->fetch_assoc()['nbJustificatifs'];
        ?>
        <div style="background-color: rgb(248, 143, 44); display: flex; flex-direction: column; align-items: center;">
            <h1 style="color:white">Frais au forfait</h1>
            <!-- Affichage des informations de la fiche de frais -->
            <!-- Récupération dynamique des éléments du tableau -->
            <form method="POST" action="GF6-validation_fiche_frais.php">
                <input type="hidden" name="idFicheFrais" value="<?php echo $idFicheFrais; ?>" />
                <table>
                    <tr>
                        <td>Repas Midi</td>
                        <td>Nuitée</td>
                        <td>Étape</td>
                        <td>Km</td>
                        <td>Situation</td>
                    </tr>
                    <tr>
                        <td><?php echo $repas; ?></td>
                        <td><?php echo $nuitee; ?></td>
                        <td><?php echo $etape; ?></td>
                        <td><?php echo $km; ?></td>
                        <td>
                            <input type="radio" name="situation" value="valide"> Validé
                            <br>
                            <input type="radio" name="situation" value="nonvalide"> Non validé
                            <input type="hidden" name="idFicheFrais" value="<?php echo $idFicheFrais; ?>">
                        </td>
                    </tr>
                </table>
                <p style="color: white; text-align: center;">
                    Nb Justificatifs : <?php echo $nbJustif;?>
                </p>
                <div style="display: flex; justify-content: center; align-items: center">
                    <button type="submit">Soumettre la requête</button>
                </div>
            </form>
        <?php
        }
        ?>
        <button onclick="window.history.back();">Retour</button>
        </div>
    </body>
</html>