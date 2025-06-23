<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sélecion de la fiche de frais</title>
        <script>
            // Fonction qui est appelée chaque fois que l'utilisateur sélectionne un nom
            function updateAnnee() {
                var idvis = document.getElementById('nom').value;  // Récupérer la valeur sélectionnée du nom

                // Réinitialiser la sélection du mois
                document.getElementById('mois').innerHTML = '<option value="" hidden></option>';

                // Si aucune valeur n'est sélectionnée, ne rien faire
                if (idvis === "") {
                    return;
                }

                // Créer un objet XMLHttpRequest pour faire une requête AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'GF6-chargement_annee.php?idvis=' + encodeURIComponent(idvis), true);

                // Fonction pour gérer la réponse du serveur
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Mettre à jour les options de l'année avec la réponse du serveur
                        document.getElementById('annee').innerHTML = xhr.responseText;
                    }
                };

                // Envoyer la requête avec le paramètre idvis
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('idvis=' + encodeURIComponent(idvis));
            }

            // Fonction qui est appelée chaque fois que l'utilisateur sélectionne une annee
            function updateMois() {
                var idvis = document.getElementById('nom').value;  // Récupérer la valeur sélectionnée du nom
                var annee = document.getElementById('annee').value;  // Récupérer la valeur sélectionnée de l'annee

                // Vérifier si les valeurs sont sélectionnées
                if (idvis === "" || annee === "") {
                    return;
                }

                // Créer un objet XMLHttpRequest pour faire une requête AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'GF6-chargement_mois.php', true);

                // Fonction pour gérer la réponse du serveur
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Mettre à jour les options du mois avec la réponse du serveur
                        document.getElementById('mois').innerHTML = xhr.responseText;
                    }
                };

                // Envoyer la requête avec les paramètres idvis et annee
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('idvis=' + encodeURIComponent(idvis) + '&annee=' + encodeURIComponent(annee));
            }
        </script>
    </head>
    <body>
        <div style='display: flex; line-height: 25px'>
            <div style='width: 90%'>
                <h1 style='color: rgb(248, 143, 44)'>Sélection de la fiche de frais du visiteur</h1>
            </div>
            <div style='width: 10%'>
                <img src="../image/logo_GSB.png" width="100">
            </div>    
        </div>
        <?php
        ini_set('display_errors', 1);
        include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

        //Demarrage de la session
        session_start();

        //Connexion a la base de donnee
        $cnxBDD = connexion();

        //Requete pour recuperer les noms des visiteurs
        $sql = "SELECT login FROM Utilisateur WHERE id IN (SELECT idVisiteur FROM FicheFrais);";
        $result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));
        ?>
        <div style="border: 1px solid; background-color:rgb(248, 143, 44); color: white; padding: 20px; border-radius: 8px; text-align: center; display: flex; flex-direction: column; align-items: center;">
            <h1>Sélectionnez les informations de la fiche de frais</h1>
            <form method="post" action="GF6-affichage_fiche_frais.php">
                <div style="display: flex; gap: 20px; align-items: center;">
                    <div style="display: flex-direction: column;">
                        <label for="nom">Choisissez un visiteur :</label><br>
                        <label for="annee">Année / Mois : </label>
                    </div>
                    <div style="display: flex-direction: column;">
                        <!-- Menu déroulant pour sélectionner un visiteur -->
                        <select id="nom" name="nom" onchange="updateAnnee()" style="width: 154px">
                        <option value="" hidden></option>
                        <?php
                        //On verifie si des noms ont ete trouve
                        if ($result->num_rows > 0) {
                            //On parcourt les resultats et on cree une option pour chaque nom
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row['login']; ?>"> <?php echo $row['login']; ?> </option>
                            <?php
                            }
                        } else {
                            ?>
                            <option value="">Aucun visiteur disponible</option>;
                        <?php
                        }
                        ?>
                        </select>
                        <br>
                        <!-- Menu déroulant pour sélectionner une année -->
                        <select id="annee" name="annee" onchange="updateMois()" style="width: 75px">
                            <option value="" hidden></option>
                        </select>
                        <!-- Menu déroulant pour sélectionner un mois -->
                        <select id="mois" name="mois" style="width: 75px">
                            <option value="" hidden></option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit">Sélectionner la fiche de frais</button>
            </form>
            <button onclick="window.history.back();">Retour</button>
        </div>
    </body>
</html>