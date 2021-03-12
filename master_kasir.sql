-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.31-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for master_kasir
CREATE DATABASE IF NOT EXISTS `master_kasir` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `master_kasir`;

-- Dumping structure for table master_kasir.akun
CREATE TABLE IF NOT EXISTS `akun` (
  `idakun` int(11) NOT NULL AUTO_INCREMENT,
  `akun` char(50) DEFAULT NULL,
  `hapus` int(11) DEFAULT '1',
  PRIMARY KEY (`idakun`),
  UNIQUE KEY `akun` (`akun`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.akun: ~2 rows (approximately)
/*!40000 ALTER TABLE `akun` DISABLE KEYS */;
INSERT INTO `akun` (`idakun`, `akun`, `hapus`) VALUES
	(1, 'PENJUALAN', 0),
	(2, 'PEMBELIAN', 0);
/*!40000 ALTER TABLE `akun` ENABLE KEYS */;

-- Dumping structure for table master_kasir.bulan
CREATE TABLE IF NOT EXISTS `bulan` (
  `id` int(11) NOT NULL DEFAULT '0',
  `namabulan` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.bulan: ~12 rows (approximately)
/*!40000 ALTER TABLE `bulan` DISABLE KEYS */;
INSERT INTO `bulan` (`id`, `namabulan`) VALUES
	(1, 'Januari'),
	(2, 'Februari'),
	(3, 'Maret'),
	(4, 'April'),
	(5, 'Mei'),
	(6, 'Juni'),
	(7, 'Juli'),
	(8, 'Agustus'),
	(9, 'September'),
	(10, 'Oktober'),
	(11, 'November'),
	(12, 'Desember');
/*!40000 ALTER TABLE `bulan` ENABLE KEYS */;

-- Dumping structure for table master_kasir.item_pembelian
CREATE TABLE IF NOT EXISTS `item_pembelian` (
  `iditem_pembelian` int(11) NOT NULL AUTO_INCREMENT,
  `idpembelian` int(11) DEFAULT NULL,
  `idstok` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  PRIMARY KEY (`iditem_pembelian`),
  KEY `FK_item_pembelian_pembelian` (`idpembelian`),
  KEY `FK_item_pembelian_stok` (`idstok`),
  CONSTRAINT `FK_item_pembelian_pembelian` FOREIGN KEY (`idpembelian`) REFERENCES `pembelian` (`idpembelian`) ON UPDATE CASCADE,
  CONSTRAINT `FK_item_pembelian_stok` FOREIGN KEY (`idstok`) REFERENCES `stok` (`idstok`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.item_pembelian: ~0 rows (approximately)
/*!40000 ALTER TABLE `item_pembelian` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_pembelian` ENABLE KEYS */;

-- Dumping structure for table master_kasir.item_penjualan
CREATE TABLE IF NOT EXISTS `item_penjualan` (
  `iditem_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `faktur` char(50) NOT NULL DEFAULT '',
  `idmenu` int(11) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`iditem_penjualan`),
  KEY `FK_item_penjualan_penjualan` (`faktur`) USING BTREE,
  KEY `FK_item_penjualan_menu` (`idmenu`),
  CONSTRAINT `FK_item_penjualan_menu` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  CONSTRAINT `FK_item_penjualan_penjualan` FOREIGN KEY (`faktur`) REFERENCES `penjualan` (`faktur`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.item_penjualan: ~0 rows (approximately)
/*!40000 ALTER TABLE `item_penjualan` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_penjualan` ENABLE KEYS */;

-- Dumping structure for table master_kasir.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `idkategori` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` char(50) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `keterangan_kategori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idkategori`) USING BTREE,
  UNIQUE KEY `kategori` (`kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.kategori: ~1 rows (approximately)
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;

-- Dumping structure for table master_kasir.keuangan
CREATE TABLE IF NOT EXISTS `keuangan` (
  `idkeuangan` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `faktur` char(50) DEFAULT '-',
  `nama_akun` char(50) DEFAULT NULL,
  `jenis` char(50) DEFAULT NULL,
  `debit` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `idpembelian` int(11) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idkeuangan`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.keuangan: ~0 rows (approximately)
/*!40000 ALTER TABLE `keuangan` DISABLE KEYS */;
/*!40000 ALTER TABLE `keuangan` ENABLE KEYS */;

-- Dumping structure for table master_kasir.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `idkategori` int(11) DEFAULT NULL,
  `menu` varchar(255) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `keterangan_menu` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idmenu`),
  KEY `FK_menu_kategori` (`idkategori`),
  CONSTRAINT `FK_menu_kategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.menu: ~0 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table master_kasir.pembelian
CREATE TABLE IF NOT EXISTS `pembelian` (
  `idpembelian` int(11) NOT NULL AUTO_INCREMENT,
  `faktur_pembelian` char(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `biaya_tambahan` float DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idpembelian`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.pembelian: ~0 rows (approximately)
/*!40000 ALTER TABLE `pembelian` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembelian` ENABLE KEYS */;

-- Dumping structure for table master_kasir.pengurangan_stok
CREATE TABLE IF NOT EXISTS `pengurangan_stok` (
  `idpengurangan_stok` int(11) NOT NULL AUTO_INCREMENT,
  `idstok` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idpengurangan_stok`) USING BTREE,
  KEY `FK_pengurang_stok_stok` (`idstok`),
  CONSTRAINT `FK_pengurang_stok_stok` FOREIGN KEY (`idstok`) REFERENCES `stok` (`idstok`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.pengurangan_stok: ~0 rows (approximately)
/*!40000 ALTER TABLE `pengurangan_stok` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengurangan_stok` ENABLE KEYS */;

-- Dumping structure for table master_kasir.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `idpenjualan` int(11) NOT NULL AUTO_INCREMENT,
  `faktur` char(50) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `real_total` float DEFAULT NULL,
  `bayar` float DEFAULT NULL,
  `pajak` float DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `status_bayar` int(11) DEFAULT '0',
  `status_dilayani` int(11) DEFAULT '0',
  `nama_kasir` char(50) DEFAULT NULL,
  `catatan` text,
  `order_by` char(50) DEFAULT 'xxx',
  `meja` char(50) DEFAULT NULL,
  `metode_bayar` char(50) DEFAULT NULL COMMENT 'CASH, OVO, LINK AJA, DANA',
  PRIMARY KEY (`idpenjualan`) USING BTREE,
  UNIQUE KEY `faktur` (`faktur`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.penjualan: ~0 rows (approximately)
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
/*!40000 ALTER TABLE `penjualan` ENABLE KEYS */;

-- Dumping structure for table master_kasir.stok
CREATE TABLE IF NOT EXISTS `stok` (
  `idstok` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `jumlah_stok` int(11) DEFAULT '0',
  `satuan` char(50) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `keterangan_stok` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idstok`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.stok: ~0 rows (approximately)
/*!40000 ALTER TABLE `stok` DISABLE KEYS */;
/*!40000 ALTER TABLE `stok` ENABLE KEYS */;

-- Dumping structure for table master_kasir.toko
CREATE TABLE IF NOT EXISTS `toko` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(80) CHARACTER SET utf8mb4 DEFAULT NULL,
  `nama_pemilik` varchar(80) CHARACTER SET utf8mb4 DEFAULT NULL,
  `no_telepon` varchar(15) CHARACTER SET utf8mb4 DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `logo_struk` varchar(255) DEFAULT NULL,
  `footer_struk` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.toko: ~0 rows (approximately)
/*!40000 ALTER TABLE `toko` DISABLE KEYS */;
INSERT INTO `toko` (`id`, `nama_toko`, `nama_pemilik`, `no_telepon`, `alamat`, `logo`, `icon`, `logo_struk`, `footer_struk`) VALUES
	(1, 'Natural Coffe Shop', 'pemilik2', '08117925268', 'Jln. Ahmad Yani no. 88', '11022021085618_coffeelogopng7525.png', '11022021085645_coffeelogopng752516x16.ico', '11022021085315_coffeelogopng7525.png', 'Terimakasih atas kunjungannya\r\nSalam kopi');
/*!40000 ALTER TABLE `toko` ENABLE KEYS */;

-- Dumping structure for table master_kasir.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(50) DEFAULT NULL,
  `password` text NOT NULL,
  `name` text,
  `phone` char(50) DEFAULT NULL,
  `email` char(75) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` char(50) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `role` char(50) DEFAULT NULL COMMENT 'admin, pegawai,kasir,',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table master_kasir.users: ~6 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `phone`, `email`, `date_add`, `add_by`, `status`, `role`) VALUES
	(1, 'sishouadmin', 'ec8fc6483084bbdd13c45969a4437914', 'sishouadmin', '088217925268', 'sishouadmin@gmail.com', '2021-02-05 07:31:27', NULL, 1, 'sishouadmin'),
	(2, 'admin1', '2e33a9b0b06aa0a01ede70995674ee23', 'admin1', NULL, '', '2021-02-09 12:21:26', '1', 1, 'admin'),
	(3, 'pegawai1', '8925b2198d2f788ac336e0314cafd7bb', 'pegawai1', NULL, '', '2021-02-09 12:21:53', '1', 1, 'pegawai'),
	(4, 'kasir1', '93f2521b5b730c5f76f86f40fb1887cb', 'kasir kerajaan', '088217925268', 'kasir1@gmail.com', '2021-02-09 12:22:16', '1', 1, 'kasir'),
	(6, 'kasir2', '8c86013d8ba23d9b5ade4d6463f81c45', 'kasir2', '088217925268', 'kasir2@gmail.com', '2021-02-09 12:54:40', '5', 1, 'kasir');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
