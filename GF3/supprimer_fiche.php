<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression Fiche de Frais</title>
</head>
<body>
    <div style='display: flex; line-height: 25px'>
        <div style='width: 90%'>
            <h1 style='color: #79A8D3'>Suppression d'une Fiches de Frais</h1>
        </div>
        <div style='width: 10%'>
            <img src="../image/logo_GSB.png" width="100">
        </div>    
    </div>
    <?php
    ini_set('display_errors', 1);
    include '../BD/fonction_BD_GSB.php';

    // Démarrage de la session
    session_start();

    // Connexion à la base de données
    $cnxBDD=connexion();

    // Récupération de l'id de la fiche à supprimer
    $idfiche=$_POST['id'];

    // Requête pour supprimer la fiche de frais
    $sql="DELETE FROM FicheFrais WHERE id='$idfiche'";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    if($result){
        echo "Suppression réussie.";
    } else {
        echo "Échec de la suppression.";
    }

    // Déconnexion de la base
    $cnxBDD->close();

    echo "<script>
        setTimeout(function() {
            window.location.href = '../GF3/affichageFichesFrais.php';
        }, 5000);
    </script>";
    echo "<p>Votre suppression a été enregistrée. Redirection dans 5 secondes...</p>";
    ?>
</body>
</html>