<?php
use App\Core\View;
use App\Support\Url;

function build_url(array $overrides = []): string {
  $q = $_GET;
  foreach ($overrides as $k => $v) {
    if ($v === null) unset($q[$k]); else $q[$k] = $v;
  }
  $qs = http_build_query($q);
  return Url::to('/books') . ($qs ? ('?' . $qs) : '');
}

ob_start();
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h4 mb-0">Daftar Buku</h1>
  <?php if (($role ?? null) === 'admin'): ?>
    <a class="btn btn-primary btn-sm" href="<?= Url::to('/books/create') ?>">+ Tambah</a>
  <?php endif; ?>
</div>

<form class="row g-2 mb-3" method="get" action="<?= Url::to('/books') ?>">
  <div class="col-12 col-md-8">
    <input class="form-control" name="q" value="<?= htmlspecialchars($q ?? '', ENT_QUOTES, 'UTF-8') ?>"
           placeholder="Cari judul / penulis...">
  </div>
  <div class="col-6 col-md-2">
    <button class="btn btn-dark w-100" type="submit">Cari</button>
  </div>
  <div class="col-6 col-md-2">
    <a class="btn btn-outline-secondary w-100" href="<?= Url::to('/books') ?>">Reset</a>
  </div>
</form>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
        <tr>
          <th>#</th>
          <th>Judul</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Tahun</th>
          <th>Stok</th>
          <?php if (($role ?? null) === 'admin'): ?>
            <th style="width:170px;">Aksi</th>
          <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($rows)): ?>
          <tr><td colspan="<?= (($role ?? null) === 'admin') ? 7 : 6 ?>" class="text-muted">Data kosong.</td></tr>
        <?php else: ?>
          <?php foreach ($rows as $i => $b): ?>
            <tr>
              <td><?= (($page - 1) * $perPage) + $i + 1 ?></td>
              <td><?= htmlspecialchars($b['judul'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($b['penulis'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($b['penerbit'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= (int)$b['tahun'] ?></td>
              <td><?= (int)$b['stok'] ?></td>

              <?php if (($role ?? null) === 'admin'): ?>
                <td>
                  <a class="btn btn-outline-primary btn-sm"
                     href="<?= Url::to('/books/edit') ?>?id=<?= (int)$b['id'] ?>">Edit</a>

                  <form class="d-inline" method="post"
                        action="<?= Url::to('/books/delete') ?>?id=<?= (int)$b['id'] ?>"
                        onsubmit="return confirm('Hapus buku ini?')">
                    <button class="btn btn-outline-danger btn-sm" type="submit">Hapus</button>
                  </form>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if (($pages ?? 1) > 1): ?>
      <nav aria-label="Pagination">
        <ul class="pagination pagination-sm mb-0">
          <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= htmlspecialchars(build_url(['page' => $page - 1]), ENT_QUOTES, 'UTF-8') ?>">Prev</a>
          </li>

          <?php
            $start = max(1, $page - 2);
            $end   = min($pages, $page + 2);
          ?>
          <?php for ($p = $start; $p <= $end; $p++): ?>
            <li class="page-item <?= ($p === $page) ? 'active' : '' ?>">
              <a class="page-link" href="<?= htmlspecialchars(build_url(['page' => $p]), ENT_QUOTES, 'UTF-8') ?>"><?= $p ?></a>
            </li>
          <?php endfor; ?>

          <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= htmlspecialchars(build_url(['page' => $page + 1]), ENT_QUOTES, 'UTF-8') ?>">Next</a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>

    <div class="small text-muted mt-2">
      Total: <?= (int)($total ?? 0) ?> data
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
echo View::render('layouts/main', ['title' => 'Books', 'content' => $content, 'role' => $role ?? null]);
