-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 02 Nov 2024 pada 15.36
-- Versi server: 8.0.35
-- Versi PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sinopal_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_akta_cerai`
--

CREATE TABLE `t_akta_cerai` (
  `id_akta_cerai` int NOT NULL,
  `id_perkara` int NOT NULL,
  `no_seri` varchar(100) NOT NULL,
  `no_akta_cerai` varchar(100) NOT NULL,
  `tanggal_terbit` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_akta_cerai`
--

INSERT INTO `t_akta_cerai` (`id_akta_cerai`, `id_perkara`, `no_seri`, `no_akta_cerai`, `tanggal_terbit`) VALUES
(29, 13, '444444', 'A457547575', '2024-11-02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_perkara`
--

CREATE TABLE `t_perkara` (
  `id_perkara` int NOT NULL,
  `no_perkara` varchar(50) NOT NULL,
  `no_whatsapp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama_penggugat` varchar(100) NOT NULL,
  `nama_tergugat` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_pendaftaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_perkara`
--

INSERT INTO `t_perkara` (`id_perkara`, `no_perkara`, `no_whatsapp`, `email`, `nama_penggugat`, `nama_tergugat`, `alamat`, `tanggal_pendaftaran`) VALUES
(13, '890/Pdt.G/2024/PA.Tgm', '089624434149', 'rizqi.@gmail.com', 'Rizqi bin Wahyu', 'Wahyu binti Rizqi', 'Kalirejo', '2024-10-22'),
(19, '29/2024', '08973609581', 'fajar@gmail.com', 'Farhan', 'Okta', 'Bandung Baru', '2024-10-23'),
(20, '891/Pdt.G/2024/PA.Tgm', '08973609581', 'fajar@gmail.com', 'Fajar bin Shodiq', 'Shodiq binti Fajar', 'Bandung Baru', '2024-10-23'),
(21, '892/Pdt.G/2024/PA.Tgm', '08973609581', 'fajar@gmail.com', 'Putra bin Pangestu', 'Pangestu binti Putra', 'Cililin', '2024-10-23'),
(22, '789/Pdt.G/2024/PA.Tgm', '089624434149', 'rizqinaufal44@gmail.com', 'RNopal', 'Pajar', 'Bandungbaru', '2024-10-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Rizqi Wahyu Naufal', 'Rizqi', 'e64b78fc3bc91bcbc7dc232ba8ec59e0'),
(2, 'Fajar Shodiq', 'fajar', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_akta_cerai`
--
ALTER TABLE `t_akta_cerai`
  ADD PRIMARY KEY (`id_akta_cerai`),
  ADD KEY `t_akta_cerai_ibfk_1` (`id_perkara`);

--
-- Indeks untuk tabel `t_perkara`
--
ALTER TABLE `t_perkara`
  ADD PRIMARY KEY (`id_perkara`),
  ADD UNIQUE KEY `no_perkara` (`no_perkara`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_akta_cerai`
--
ALTER TABLE `t_akta_cerai`
  MODIFY `id_akta_cerai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `t_perkara`
--
ALTER TABLE `t_perkara`
  MODIFY `id_perkara` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_akta_cerai`
--
ALTER TABLE `t_akta_cerai`
  ADD CONSTRAINT `t_akta_cerai_ibfk_1` FOREIGN KEY (`id_perkara`) REFERENCES `t_perkara` (`id_perkara`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
