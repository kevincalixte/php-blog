<?php
require_once 'auth_fonctions.php';

if (is_logged_in()) {
    redirect('?page=home');
}

$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connexion-btn'])) {
    $identifiant = $_POST['identifiant'] ?? '';
    $password = $_POST['password'] ?? '';
    $resultat = login_user($pdo, $identifiant,  $password);
    if ($resultat['success']) {
        redirect('?page=home');
    } else {
        $error = $resultat['message'];
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="" method="post">
        <h1>Login</h1>
        <?php if ($error) { ?>
            <div class="alert">
                <?= $error ?>
            </div>
        <?php } ?>
        <div>
            <label for="identifiant">Username or Email : </label>
            <input type="text" name="identifiant" id="identifiant" value="test" required>
        </div>
        <div>
            <label for="password">Password : </label>
            <input type="text" name="password" id="password" value="test123" required>
        </div>
        <input type="submit" value="Connect" name="connexion-btn" />
    </form>
    <a href="?page=profile">Pas encore inscrit ? </a>
</body>

</html>