<?php
namespace App\Core;

class Router {
  public function __construct(private array $routes) {}

  private function normalize(string $path): string {
    $path = rtrim($path, '/');
    return $path === '' ? '/' : $path;
  }

  private function basePath(): string {
    // contoh hasil: /book-manager/public (karena index.php ada di /public)
    $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    return $this->normalize($base);
  }

  private function pathOnly(string $uri): string {
    $path = parse_url($uri, PHP_URL_PATH) ?? '/';
    $path = $this->normalize($path);

    $base = $this->basePath();
    if ($base !== '/' && str_starts_with($path, $base)) {
      $path = substr($path, strlen($base));
      $path = $this->normalize($path);
    }

    return $path;
  }

  public function dispatch(string $method, string $uri): void {
    $path = $this->pathOnly($uri);

    foreach ($this->routes as $r) {
      [$m, $p, $handler] = $r;
      $p = $this->normalize($p);

      if ($m === $method && $p === $path) {
        if (is_array($handler)) {
          [$class, $action] = $handler;
          $controller = new $class();
          $controller->$action();
          return;
        }
        $handler();
        return;
      }
    }

    http_response_code(404);
    echo View::render('errors/404', ['path' => $path]);
  }
}
