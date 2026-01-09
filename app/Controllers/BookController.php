<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Book;
use App\Support\Auth;
use App\Support\Url;

class BookController {
  // GET /books (user & admin)
  public function index(): void {
    Auth::requireLogin();

    $q = trim($_GET['q'] ?? '');
    $page = (int)($_GET['page'] ?? 1);

    $data = Book::paginate($q, $page, 10);
    $data['role'] = Auth::role();

    echo View::render('books/index', $data);
  }

  // GET /books/create (admin)
  public function create(): void {
    Auth::requireAdmin();
    echo View::render('books/create');
  }

  // POST /books (admin)
  public function store(): void {
    Auth::requireAdmin();

    Book::create([
      'judul' => trim($_POST['judul'] ?? ''),
      'penulis' => trim($_POST['penulis'] ?? ''),
      'penerbit' => trim($_POST['penerbit'] ?? ''),
      'tahun' => (int)($_POST['tahun'] ?? 0),
      'stok' => (int)($_POST['stok'] ?? 0),
    ]);

    Url::redirect('/books');
  }

  // GET /books/edit?id=1 (admin)
  public function edit(): void {
    Auth::requireAdmin();

    $id = (int)($_GET['id'] ?? 0);
    $book = Book::find($id);
    if (!$book) {
      http_response_code(404);
      echo View::render('errors/404');
      return;
    }

    echo View::render('books/edit', ['book' => $book]);
  }

  // POST /books/update?id=1 (admin)
  public function update(): void {
    Auth::requireAdmin();

    $id = (int)($_GET['id'] ?? 0);
    Book::update($id, [
      'judul' => trim($_POST['judul'] ?? ''),
      'penulis' => trim($_POST['penulis'] ?? ''),
      'penerbit' => trim($_POST['penerbit'] ?? ''),
      'tahun' => (int)($_POST['tahun'] ?? 0),
      'stok' => (int)($_POST['stok'] ?? 0),
    ]);

    Url::redirect('/books');
  }

  // POST /books/delete?id=1 (admin)
  public function destroy(): void {
    Auth::requireAdmin();

    $id = (int)($_GET['id'] ?? 0);
    Book::delete($id);

    Url::redirect('/books');
  }
}
