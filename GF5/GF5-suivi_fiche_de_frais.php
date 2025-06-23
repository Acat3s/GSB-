<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Suivi d'une fiche de frais</title>
        <style>
            table {
                border: 2px solid white; /* Définir la bordure du tableau */
                border-collapse: collapse; /* Fusionne les bordures pour éviter les espaces */
                color: white;
            }
            td {
                width: 100px; /* Largeur de la cellule */
                height: 40px; /* Hauteur de la cellule */
                border: 1px solid white; /* Bordure autour des cellules */
                padding: 2px; /* Espace à l'intérieur de la cellule */
                text-align: center; /* Centre le texte horizontalement */
            }
            h1 {
            display: inline; /* Empêche le saut de ligne */
            margin: 0; /* Supprime les marges par défaut */
            }
        </style>
    </head>
    <body>
        <?php
            ini_set('display_errors', 1);
            include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

            //Début de la session
            session_start();

            //Récupération des variables
            $idvis=$_SESSION['id_visiteur'];
            $username_visiteur=$_SESSION['username_visiteur'];
            $mois=$_POST['mois'];
            $annee=$_POST['annee'];

            //Connexion à la base de données pour récupérer les variables
            $cnxBDD=connexion();

            //Requête SQL pour récupérer les valeurs nécessaires de la fiche de frais dans la table FicheFrais
            $sql="SELECT id, montantValide, dateModif, idEtat FROM FicheFrais WHERE idVisiteur=$idvis AND mois=$mois AND annee=$annee;";
            $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

            //Récupération des valeurs dans les variables
            foreach($result as $row){
                $idFicheFrais=$row['id']; //Id de la fiche de frais
                $remb=$row['montantValide']; //Montant du remboursement
                $dateope=$row['dateModif']; //Date de la dernière modification
                $idEtat=$row['idEtat']; //Id de l'état de la fiche de frais
            }
            
            //Requêtes SQL pour récupérer les valeurs nécessaires de la fiche de frais dans la table LigneFraisForfait
            //Requête SQL pour récupérer la quantité d'Étape(s) validée(s)
            $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='ETP';";
            $result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

            //Récupération du résultat dans une variable
            $row = mysqli_fetch_assoc($result);
            $etape = $row['quantite'];

            //Requête SQL pour récupérer la quantité de Kilomètre(s) validé(s)
            $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='KM';";
            $result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

            //Récupération du résultat dans une variable
            $row = mysqli_fetch_assoc($result);
            $km = $row['quantite'];

            //Requête SQL pour récupérer la quantité de Nuit(s) validée(s)
            $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='NUI';";
            $result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

            //Récupération du résultat dans une variable
            $row = mysqli_fetch_assoc($result);
            $nuitee = $row['quantite'];

            //Requête SQL pour récupérer la quantité de Repas validé(s)
            $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='REP';";
            $result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

            //Récupération du résultat dans une variable
            $row = mysqli_fetch_assoc($result);
            $repas = $row['quantite'];

            //Récupération de l'état de la fiche
            $sql="SELECT libelle FROM Etat WHERE id='$idEtat';";
            $result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

            //Récuépration du résultat dans une variable
            $row = mysqli_fetch_assoc($result);
            $situation = $row['libelle'];

            //Déconnexion de la base de données
            $cnxBDD->close();
        ?>
        <div style='display: flex; flex-direction: column; gap: 0;'>
            <div style='display: flex; line-height: 25px'>
                <div style='width: 90%'>
                    <h1 style='color: rgb(54, 144, 228)'>Suivi de remboursement des Frais</h1>
                </div>
                <div style='width: 10%'>
                    <img src="../image/logo_GSB.png" width="100">
                </div>
            </div>
            <div style='height: 50px; background-color:rgb(218, 233, 255); display: flex; align-items: center'>
                <p style='font-size: 25px; color:rgb(54, 144, 228)'>Fiche de frais de : <?php echo $username_visiteur; ?></p>
            </div>
            <div style='background-color: #79A8D3'>
                <h1 style='color: white; display: inline'>Période |</h1>
                <p style='color: white; display: inline'> Mois/Année : <?php echo $mois."/".$annee; ?></p>
                <p style='color: white; font-size: 20px; font-weight: bold'>Frais au Forfait</p>
                
                <!-- Affichage des informations de la fiche de frais -->
                <!-- Faire une récupération dynamique de tous les éléments du tableau -->
                <table>
                    <tr>
                        <td>Repas Midi</td>
                        <td>Nuitée</td>
                        <td>Étape</td>
                        <td>Km</td>
                        <td>Situation</td>
                        <td>Date Opération</td>
                        <td>Remboursement</td>
                    </tr>
                    <tr>
                        <td><?php echo $repas; ?></td>
                        <td><?php echo $nuitee; ?></td>
                        <td><?php echo $etape; ?></td>
                        <td><?php echo $km; ?></td>
                        <td><?php echo $situation; ?></td>
                        <td><?php echo $dateope; ?></td>
                        <td><?php echo $remb; ?></td>
                    </tr>
                </table>

                <!-- Bouton pour retourner à la page précédente -->
                <div style='display: flex; align-items: center; justify-content: center; padding: 10px'>
                    <button onclick="window.history.back();">Retour</button>
                </div>
            </div>
        </div>
    </body>
</html>