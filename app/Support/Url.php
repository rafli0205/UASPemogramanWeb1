<?php
namespace App\Support;

class Url {
  public static function base(): string {
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $base = rtrim(dirname($script), '/');     // contoh: /book-manager/public
    return $base === '/' ? '' : $base;        // kalau root, base = ''
  }

  public static function to(string $path): string {
    $path = '/' . ltrim($path, '/');
    return self::base() . $path;
  }

  public static function redirect(string $path): void {
    header('Location: ' . self::to($path));
    exit;
  }
}
