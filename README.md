# mvp_php

Aplikasi ini merupakan implementasi sederhana dari pola desain Model-View-Presenter (MVP) untuk pengelolaan data Mahasiswa menggunakan PHP dan MySQL.

## Struktur Folder

- `index.php` : Entry point aplikasi.
- `model/` : Berisi kelas-kelas untuk pengelolaan data dan database.
- `presenter/` : Berisi interface dan implementasi presenter.
- `view/` : Berisi interface dan implementasi view.
- `templates/` : Berisi file template HTML.
- `mvp_php.sql` : File SQL untuk pembuatan database dan tabel.

## Desain Program

Aplikasi ini memisahkan logika bisnis, tampilan, dan data dengan pola MVP:
- **Model**: Mengelola data dan interaksi dengan database.
- **View**: Menangani tampilan dan interaksi dengan user.
- **Presenter**: Menjembatani model dan view, mengelola logika aplikasi.

## Alur Program

1. User mengakses aplikasi melalui `index.php`.
2. View (`TampilMahasiswa`) menerima input user dan meneruskan ke Presenter (`ProsesMahasiswa`).
3. Presenter memproses data, berinteraksi dengan Model untuk mengambil/menyimpan data.
4. Data yang sudah diproses dikirim kembali ke View untuk ditampilkan menggunakan template HTML.

## Cara Menjalankan

1. Import `mvp_php.sql` ke database MySQL Anda.
2. Atur konfigurasi koneksi database pada file `model/DB.class.php` jika diperlukan.
3. Jalankan aplikasi melalui web server (XAMPP/Laragon/dll) dan akses `index.php` melalui browser.

## Fitur
- Menampilkan daftar mahasiswa.
- Menambah data mahasiswa.
- Edit data mahasiswa.
- Hapus data mahasiswa.

## Dokum bang
![alt text](<screen record/Mahasiswa and 8 more pages - Profile 1 - Microsoft_ Edge 2025-05-10 14-54-25 (1).gif>)