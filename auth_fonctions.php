<?php
require 'config.php';
require 'condb.php';

function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function logout_user()
{
    $_SESSION = [];
    session_destroy();
    session_unset();
}

function login_user($pdo, $identifiant, $password)
{
    if (empty($identifiant) || empty($password)):
        return [
            'success' => false,
            'message' => 'Tous les chmaps sont obligzatoires.'
        ];
    endif;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$identifiant, $password]);
    $user = $stmt->fetch();

    if (!$user):
        return [
            'success' => false,
            'message' => 'identifiants incorrects !'
        ];
    endif;

    if (!password_verify($password, $user['password'])):
        return [
            'success' => false,
            'message' => 'identifiants incorrects !'
        ];
    endif;

    $_SESSION['logged_in'] = true;

    return [
        'success' => true,
        'message' => 'Connexion résussie'
    ];
}

function register_user($pdo, $username, $email, $password)
{
    if (empty($username) || empty($email) || empty($password)):
        return [
            'success' => false,
            'message' => 'Tous les chmaps sont obligzatoires.'
        ];
    endif;

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        return [
            'success' => false,
            'message' => 'Email invalide.'
        ];
    endif;

    if (strlen($password) < 6):
        return [
            'success' => false,
            'message' => 'Le mot de passe doit contenir au mois 6 caractéres.'
        ];
    endif;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);

    if ($stmt->fetch()):
        return [
            'success' => false,
            'message' => 'Nom d\'utilisateur ou email déjà utilisé.'
        ];
    endif;

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO blog.users (username,email,password,created_at) VALUES (?,?,?, NOW())");
    if ($stmt->execute([$username, $email, $password_hashed ])):
        return [
            'success' => true,
            'message' => 'Inscription résussie.'
        ];
    endif;


    return [
            'success' => false,
            'message' => 'Erreur lors de l\'inscription.'
    ];

}