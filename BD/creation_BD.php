<?php
ini_set('display_errors', 1);
include 'fonction_BD_GSB.php';

//Connexion a la base de donnees
$cnxBDD = connexion();

//Requete de creation de la table RoleUtilisateur
if ($cnxBDD->query(create_table_role()) === TRUE) {
    echo "Table 'RoleUtilisateur' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'RoleUtilisateur': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table Utilisateur
if ($cnxBDD->query(create_table_utilisateur()) === TRUE) {
    echo "Table 'Utilisateur' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'Visiteur': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table Forfait
if ($cnxBDD->query(create_table_forfait()) === TRUE) {
    echo "Table 'Forfait' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'Forfait': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table Etat
if ($cnxBDD->query(create_table_etat()) === TRUE) {
    echo "Table 'Etat' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'Etat': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table FicheFrais
if ($cnxBDD->query(create_table_fichefrais()) === TRUE) {
    echo "Table 'FicheFrais' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'FicheFrais': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table LigneFraisForfait
if ($cnxBDD->query(create_table_lignefraisforfait()) === TRUE) {
    echo "Table 'LigneFraisForfait' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'LigneFraisForfait': " . $cnxBDD->error . "<br>";
}
/*
//Requete de remplissage de la table Etat (à n'utiliser que pour l'initialisation de la BDD)
if ($cnxBDD->query(insert_into_etat()) === TRUE) {
    echo "Table 'Etat' remplie avec succès.<br>";
} else {
    echo "Erreur lors du remplissage de la table 'Etat': " . $cnxBDD->error . "<br>";
}

//Requete de remplissage de la table Forfait (à n'utiliser que pour l'initialisation de la BDD)
if ($cnxBDD->query(insert_into_forfait()) === TRUE) {
    echo "Table 'Forfait' remplie avec succès.<br>";
} else {
    echo "Erreur lors du remplissage de la table 'Forfait': " . $cnxBDD->error . "<br>";
}

//Requete de remplissage de la table RoleUtilisateur (à n'utiliser que pour l'initialisation de la BDD)
if ($cnxBDD->query(insert_into_role()) === TRUE) {
    echo "Table 'RoleUtilisateur' remplie avec succès.<br>";
} else {
    echo "Erreur lors du remplissage de la table 'RoleUtilisateur': " . $cnxBDD->error . "<br>";
}
*/
//Deconnexion de la base de donnee
$cnxBDD->close();


?>