<?php
use App\Controllers\AuthController;
use App\Controllers\BookController;

return [
  ['GET',  '/',             [BookController::class, 'index']],

  ['GET',  '/login',        [AuthController::class, 'showLogin']],
  ['POST', '/login',        [AuthController::class, 'login']],
  ['POST', '/logout',       [AuthController::class, 'logout']],

  ['GET',  '/books',        [BookController::class, 'index']],
  ['GET',  '/books/create', [BookController::class, 'create']],
  ['POST', '/books',        [BookController::class, 'store']],
  ['GET',  '/books/edit',   [BookController::class, 'edit']],
  ['POST', '/books/update', [BookController::class, 'update']],
  ['POST', '/books/delete', [BookController::class, 'destroy']],
];
