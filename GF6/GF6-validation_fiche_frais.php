<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation fiche de frais</title>
</head>
<body>
    <div style='display: flex; line-height: 25px'>
        <div style='width: 90%'>
            <h1 style='color: rgb(248, 143, 44)'>Validation de la fiche de frais</h1>
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

    //Actualisation dans la base de données
    if(isset($_POST['situation'])){
        $idFicheFrais = $_POST['idFicheFrais'];
        if($_POST['situation']==="valide"){
            $sql="UPDATE FicheFrais SET idEtat='VA' WHERE id=$idFicheFrais;";
        }else{
            $sql="UPDATE FicheFrais SET idEtat='CR' WHERE id=$idFicheFrais;";
        }
        $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

        if ($cnxBDD->query($sql) == TRUE) {
            echo "Mise à jour de l'état de la fiche de frais effectuée avec succès.<br>";
        } else {
            echo "Erreur lors de la mise à jour de la fiche de frais. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
        }
    }

    //Script qui redirige vers l'écran d'accueil après 5 secondes
    echo "<script>
    setTimeout(function() {
        window.location.href = 'GF6-selection_fiche_de_frais.php';
    }, 5000);
    </script>";
    echo "<p>Votre validation a été enregistrée. Redirection dans 5 secondes...</p>";
    ?>
</body>
</html>