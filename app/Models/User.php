<?php
namespace App\Models;

use App\Support\DB;

class User {
  public static function findByEmail(string $email): ?array {
    $pdo = DB::pdo();
    $st = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $st->execute(['email' => $email]);
    $row = $st->fetch();
    return $row ?: null;
  }
}
