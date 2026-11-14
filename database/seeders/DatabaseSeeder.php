<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintFeedback;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Administrator
        $admin = User::create([
            'name' => 'Drs. Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // ⬇️ SEEDER PETUGAS BARU (SUDAH DITAMBAHKAN DI SINI) ⬇️
        $petugas = User::create([
            'name' => 'Budi Teknisi Sarpras',
            'email' => 'petugas@sarpras.sch.id',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // 2. Akun Siswa Pengujian
        $siswa1 = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nisn' => '0061234567',
            'kelas' => 'XII RPL 1',
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Rahmawati',
            'email' => 'siti.rahma@siswa.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nisn' => '0069876543',
            'kelas' => 'XII RPL 2',
        ]);

        $siswa3 = User::create([
            'name' => 'Bima Arya Pratama',
            'email' => 'bima.arya@siswa.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nisn' => '0071122334',
            'kelas' => 'XI TKJ 1',
        ]);

        $siswa4 = User::create([
            'name' => 'sambo',
            'email' => 'sambo@siswa.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nisn' => '0013847',
            'kelas' => 'XII RPL 2',
        ]);

        // 3. Data Master 11 Kategori Sarana
        $categoriesData = [
            ['name' => 'Proyektor', 'description' => 'Perangkat proyektor infocus, kabel HDMI/VGA, dan layar presentasi kelas.'],
            ['name' => 'Komputer', 'description' => 'PC Laboratorium, keyboard, mouse, monitor, dan perangkat periferal TI.'],
            ['name' => 'Meja dan Kursi', 'description' => 'Furnitur bangku belajar siswa, meja guru, dan kursi laboratorium.'],
            ['name' => 'Ruang Kelas', 'description' => 'Fasilitas umum kelas: papan tulis, pintu, jendela, ventilasi, dan lantai.'],
            ['name' => 'Toilet', 'description' => 'Sanitasi, kran air, wastafel, gayung, pintu toilet, dan pipa pembuangan.'],
            ['name' => 'Listrik', 'description' => 'Stopkontak, saklar lampu, instalasi kabel, sekring, dan pencahayaan.'],
            ['name' => 'Laboratorium', 'description' => 'Meja praktikum, wastafel kimiawi, rak reagen, dan alat peraga.'],
            ['name' => 'Perpustakaan', 'description' => 'Rak buku, pencahayaan ruang baca, pendingin AC, dan meja sirkulasi.'],
            ['name' => 'Kebersihan', 'description' => 'Tempat sampah pemilahan, sapu, alat pel, dan kebersihan lingkungan.'],
            ['name' => 'Fasilitas Olahraga', 'description' => 'Ring basket, gawang futsal, tiang voli, dan lapangan upacara.'],
            ['name' => 'Lainnya', 'description' => 'Aspirasi dan kebutuhan sarana di luar kategori yang telah terdaftar.'],
        ];

        $cats = [];
        foreach ($categoriesData as $cat) {
            $cats[$cat['name']] = Category::create($cat);
        }

        // 4. Data Dummy Pengaduan Sesuai Portofolio
        $c1 = Complaint::create([
            'ticket_code' => 'PENG-2026-001',
            'user_id' => $siswa1->id,
            'category_id' => $cats['Proyektor']->id,
            'title' => 'Proyektor Epson di Lab RPL 2 Mati Total',
            'location' => 'Gedung B Lantai 2, Laboratorium Rekayasa Perangkat Lunak 2',
            'description' => 'Ketika dinyalakan saat jam pelajaran Basis Data, lampu proyektor berkedip merah lalu mati total.',
            'status' => 'Diproses',
            'progress' => 50,
            'created_at' => '2026-09-24 08:30:00',
        ]);
        ComplaintFeedback::create([
            'complaint_id' => $c1->id,
            'user_id' => $admin->id,
            'feedback' => 'Teknisi rekanan proyektor sedang mengganti modul lampu dan catu daya.',
            'created_at' => '2026-09-25 10:00:00',
        ]);

        $c2 = Complaint::create([
            'ticket_code' => 'PENG-2026-002',
            'user_id' => $siswa1->id,
            'category_id' => $cats['Meja dan Kursi']->id,
            'title' => '3 Unit Kursi Siswa Kayu Patah di Baris Belakang',
            'location' => 'Ruang Teori XII RPL 1 (Gedung Utama Lantai 2)',
            'description' => 'Tiga kursi belajar kayu di baris paling belakang kondisinya goyang dan sandarannya patah.',
            'status' => 'Diperbaiki',
            'progress' => 75,
            'created_at' => '2026-09-20 09:15:00',
        ]);
        ComplaintFeedback::create([
            'complaint_id' => $c2->id,
            'user_id' => $admin->id,
            'feedback' => 'Penggantian baut dan perekatan kayu tahap akhir oleh bagian pertukangan.',
            'created_at' => '2026-09-21 11:30:00',
        ]);

        $c3 = Complaint::create([
            'ticket_code' => 'PENG-2026-003',
            'user_id' => $siswa2->id,
            'category_id' => $cats['Toilet']->id,
            'title' => 'Keran Air Wastafel Toilet Putri Lantai 1 Macet & Patah',
            'location' => 'Toilet Siswa Putri Gedung A Lantai 1',
            'description' => 'Tuas kran air putus sehingga air mengalir terus dan tidak bisa dimatikan manual.',
            'status' => 'Selesai',
            'progress' => 100,
            'created_at' => '2026-09-15 07:45:00',
        ]);
        ComplaintFeedback::create([
            'complaint_id' => $c3->id,
            'user_id' => $admin->id,
            'feedback' => 'Kran telah diganti dengan unit baru berbahan kuningan tahan karat.',
            'created_at' => '2026-09-16 14:00:00',
        ]);

        $c4 = Complaint::create([
            'ticket_code' => 'PENG-2026-004',
            'user_id' => $siswa3->id,
            'category_id' => $cats['Listrik']->id,
            'title' => 'Stopkontak Deretan Meja Lab Jaringan Sering Mengeluarkan Percikan',
            'location' => 'Lab Komputer & Jaringan Lantai 3',
            'description' => 'Stopkontak deretan meja nomor 3 sering mengeluarkan percikan api saat kabel adapter dicolokkan.',
            'status' => 'Menunggu',
            'progress' => 0,
            'created_at' => '2026-09-28 13:10:00',
        ]);

        $c5 = Complaint::create([
            'ticket_code' => 'PENG-2026-005',
            'user_id' => $siswa1->id,
            'category_id' => $cats['Lainnya']->id,
            'title' => 'Permintaan Pemasangan Dispenser Air Minum Pribadi di Ruang OSIS',
            'location' => 'Ruang Sekretariat OSIS',
            'description' => 'Mohon disediakan unit dispenser air minum panas-dingin di ruang sekretariat OSIS.',
            'status' => 'Ditolak',
            'progress' => 0,
            'created_at' => '2026-09-12 10:00:00',
        ]);
        ComplaintFeedback::create([
            'complaint_id' => $c5->id,
            'user_id' => $admin->id,
            'feedback' => 'Permohonan di luar wewenang pemeliharaan darurat sarpras sekolah. Silakan ajukan via proposal anggaran tahunan OSIS.',
            'created_at' => '2026-09-13 09:00:00',
        ]);

        $c6 = Complaint::create([
            'ticket_code' => 'PENG-2026-006',
            'user_id' => $siswa1->id,
            'category_id' => $cats['Toilet']->id,
            'title' => 'Saluran Pembuangan Wastafel Toilet Siswa Putra Mampet',
            'location' => 'Toilet Lantai 1 Dekat Lapangan',
            'description' => 'Air di wastafel meluap dan tidak mengalir ke pipa pembuangan saat kran dibuka.',
            'status' => 'Selesai',
            'progress' => 100,
            'created_at' => '2026-09-30 08:00:00',
        ]);
        ComplaintFeedback::create([
            'complaint_id' => $c6->id,
            'user_id' => $admin->id,
            'feedback' => 'Pipa saluran telah dibersihkan oleh tim teknisi sarpras. Sudah kembali normal.',
            'created_at' => '2026-09-30 15:30:00',
        ]);

        $c7 = Complaint::create([
            'ticket_code' => 'PENG-2026-007',
            'user_id' => $siswa4->id,
            'category_id' => $cats['Proyektor']->id,
            'title' => 'pengen pulang',
            'location' => 'spw 2',
            'description' => 'Fasilitas di spw 2 perlu diperiksa kembali karena proses belajar sudah selesai.',
            'status' => 'Menunggu',
            'progress' => 0,
            'created_at' => '2026-09-30 11:20:00',
        ]);
    }
}
