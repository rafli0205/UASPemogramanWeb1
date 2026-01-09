<?php
use App\Support\Url;

// $action = '/books' atau '/books/update?id=1' (path app, bukan full URL)
// $submitText, $book (optional)
$book = $book ?? ['judul'=>'','penulis'=>'','penerbit'=>'','tahun'=>0,'stok'=>0];
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<form method="post" action="<?= e(Url::to($action)) ?>">
  <div class="mb-3">
    <label class="form-label">Judul</label>
    <input class="form-control" name="judul" required value="<?= e($book['judul']) ?>">
  </div>

  <div class="row g-2">
    <div class="col-12 col-md-6 mb-3">
      <label class="form-label">Penulis</label>
      <input class="form-control" name="penulis" required value="<?= e($book['penulis']) ?>">
    </div>
    <div class="col-12 col-md-6 mb-3">
      <label class="form-label">Penerbit</label>
      <input class="form-control" name="penerbit" required value="<?= e($book['penerbit']) ?>">
    </div>
  </div>

  <div class="row g-2">
    <div class="col-6 col-md-3 mb-3">
      <label class="form-label">Tahun</label>
      <input class="form-control" type="number" name="tahun" min="0" value="<?= (int)$book['tahun'] ?>">
    </div>
    <div class="col-6 col-md-3 mb-3">
      <label class="form-label">Stok</label>
      <input class="form-control" type="number" name="stok" min="0" value="<?= (int)$book['stok'] ?>">
    </div>
  </div>

  <button class="btn btn-primary" type="submit"><?= e($submitText) ?></button>
  <a class="btn btn-outline-secondary" href="<?= Url::to('/books') ?>">Batal</a>
</form>
