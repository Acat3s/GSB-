<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Saisir une nouvelle fiche de frais</title>
    </head>
    <body>
        <div style='display: flex; line-height: 25px'>
            <div style='width: 90%'>
                <h1 style='color: rgb(54, 144, 228)'>Gestion des Frais</h1>
            </div>
            <div style='width: 10%'>
                <img src="../image/logo_GSB.png" width="100">
            </div>
        </div>
        <div style='background-color: #79A8D3'>
            <form action="GF4-traitement_fiche_de_frais.php" method="post">
                <h1 style='color: white'>Saisie</h1>
                <div style="display: flex; align-items: center; justify-content: flex-start;">
                    <div>
                        <p style="color: white">PÉRIODE D'ENGAGEMENT :</p>
                    </div>
                    <div style="padding: 20px">
                        <label style="color: white" for="annee_disable">Année : </label>
                        <input type="text" id="annee_disable" name="annee_disable" value="<?php echo date('Y');?>" disabled="disabled" size="2" />
                        <label style="color: white" for="mois_disable">Mois : </label>
                        <input type="text" id="mois_disable" name="mois_disable" value="<?php echo date('m');?>" disabled="disabled" size="2" />
                    </div>
                </div>
                    <!-- Champs cachés pour envoyer les valeurs -->
                <input type="hidden" name="annee" value="<?php echo date("Y"); ?>" />
                <input type="hidden" name="mois" value="<?php echo date("m"); ?>" />
                <input type="hidden" name="type" value="creation" />
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
                        <input type="number" id="Txtrepas" name="Txtrepas" min="0" style="width: 50px" required="required" /><br>
                        <input type="number" id="Txtnuitee" name="Txtnuitee" min="0" style="width: 50px" required="required" /><br>
                        <input type="number" id="Txtetape" name="Txtetape" min="0" style="width: 50px" required="required" /><br>
                        <input type="number" id="TxtKm" name="TxtKm" min="0" style="width: 50px" required="required" /><br>
                        <input type="number" id="TxtNbJustif" name="TxtNbJustif" min="0" style="width: 50px" required="required" /><br>
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