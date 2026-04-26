<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin     = ['filter' => 'role:admin'];
$petugas     = ['filter' => 'role:petugas'];
$anggota     = ['filter' => 'role:anggota'];
$allRole   = ['filter' => 'role:admin, petugas, anggota'];

// Login
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// Halaman utama
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);

// Tambahkan ini di bagian route (Cari baris $routes->get...)
$routes->get('users', 'Users::index');
$routes->post('users/store', 'Users::store'); 
$routes->get('users/create', 'Users::create');
// Sesuaikan 'Users' dengan nama Controller yang Abang gunakan
$routes->post('users/save', 'Users::save');
$routes->get('users/edit/(:any)', 'Users::edit/$1'); // WAJIB ADA INI
$routes->post('users/update/(:any)', 'Users::update/$1'); // WAJIB ADA INI
$routes->get('users/delete/(:any)', 'Users::delete/$1');
// Tambahkan baris ini di Routes.php
$routes->get('petugas', 'UserController::index');
$routes->get('buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/wa/(:num)', 'Buku::wa/$1');

$routes->get('peminjaman', 'Peminjaman::index');
$routes->get('peminjaman/create', 'Peminjaman::create');
$routes->post('peminjaman/store', 'Peminjaman::store');
$routes->get('peminjaman/edit/(:num)', 'Peminjaman::edit/$1');
$routes->post('peminjaman/update/(:num)', 'Peminjaman::update/$1');
$routes->get('peminjaman/delete/(:num)', 'Peminjaman::delete/$1');
$routes->get('peminjaman/detail/(:num)', 'Peminjaman::detail/$1');
$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');
$routes->get('peminjaman/list_denda', 'Peminjaman::list_denda');
$routes->get('peminjaman/bayar_denda/(:num)', 'Peminjaman::bayar_denda/$1');
$routes->get('peminjaman/delete_denda/(:num)', 'Peminjaman::delete_denda/$1');
$routes->get('peminjaman/konfirmasi_bayar/(:num)', 'Peminjaman::konfirmasi_bayar/$1');
// Route untuk pengajuan pinjam oleh Anggota
$routes->get('peminjaman/ajukan/(:num)', 'Peminjaman::ajukan/$1');
$routes->get('peminjaman/denda_anggota', 'Peminjaman::denda_anggota');
$routes->post('peminjaman/upload_dana', 'Peminjaman::upload_dana');
// Tambahkan baris ini
$routes->post('pembayaran/upload_dana', 'Pembayaran::upload_dana');

// Route untuk persetujuan oleh Admin
$routes->get('peminjaman/setujui/(:num)', 'Peminjaman::setujui/$1');
$routes->get('peminjaman/tolak/(:num)', 'Peminjaman::tolak/$1');

$routes->get('katalog', 'Katalog::index');
// Tambahkan atau pastikan baris ini ada
$routes->get('profile', 'Anggota::profile');
$routes->post('anggota/update_profile', 'Anggota::update_profile');
$routes->get('anggota/profile', 'Anggota::profile'); // Tambahan biar aman kalau terlanjur pakai link lama

$routes->get('anggota', 'Anggota::index');
$routes->get('anggota/create', 'Anggota::create');
$routes->post('anggota/save', 'Anggota::save');
$routes->get('anggota/edit/(:num)', 'Anggota::edit/$1');
$routes->post('anggota/update/(:num)', 'Anggota::update/$1');
$routes->get('anggota/delete/(:num)', 'Anggota::delete/$1');

$routes->get('auth/login', 'Auth::login');
$routes->post('proses-login', 'Auth::proses_login');
$routes->post('auth/save_register', 'Auth::save_register'); // Tambahkan baris ini

$routes->get('home/deleteLog/(:num)', 'Home::deleteLog/$1');
$routes->get('home/clearAllLogs', 'Home::clearAllLogs');

$routes->get('/backup', 'Backup::index');

$routes->get('/restore', 'Restore::index');
$routes->post('/restore/auth', 'Restore::auth');
$routes->get('/restore/form', 'Restore::form');
$routes->post('/restore/process', 'Restore::process');