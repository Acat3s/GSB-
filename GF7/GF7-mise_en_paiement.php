<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise en paiement</title>
</head>
<body>
    <div style='display: flex; line-height: 25px'>
        <div style='width: 90%'>
            <h1 style='color: rgb(248, 143, 44)'>Mise en paiement</h1>
        </div>
        <div style='width: 10%'>
            <img src="../image/logo_GSB.png" width="100">
        </div>
    </div>
    <?php
    ini_set('display_errors', 1);
    include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

    session_start();

    //Connexion a la base de donnee
    $cnxBDD = connexion();

    $sql="UPDATE FicheFrais SET idEtat = 'RB' WHERE idEtat = 'VA';";
    $result=$cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

    if($result==true){
        echo "Mise en paiement effectué avec succès !";
    } else {
        echo "Échec de la mise en paiement, veuillez réessayer.";
    }

    //Déconnexion de la base de données
    $cnxBDD->close();

    //Script qui redirige vers l'écran d'accueil après 5 secondes
    echo "<script>
        setTimeout(function() {
            window.location.href = '../GF6/GF6-accueil_comptable.php';
        }, 5000);
    </script>";
    echo "<p>Votre action a été enregistrée. Redirection dans 5 secondes...</p>";
    ?>
</body>
</html>