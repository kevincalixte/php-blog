<?php 
if (is_logged_in()) {
    redirect('index.php');
}

$errors = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscription-btn'])):
    $username = nettoyer($_POST['username']) ?? '';
    $email = nettoyer($_POST['email']) ?? '';
    $password = trim($_POST['password']) ?? '';
    $password_confirm = trim($_POST['password_confirm']) ?? '';

    if($password !== $password_confirm):
        $errors = 'Les mots de passe ne correspondent pas';
    else:
        $resultat = register_user($pdo,$username,$email,$password);
           
        if ($resultat['success']):
            redirect('index.php?page=login');
        else:
            $errors = $resultat['message'];
        endif;
    endif;
endif;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <main>
    <h1>Inscription</h1>
    <?php if ($errors): ?>
        <div class="alert">
            <?=  $errors ?>
        </div>
    <? endif ?>
    <form method="POST">
        <div>
            <label for="username">Nom d'utilisateur : </label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="email">Email : </label>
            <input type="email" name="email" id="email" required>
        </div>        
        <div>
            <label for="password">Mode de passe : </label>
            <input type="password" name="password" id="password" required>
            <small>Le mot de passe doit contenir au mois 6 caractéres</small>
        </div>
        <div>
            <label for="password_confirm">Confirmez le mode de passe : </label>
            <input type="password" name="password_confirm" id="password_confirm " required>
        </div>        
        <input type="submit" name="inscription-btn" value="S'inscrire">
    </form>
    </main>
</body>
</html>