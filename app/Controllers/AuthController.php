<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Support\Url;

class AuthController {
  public function showLogin(): void {
    echo View::render('auth/login');
  }

  public function login(): void {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $user = User::findByEmail($email);
    if (!$user || !password_verify($pass, $user['password_hash'])) {
      echo View::render('auth/login', ['error' => 'Email/password salah']);
      return;
    }

    if (session_status() === PHP_SESSION_NONE) session_start();
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role']    = $user['role'];

    Url::redirect('/books');
  }

  public function logout(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
      $p = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();

    Url::redirect('/login');
  }
}
