<?php
namespace App\Support;

class Auth {
  public static function check(): bool {
    return !empty($_SESSION['user_id']);
  }

  public static function role(): ?string {
    return $_SESSION['role'] ?? null;
  }

  public static function requireLogin(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!self::check()) Url::redirect('/login');
  }

  public static function requireAdmin(): void {
    self::requireLogin();
    if (self::role() !== 'admin') {
      http_response_code(403);
      echo "403 Forbidden";
      exit;
    }
  }
}
