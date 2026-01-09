<?php
use App\Core\View;

ob_start();
?>
<h1 class="h4 mb-3">Tambah Buku</h1>

<div class="card shadow-sm">
  <div class="card-body">
    <?php
      $action = '/books';
      $submitText = 'Simpan';
      require __DIR__ . '/_form.php';
    ?>
  </div>
</div>
<?php
$content = ob_get_clean();

echo View::render('layouts/main', [
  'title' => 'Tambah Buku',
  'content' => $content,
  'role' => $_SESSION['role'] ?? null
]);
