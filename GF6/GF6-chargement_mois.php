<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

// Vérifier si le paramètre idvis est passé via la requête GET
if (isset($_POST['annee']) && isset($_POST['idvis'])) {
    $annee = $_POST['annee'];  // Récupérer la valeur de annee passée par AJAX
    $idvis = $_POST['idvis'];  // Récupérer la valeur de idvis passée par AJAX

    //Connexion à la base de données
    $cnxBDD = connexion();

    // Exécuter une requête pour récupérer les années des fiches de frais associées à ce visiteur
    $sql = "SELECT mois FROM FicheFrais WHERE idVisiteur IN (SELECT id FROM Utilisateur WHERE login='$idvis') AND annee='$annee' AND idEtat='CL';";
    $result = $cnxBDD->query($sql) or die("Erreur de requête : " . $cnxBDD->error);

    //Déclaration d'un tableau pour accueillir la liste des mois présents cette année-là
    $moispresent=array();

    // Parcourir les années récupérées pour établir les plages
    while($row = $result->fetch_assoc()) {
        $mois = $row['mois'];
        $moispresent[]=$mois;
    }

    //Tri du tableau
    sort($moispresent);

    //Générer une option vide
    echo"<option value='' hidden></option>";
    
    //Générer les options
    foreach ($moispresent as $mois) {
        echo "<option value='$mois'>$mois</option>";
    }

    //Déconnexion de la base de données
    $cnxBDD->close();
}
?>