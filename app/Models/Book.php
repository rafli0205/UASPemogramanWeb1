<?php
namespace App\Models;

use App\Support\DB;
use PDO;

class Book {
  public static function paginate(string $q, int $page, int $perPage): array {
    $pdo = DB::pdo();
    $page = max(1, $page);
    $perPage = max(1, min(50, $perPage));
    $offset = ($page - 1) * $perPage;

    $where = "";
    $params = [];
    if ($q !== '') {
      $where = "WHERE judul LIKE :q OR penulis LIKE :q";
      $params['q'] = "%$q%";
    }

    // total rows
    $st = $pdo->prepare("SELECT COUNT(*) AS cnt FROM books $where");
    $st->execute($params);
    $total = (int)($st->fetch()['cnt'] ?? 0);

    // data rows (LIMIT/OFFSET)
    $sql = "SELECT * FROM books $where ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $st2 = $pdo->prepare($sql);

    foreach ($params as $k => $v) $st2->bindValue(":$k", $v, PDO::PARAM_STR);
    $st2->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $st2->bindValue(':offset', $offset, PDO::PARAM_INT);

    $st2->execute();
    $rows = $st2->fetchAll();

    return [
      'rows' => $rows,
      'total' => $total,
      'page' => $page,
      'perPage' => $perPage,
      'pages' => (int)ceil($total / $perPage),
      'q' => $q,
    ];
  }

  public static function find(int $id): ?array {
    $pdo = DB::pdo();
    $st = $pdo->prepare("SELECT * FROM books WHERE id = :id");
    $st->execute(['id' => $id]);
    $row = $st->fetch();
    return $row ?: null;
  }

  public static function create(array $data): void {
    $pdo = DB::pdo();
    $st = $pdo->prepare("
      INSERT INTO books (judul, penulis, penerbit, tahun, stok)
      VALUES (:judul, :penulis, :penerbit, :tahun, :stok)
    ");
    $st->execute($data);
  }

  public static function update(int $id, array $data): void {
    $pdo = DB::pdo();
    $data['id'] = $id;
    $st = $pdo->prepare("
      UPDATE books
      SET judul=:judul, penulis=:penulis, penerbit=:penerbit, tahun=:tahun, stok=:stok
      WHERE id=:id
    ");
    $st->execute($data);
  }

  public static function delete(int $id): void {
    $pdo = DB::pdo();
    $st = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $st->execute(['id' => $id]);
  }
}
