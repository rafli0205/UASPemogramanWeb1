<?php
use App\Core\View;

ob_start();
?>
<div class="alert alert-warning">
  Halaman tidak ditemukan.
</div>
<a class="btn btn-dark btn-sm" href="/books">Kembali</a>
<?php
$content = ob_get_clean();
echo View::render('layouts/main', ['title' => '404', 'content' => $content, 'role' => $_SESSION['role'] ?? null]);
