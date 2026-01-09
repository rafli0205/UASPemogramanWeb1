<?php
namespace App\Support;

use PDO;

class DB {
  public static function pdo(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    $cfg = require __DIR__ . '/../config/database.php';
    $pdo = new PDO($cfg['dsn'], $cfg['user'], $cfg['pass'], [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $pdo;
  }
}
