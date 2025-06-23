<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

// Vérifier si le paramètre idvis est passé via la requête GET
if (isset($_POST['idvis'])) {
    $idvis = $_POST['idvis'];  // Récupérer la valeur de idvis passée par AJAX

    //Connexion à la base de données
    $cnxBDD = connexion();

    // Exécuter une requête pour récupérer les années des fiches de frais associées à ce visiteur
    $sql = "SELECT annee FROM FicheFrais WHERE idVisiteur IN (SELECT id FROM Utilisateur WHERE login='$idvis') AND idEtat='CL';";
    $result = $cnxBDD->query($sql) or die("Erreur de requête : " . $cnxBDD->error);

    //Déclaration d'un tableau pour accueillir la liste des mois présents cette année-là
    $anneepresente=array();

    // Parcourir les années récupérées pour établir les plages
    while($row = $result->fetch_assoc()) {
        $annee = $row['annee'];
        $anneepresente[]=$annee;
    }

    //Appel de la fonction pour trier le tableau
    sort($anneepresente);

    //Appel de la fonction pour supprimer les doublons d'un tableau
    $anneepresente=array_unique($anneepresente);

    //Générer une option vide
    echo"<option value='' hidden></option>";
    
    //Générer les options
    foreach ($anneepresente as $annee) {
        echo "<option value='$annee'>$annee</option>";
    }

    //Déconnexion de la base de données
    $cnxBDD->close();
}
?>