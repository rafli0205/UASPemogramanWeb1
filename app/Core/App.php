<?php
namespace App\Core;

class App {
  public function run(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $router = new Router(require __DIR__ . '/../config/routes.php');
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
  }
}
