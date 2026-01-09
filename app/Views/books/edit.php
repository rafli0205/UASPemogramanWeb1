<?php
use App\Core\View;

ob_start();
?>
<h1 class="h4 mb-3">Edit Buku</h1>

<div class="card shadow-sm">
  <div class="card-body">
    <?php
      $action = '/books/update?id=' . (int)$book['id'];
      $submitText = 'Update';
      require __DIR__ . '/_form.php';
    ?>
  </div>
</div>
<?php
$content = ob_get_clean();

echo View::render('layouts/main', [
  'title' => 'Edit Buku',
  'content' => $content,
  'role' => $_SESSION['role'] ?? null
]);
