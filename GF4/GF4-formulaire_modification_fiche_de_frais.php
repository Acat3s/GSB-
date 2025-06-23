<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier une nouvelle fiche de frais</title>
</head>
<body>
    <?php
    ini_set('display_errors', 1);
    include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

    session_start();
        
    //Recuperation de l'id du visiteur, du mois et de l'annee de la fiche a modifier
    $idvis=$_POST['id'];
    $mois=$_POST['mois'];
    $annee=$_POST['annee'];

    //Connexion a la base de donnees
    $cnxBDD=connexion();

    //Recherche de l'identifiant de la fiche de frais
    $sql="SELECT id FROM FicheFrais WHERE idVisiteur='$idvis' AND mois=$mois AND annee=$annee";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row=mysqli_fetch_assoc($result);
    $idFicheFrais=$row['id'];

    //Recherche des frais enregistrees sur la fiche
    //Recuperation de la quantite de frais de repas
    $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='REP'";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row=mysqli_fetch_assoc($result);
    $nbREP=$row['quantite'];

    //Recuperation de la quantite de frais de nuit
    $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='NUI'";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row=mysqli_fetch_assoc($result);
    $nbNUI=$row['quantite'];

    //Recuperation de la quantite de frais d'etape
    $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='ETP'";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row=mysqli_fetch_assoc($result);
    $nbETP=$row['quantite'];

    //Recuperation de la quantite de frais de kilometrage
    $sql="SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='KM'";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row=mysqli_fetch_assoc($result);
    $nbKM=$row['quantite'];

    //Récupération du nombre de justificatifs enregistrés
    $sql="SELECT nbJustificatifs FROM FicheFrais WHERE id=$idFicheFrais;";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    //Récupération de la valeur dans une variable
    $row=mysqli_fetch_assoc($result);
    $nbJustif=$row['nbJustificatifs'];

    //Deconnexion de la base de donnee
    $cnxBDD->close();

    //Recuperation de la variable $idFicheFrais dans une variable de session
    $_SESSION['idFicheFrais']=$idFicheFrais;
    ?>
    <div style='display: flex; line-height: 25px'>
        <div style='width: 90%'>
            <h1 style='color: #79A8D3'>Gestion des Frais</h1>
        </div>
        <div style='width: 10%'>
            <img src="../image/logo_GSB.png" width="100">
        </div>    
    </div>
    <div style='background-color: #79A8D3'>
        <h1 style='color: white'>Modification</h1>
        <form action="GF4-traitement_fiche_de_frais.php" method="post">
            <div style="display: flex; align-items: center; justify-content: flex-start;">
                <div>
                    <p style="color: white">PÉRIODE D'ENGAGEMENT :</p>
                </div>
                <div style="padding: 20px">
                    <label style="color: white" for="annee_disable">Année : </label>
                    <input type="text" id="annee_disable" name="annee_disable" value="<?php echo $annee;?>" disabled="disabled" size="2" />
                    <label style="color: white" for="mois_disable">Mois : </label>
                    <input type="text" id="mois_disable" name="mois_disable" value="<?php echo $mois;?>" disabled="disabled" size="2" />
                </div>
            </div>
            <!-- Champs cachés pour envoyer les valeurs -->
            <input type="hidden" name="type" value="modification" />
            <br>
            <br>
            <h3 style='color: white'>Frais au Forfait</h3>
            <div style='display: flex; line-height: 25px'>
                <div style='padding: 20px'>
                    <label style='color: white' for="Txtrepas">Repas midi : </label><br>
                    <label style='color: white' for="Txtnuitee">Nuitée : </label><br>
                    <label style='color: white' for="TxtEtape">Étape : </label><br>
                    <label style='color: white' for="TxtKm">Km : </label><br>
                    <label style='color: white' for="TxtNbJustif">Nombre de Justificatifs : </label><br>
                </div>
                <div style='padding: 20px'>
                    <input type="number" id="Txtrepas" name="Txtrepas" min="0" style="width: 50px" value=<?php echo $nbREP;?> /><br>
                    <input type="number" id="Txtnuitee" name="Txtnuitee" min="0" style="width: 50px" value=<?php echo $nbNUI;?> /><br>
                    <input type="number" id="Txtetape" name="Txtetape" min="0" style="width: 50px" value=<?php echo $nbETP;?> /><br>
                    <input type="number" id="TxtKm" name="TxtKm" min="0" style="width: 50px" value=<?php echo $nbKM;?> /><br>
                    <input type="number" id="TxtNbJustif" name="TxtNbJustif" min="0" style="width: 50px" value=<?php echo $nbJustif;?> /><br>
                </div>
            </div>
            <div>
                <input type="submit" id="soumettre" name="soumettre" style='display: block; margin: 0 auto' value="Soumettre la saisie" />
            </div>
            <br>
        </form>
        <div style="display: flex; justify-content: center;">
            <button onclick="window.history.back();">Retour</button>
        </div>
    </div>
</body>
</html>
