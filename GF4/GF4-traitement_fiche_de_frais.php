<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

// Fonction pour récupérer les montants des forfaits dans la base de données
function recup_forfait($type_forfait){
    $cnxBDD=connexion();
    // Requête sql qui récupère le montant du forfait
    $sql="SELECT montant FROM Forfait WHERE id='$type_forfait';";
    // Exécution de la requête
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));
    // Récupération des résultats dans un tableau mysql
    $row=mysqli_fetch_assoc($result);
    // Récupération du montant dans la variable forfait
    $forfait=$row['montant'];
    // Retourne la valeur du forfait
    return $forfait;
}

// Fonction qui calcule le montant des remboursements pour un frais
function calcul_frais($nb, $forfait){
    // Calcul du remboursement 
    $montant=$nb*$forfait;
    return $montant;
}

// Fonction qui calcule le remboursement total
function calcul_remboursement($frais1, $frais2, $frais3, $frais4){
    // Calcul du remboursement
    $remboursement=$frais1+$frais2+$frais3+$frais4;
    return $remboursement;
}

function insert_frais($idNouvelleFiche, $idforfait, $nb){
    $cnxBDD=connexion();
    $sql="INSERT INTO LigneFraisForfait VALUES ($idNouvelleFiche, '$idforfait', $nb);";
    if ($cnxBDD->query($sql) == TRUE) {
        return true;
    } else {
        return false;
    }
}

function update_frais($idFicheFrais, $idforfait, $nb){
    $cnxBDD=connexion();
    $sql="UPDATE LigneFraisForfait SET quantite=$nb WHERE idFicheFrais='$idFicheFrais' AND idForfait='$idforfait';";
    if($cnxBDD->query($sql) == TRUE){
        return true;
    } else {
        return false;
    }
}

// Début de la session
session_start();

// Affichage de l'entête et récupération des valeurs en fonction du type d'action à réaliser
if($_POST['type']=="creation"){
    include 'entete_nouvelle.html';
    //Recuperation de l'id du visiteur dans la variable
    $idvis=$_SESSION['id_visiteur'];
    $annee=$_POST['annee'];
    $mois=$_POST['mois'];
}else{
    include 'entete_modification.html';
    //Recuperation de l'identifiant de la fiche
    $idFicheFrais=$_SESSION['idFicheFrais'];
}

//Connexion a la base de donnees
$cnxBDD=connexion();

//Recuperation des valeurs du formulaire dans les variables
$nbREP=$_POST['Txtrepas'];
$nbNUI=$_POST['Txtnuitee'];
$nbETP=$_POST['Txtetape'];
$nbKM=$_POST['TxtKm'];
$nbJustif=$_POST['TxtNbJustif'];

//Recuperation de la date du jour pour l'enregistrer en tant que derniere date de modification
$datemodif=date('Y-m-d');

//Recuperation des montants des forfaits
$forfaitETP=recup_forfait("ETP");
$forfaitKM=recup_forfait("KM");
$forfaitNUI=recup_forfait("NUI");
$forfaitREP=recup_forfait("REP");

//Calcul du remboursement
$remb=calcul_remboursement(calcul_frais($nbETP, $forfaitETP), calcul_frais($nbKM, $forfaitKM), calcul_frais($nbNUI, $forfaitNUI), calcul_frais($nbREP, $forfaitREP));

//Insertion des données dans la base de données s'il s'agit d'une création d'une fiche de frais
if($_POST['type']=="creation"){
    //Insertion des valeurs dans la table FicheFrais
    $sql="INSERT INTO FicheFrais(idVisiteur, mois, annee, nbJustificatifs, montantValide, dateModif, idEtat) VALUES ('$idvis', $mois, $annee, $nbJustif, $remb, '$datemodif', 'CR');";

    if($cnxBDD->query($sql) == TRUE){
        echo "Création de la nouvelle fiche de frais dans la table FicheFrais validée.<br>";
    }else{
        echo "Erreur lors de l'insertion dans la table FicheFrais. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Recuperation de l'id de la nouvelle fiche creee
    $sql="SELECT id FROM FicheFrais WHERE idVisiteur='$idvis' AND mois=$mois AND annee=$annee;";
    $lignes=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));
    //Récupération des résultats dans un tableau SQL
    $row=mysqli_fetch_assoc($lignes);
    //Récupération de l'identifiant
    $idNouvelleFiche=$row['id'];

    //Insertion des frais REP dans la table LigneFraisForfait
    $sql=insert_frais($idNouvelleFiche, 'REP', $nbREP);
    if($sql){
        echo "Insertion des frais REP dans la table LigneFraisForfait validée.<br>";
    }else{
        echo "Erreur lors de l'insertion des frais REP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais NUI dans la tableau LigneFraisForfait
    $sql=insert_frais($idNouvelleFiche, 'NUI', $nbNUI);
    if($sql){
        echo "Insertion des frais NUI dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais NUI dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais ETP dans la tableau LigneFraisForfait
    $sql=insert_frais($idNouvelleFiche, 'ETP', $nbETP);
    if($sql){
        echo "Insertion des frais ETP dans la table LigneFraisForfait validée.<br>";
    }else{
        echo "Erreur lors de l'insertion des frais ETP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais KM dans la tableau LigneFraisForfait
    $sql=insert_frais($idNouvelleFiche, 'KM', $nbKM);
    if($sql){
        echo "Insertion des frais KM dans la table LigneFraisForfait validée.<br>";
    }else{
        echo "Erreur lors de l'insertion des frais KM dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }
//Sinon, on met à jour les données
}else{
    //Mise à jour des valeurs dans la table FicheFrais
    $sql = "UPDATE FicheFrais SET nbJustificatifs=$nbJustif, montantValide=$remb, dateModif='$datemodif' WHERE id=$idFicheFrais";
    if ($cnxBDD->query($sql) == TRUE) {
        echo "Mise à jour de la fiche de frais dans la table Fiche Frais validée.<br>";
    } else {
        echo "Erreur lors de l'insertion dans la table FicheFrais. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Mise à jour des frais REP dans la table LigneFraisForfait
    $sql=update_frais($idFicheFrais, 'REP', $nbREP);
    if($sql){
        echo "Mise à jour des frais REP dans la table LigneFraisForfait validée.<br>";
    }else{
        echo "Erreur lors de la mise à jour des frais REP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Mise à jour des frais NUI dans la tableau LigneFraisForfait
    $sql=update_frais($idFicheFrais, 'NUI', $nbNUI);
    if($sql){
        echo "Mise à jour des frais NUI dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de la mise à jour des frais NUI dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais ETP dans la tableau LigneFraisForfait
    $sql=update_frais($idFicheFrais, 'ETP', $nbETP);
    if($sql){
        echo "Mise à jour des frais ETP dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de la mise à jour des frais ETP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais KM dans la tableau LigneFraisForfait
    $sql=update_frais($idFicheFrais, 'KM', $nbKM);
    if($sql){
        echo "Mise à jour des frais KM dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de la mise à jour des frais KM dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }
}

//Deconnexion de la base de donnee
$cnxBDD->close();

//Script qui redirige vers l'écran d'accueil après 5 secondes
echo "<script>
    setTimeout(function() {
        window.location.href = '../GF3/affichageFichesFrais.php';
    }, 5000);
</script>";
echo "<p>Votre validation a été enregistrée. Redirection dans 5 secondes...</p>";

?>