<?php
use App\Core\View;
use App\Support\Url;

ob_start();
?>
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h4 mb-3">Login</h1>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger py-2"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= Url::to('/login') ?>">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required>
          </div>
          <button class="btn btn-primary w-100" type="submit">Masuk</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
echo View::render('layouts/main', ['title' => 'Login', 'content' => $content, 'role' => null]);
