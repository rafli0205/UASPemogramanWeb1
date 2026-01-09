<?php
use App\Support\Url;
// $title, $content (string HTML), $role (admin/user/null)
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Book Manager', ENT_QUOTES, 'UTF-8') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= Url::to('/books') ?>">Book Manager</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= Url::to('/books') ?>">Books</a></li>
        <?php if (($role ?? null) === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= Url::to('/books/create') ?>">Tambah Buku</a></li>
        <?php endif; ?>
      </ul>

      <?php if (!empty($_SESSION['user_id'])): ?>
        <form method="post" action="<?= Url::to('/logout') ?>" class="d-flex">
          <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
        </form>
      <?php else: ?>
        <a class="btn btn-outline-light btn-sm" href="<?= Url::to('/login') ?>">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<main class="container py-4">
  <?= $content ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
