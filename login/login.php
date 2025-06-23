<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'entete.html'; ?>
    <div style="border: 1px solid; background-color: #79A8D3; padding: 20px; border-radius: 8px; text-align: center">
        <h1 style="color: white">Connexion</h1>
        <form style="display: flex; flex-direction: column; gap: 10px; align-items:center" method="get" action="test_login.php">
            <div style="display: flex; gap: 20px;">
                <div style="display: flex; flex-direction: column;">
                    <label style="color: white" for="login">Login :</label><br>
                    <label style="color: white" for="MotDePasse">Mot de passe :</label><br>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <input type="text" id="login" name="login" required><br>
                    <input type="password" id="password" name="password" required><br>
                </div>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>