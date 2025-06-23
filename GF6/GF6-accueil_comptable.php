<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil Comptable</title>
    <style>
        /* Styles pour centrer les éléments sur la page */
        .container {
            display: flex;
            flex-direction: column; /* Disposer les éléments verticalement */
            justify-content: center;
            align-items: center;
            gap: 20px; /* Espace entre les boutons */
            background-color: rgb(248, 143, 44); /* Fond pour la zone des boutons */
            padding: 20px;
            border-radius: 10px;
        }

        .button {
            width: 250px; /* Largeur des boutons */
            height: 60px; /* Hauteur des boutons */
            background-color: rgb(248, 143, 44); /* Couleur de fond */
            border: 2px solid white; /* Bordure des boutons */
            color: white;
            font-size: 16px; /* Taille du texte */
            cursor: pointer;
            text-align: center; /* Centrer le texte à l'intérieur du bouton */
            display: flex;
            justify-content: center; /* Centrer le texte horizontalement */
            align-items: center; /* Centrer le texte verticalement */
            transition: background-color 0.3s; /* Transition pour effet de survol */
        }

        .deconnexion-btn {
            width: 250px;
            height: 60px;
            background-color: red;
            border: 2px solid white;
            color: white;
        }
    </style>
</head>
<body>
    <?php
    // Gestion de la déconnexion
    if (isset($_GET['deconnexion'])) {
        session_destroy();
        header('Location: ../login/login.php');
        exit;
    }
    ?>
    <div style='display: flex; line-height: 25px'>
        <div style='width: 90%'>
            <h1 style='color: rgb(248, 143, 44)'>Page d'accueil comptable</h1>
        </div>
        <div style='width: 10%'>
            <img src="../image/logo_GSB.png" width="100">
        </div>    
    </div>
    <!-- Conteneur des boutons -->
    <div class="container">
        <!-- Boutons principaux -->
        <button class="button" onclick="window.location.href='GF6-selection_fiche_de_frais.php'">Accéder à la sélection des fiches de frais</button>
        <form method="POST" action="../GF7/GF7-mise_en_paiement.php">
            <button class="button" type="submit">Mise en paiement des fiches de frais</button>
        </form>
        
        <!-- Bouton de déconnexion centré en dessous -->
        <button class="deconnexion-btn" onclick="window.location.href='?deconnexion=true'">Se déconnecter</button>
    </div>
</body>
</html>
