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


-- Dumping database structure for kasirqu
CREATE DATABASE IF NOT EXISTS `kasirqu` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `kasirqu`;

-- Dumping structure for table kasirqu.akun
CREATE TABLE IF NOT EXISTS `akun` (
  `idakun` int(11) NOT NULL AUTO_INCREMENT,
  `akun` char(50) DEFAULT NULL,
  `hapus` int(11) DEFAULT '1',
  PRIMARY KEY (`idakun`),
  UNIQUE KEY `akun` (`akun`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.akun: ~2 rows (approximately)
/*!40000 ALTER TABLE `akun` DISABLE KEYS */;
INSERT INTO `akun` (`idakun`, `akun`, `hapus`) VALUES
	(1, 'PENJUALAN', 0),
	(2, 'PEMBELIAN', 0),
	(3, 'LISTRIK', 1),
	(4, 'AIR PDAM', 1),
	(5, 'GAJI KARYAWAN', 1),
	(6, 'PERAWATAN', 1);
/*!40000 ALTER TABLE `akun` ENABLE KEYS */;

-- Dumping structure for table kasirqu.item_pembelian
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.item_pembelian: ~2 rows (approximately)
/*!40000 ALTER TABLE `item_pembelian` DISABLE KEYS */;
INSERT INTO `item_pembelian` (`iditem_pembelian`, `idpembelian`, `idstok`, `jumlah`, `harga`) VALUES
	(5, 10, 3, 10, 100000),
	(6, 11, 3, 10, 100000);
/*!40000 ALTER TABLE `item_pembelian` ENABLE KEYS */;

-- Dumping structure for table kasirqu.item_penjualan
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.item_penjualan: ~4 rows (approximately)
/*!40000 ALTER TABLE `item_penjualan` DISABLE KEYS */;
INSERT INTO `item_penjualan` (`iditem_penjualan`, `faktur`, `idmenu`, `harga`, `diskon`, `jumlah`) VALUES
	(8, '2102-00001I', 5, 25000, NULL, 2),
	(9, '2102-00001I', 6, 25000, NULL, 1),
	(10, '2102-00003H', 5, 25000, NULL, 2);
/*!40000 ALTER TABLE `item_penjualan` ENABLE KEYS */;

-- Dumping structure for table kasirqu.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `idkategori` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` char(50) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `keterangan_kategori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idkategori`) USING BTREE,
  UNIQUE KEY `kategori` (`kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.kategori: ~3 rows (approximately)
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` (`idkategori`, `kategori`, `date_add`, `add_by`, `keterangan_kategori`) VALUES
	(1, 'Coffee', '2021-02-07 15:08:52', 1, '-'),
	(2, 'Non - Coffee', '2021-02-07 15:08:56', 1, '-'),
	(7, 'Cemilan', '2021-02-07 15:30:51', 1, '-');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;

-- Dumping structure for table kasirqu.keuangan
CREATE TABLE IF NOT EXISTS `keuangan` (
  `idkeuangan` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `faktur` char(50) DEFAULT NULL,
  `nama_akun` char(50) DEFAULT NULL,
  `jenis` char(50) DEFAULT NULL,
  `debit` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `idpembelian` int(11) DEFAULT NULL,
  PRIMARY KEY (`idkeuangan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.keuangan: ~5 rows (approximately)
/*!40000 ALTER TABLE `keuangan` DISABLE KEYS */;
INSERT INTO `keuangan` (`idkeuangan`, `tanggal`, `faktur`, `nama_akun`, `jenis`, `debit`, `kredit`, `date_add`, `add_by`, `idpembelian`) VALUES
	(1, '2021-02-12', '2102-00002I', 'PENJUALAN', 'PEMASUKAN', 75000, NULL, '2021-02-12 20:22:07', 1, NULL),
	(2, '2021-02-12', '2102-00003H', 'PENJUALAN', 'PEMASUKAN', 50000, NULL, '2021-02-12 20:27:11', 1, NULL),
	(3, '2021-02-13', 'ABC-AAA', 'PEMBELIAN', 'PENGELUARAN', NULL, 100000, '2021-02-13 12:22:57', 1, 1),
	(4, '2021-02-13', 'ABC-AAA', 'PEMBELIAN', 'PENGELUARAN', NULL, 200000, '2021-02-13 12:24:50', 1, 2),
	(5, '2021-02-13', 'ABC-AAA', 'PEMBELIAN', 'PENGELUARAN', NULL, 200000, '2021-02-13 12:29:13', 1, 6),
	(7, '2021-02-13', 'ABC-AA2', 'PEMBELIAN', 'PENGELUARAN', NULL, 200000, '2021-02-13 12:32:40', 1, 10),
	(8, '2021-02-13', 'ABC-AA3', 'PEMBELIAN', 'PENGELUARAN', NULL, 100000, '2021-02-13 13:39:06', 1, 11);
/*!40000 ALTER TABLE `keuangan` ENABLE KEYS */;

-- Dumping structure for table kasirqu.menu
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

-- Dumping data for table kasirqu.menu: ~16 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`idmenu`, `idkategori`, `menu`, `harga`, `diskon`, `date_add`, `date_update`, `add_by`, `keterangan_menu`, `status`, `foto`) VALUES
	(5, 1, 'Brown Coffe', 25000, NULL, '2021-02-07 19:51:03', '2021-02-11 13:21:12', 1, '-', 1, '11022021132111_Brown_Coffe.jpg'),
	(6, 1, 'Black Coffe', 25000, NULL, '2021-02-07 19:51:47', '2021-02-11 12:03:34', 1, '-', 1, '11022021120334_Blackcoffeefeatureimage.jpg'),
	(7, 1, 'Americano', 25000, NULL, '2021-02-07 19:52:00', '2021-02-11 13:21:49', 1, '-', 1, '11022021132148_AmericanoCoffeeLoungeIngredients.jpg'),
	(8, 1, 'Espresso', 20000, NULL, '2021-02-11 13:22:37', '2021-02-11 13:22:37', 1, '-', 1, '11022021132237_3Tinyglasscupofespressocoffee.jpg'),
	(9, 1, 'Latte', 20000, NULL, '2021-02-11 13:23:27', '2021-02-11 13:23:27', 1, '-', 1, '11022021132327_latteartinayellowcuponamarbletableroyaltyfreeimage1592427210.jpg'),
	(10, 1, 'Cappucino', 25000, NULL, '2021-02-11 13:24:22', '2021-02-11 13:24:22', 1, '-', 1, '11022021132422_cappucino.jpg'),
	(11, 1, 'Milk Coffee', 25000, NULL, '2021-02-11 13:24:51', '2021-02-11 13:24:51', 1, '-', 1, '11022021132451_Coffeewithmilk563800.jpg'),
	(12, 1, 'Whitte Coffe', 20000, NULL, '2021-02-11 13:29:55', '2021-02-12 20:32:02', 1, '-', 1, '11022021132955_WhiteCoffee1280x720.jpg'),
	(13, 2, 'Milk Tea', 20000, NULL, '2021-02-11 13:30:32', '2021-02-11 13:30:32', 1, '-', 1, '11022021133032_coffeemilktea85141170x550.jpg'),
	(14, 2, 'Thai tea', 20000, NULL, '2021-02-11 13:31:10', '2021-02-11 13:31:10', 1, '-', 1, '11022021133110_thai_tea.jpg'),
	(15, 2, 'Matcha', 25000, NULL, '2021-02-11 13:32:57', '2021-02-11 13:32:57', 1, '-', 1, '11022021133257_matchalatte31of1.jpg'),
	(16, 2, 'Hot Tea', 10000, NULL, '2021-02-11 13:33:24', '2021-02-11 13:33:24', 1, '-', 1, '11022021133324_kfcwebhotteaenglishbreakfastl.png'),
	(17, 2, 'Creamy Choco', 20000, NULL, '2021-02-11 13:33:46', '2021-02-11 13:33:46', 1, '-', 1, '11022021133346_HotChocolateC.jpg'),
	(18, 7, 'Singkong Goreng', 15000, NULL, '2021-02-11 13:34:08', '2021-02-11 13:34:08', 1, '-', 1, '11022021133408_singkong.jpg'),
	(19, 7, 'Pisang Goreng', 15000, NULL, '2021-02-11 13:34:27', '2021-02-11 13:34:27', 1, '-', 1, '11022021133427_pisanggorengkriukdanrenyah.jpg'),
	(20, 7, 'Cireng', 10000, NULL, '2021-02-11 13:34:50', '2021-02-11 13:34:50', 1, '-', 1, '11022021133450_28cirengacidigorengfotoreseputama.jpg');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table kasirqu.pembelian
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.pembelian: ~3 rows (approximately)
/*!40000 ALTER TABLE `pembelian` DISABLE KEYS */;
INSERT INTO `pembelian` (`idpembelian`, `faktur_pembelian`, `tanggal`, `date_add`, `add_by`, `total`, `biaya_tambahan`, `catatan`) VALUES
	(10, 'ABC-AA2', '2021-02-13', '2021-02-13 12:32:40', 1, 200000, 100000, '-'),
	(11, 'ABC-AA3', '2021-02-12', '2021-02-13 13:39:06', 1, 100000, 0, '-');
/*!40000 ALTER TABLE `pembelian` ENABLE KEYS */;

-- Dumping structure for table kasirqu.pengurangan_stok
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.pengurangan_stok: ~6 rows (approximately)
/*!40000 ALTER TABLE `pengurangan_stok` DISABLE KEYS */;
INSERT INTO `pengurangan_stok` (`idpengurangan_stok`, `idstok`, `jumlah`, `date_add`, `add_by`, `keterangan`) VALUES
	(2, 5, 3, '2021-02-10 11:27:00', 1, NULL),
	(3, 5, 5, '2021-02-10 11:29:00', 1, NULL),
	(4, 5, 5, '2021-02-10 11:34:00', 1, '-'),
	(5, 5, 5, '2021-02-10 14:46:00', 1, '-'),
	(6, 3, 3, '2021-02-10 14:48:00', 1, '-'),
	(7, 5, 2, '2021-02-10 15:12:00', 1, '-'),
	(8, 3, 1, '2021-02-10 15:13:00', 1, '-');
/*!40000 ALTER TABLE `pengurangan_stok` ENABLE KEYS */;

-- Dumping structure for table kasirqu.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `idpenjualan` int(11) NOT NULL AUTO_INCREMENT,
  `faktur` char(50) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `bayar` float DEFAULT NULL,
  `pajak` float DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `status_bayar` int(11) DEFAULT '0',
  `status_dilayani` int(11) DEFAULT '0',
  `nama_kasir` char(50) DEFAULT NULL,
  `catatan` text,
  `order_by` char(50) DEFAULT NULL,
  `meja` char(50) DEFAULT NULL,
  `metode_bayar` char(50) DEFAULT NULL COMMENT 'CASH, OVO, LINK AJA, DANA',
  PRIMARY KEY (`idpenjualan`) USING BTREE,
  UNIQUE KEY `faktur` (`faktur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.penjualan: ~3 rows (approximately)
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
INSERT INTO `penjualan` (`idpenjualan`, `faktur`, `total`, `bayar`, `pajak`, `diskon`, `date_add`, `add_by`, `status_bayar`, `status_dilayani`, `nama_kasir`, `catatan`, `order_by`, `meja`, `metode_bayar`) VALUES
	(6, '2102-00001I', 75000, 100000, NULL, NULL, '2021-02-12 20:22:07', 1, 1, 0, 'sishouadmin', '-', NULL, 'Meja 1', NULL),
	(7, '2102-00003H', 50000, 100000, NULL, NULL, '2021-02-12 20:27:11', 1, 1, 0, 'sishouadmin', '-', NULL, 'Meja 2', NULL);
/*!40000 ALTER TABLE `penjualan` ENABLE KEYS */;

-- Dumping structure for table kasirqu.stok
CREATE TABLE IF NOT EXISTS `stok` (
  `idstok` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `jumlah_stok` int(11) DEFAULT '0',
  `satuan` char(50) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `add_by` int(11) DEFAULT NULL,
  `keterangan_stok` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idstok`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table kasirqu.stok: ~2 rows (approximately)
/*!40000 ALTER TABLE `stok` DISABLE KEYS */;
INSERT INTO `stok` (`idstok`, `nama`, `jumlah_stok`, `satuan`, `date_add`, `add_by`, `keterangan_stok`) VALUES
	(3, 'Bahan 1', 36, 'Pcs', '2021-02-09 14:30:08', 5, '-'),
	(5, 'Bahan 3', 9980, 'Pcs', '2021-02-09 14:41:37', 5, '-');
/*!40000 ALTER TABLE `stok` ENABLE KEYS */;

-- Dumping structure for table kasirqu.toko
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

-- Dumping data for table kasirqu.toko: ~1 rows (approximately)
/*!40000 ALTER TABLE `toko` DISABLE KEYS */;
INSERT INTO `toko` (`id`, `nama_toko`, `nama_pemilik`, `no_telepon`, `alamat`, `logo`, `icon`, `logo_struk`, `footer_struk`) VALUES
	(1, 'Natural Coffe Shop', 'pemilik2', 'pemilik2', 'Jln. Ahmad Yani no. 88', '11022021085618_coffeelogopng7525.png', '11022021085645_coffeelogopng752516x16.ico', '11022021085315_coffeelogopng7525.png', 'Terimakasih atas kunjungannya');
/*!40000 ALTER TABLE `toko` ENABLE KEYS */;

-- Dumping structure for table kasirqu.users
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

-- Dumping data for table kasirqu.users: ~6 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `phone`, `email`, `date_add`, `add_by`, `status`, `role`) VALUES
	(1, 'sishouadmin', 'ec8fc6483084bbdd13c45969a4437914', 'sishouadmin', '088217925268', 'sishouadmin@gmail.com', '2021-02-05 07:31:27', NULL, 1, 'sishouadmin'),
	(2, 'admin1', 'ec8fc6483084bbdd13c45969a4437914', 'admin1', NULL, '', '2021-02-09 12:21:26', '1', 1, 'admin'),
	(3, 'pegawai1', 'ec8fc6483084bbdd13c45969a4437914', 'pegawai1', NULL, '', '2021-02-09 12:21:53', '1', 1, 'pegawai'),
	(4, 'kasir1', 'ec8fc6483084bbdd13c45969a4437914', 'kasir kerajaan', '088217925268', 'kasir1@gmail.com', '2021-02-09 12:22:16', '1', 1, 'kasir'),
	(5, 'Admineasy3', '60f6d54f711847f2b9318958eeea3909', 'Admineasy3', '088217925268', 'Admineasy3@gmail.com', '2021-02-09 12:42:15', '1', 1, 'admin'),
	(6, 'kasir2', '8c86013d8ba23d9b5ade4d6463f81c45', 'kasir2', '088217925268', 'kasir2@gmail.com', '2021-02-09 12:54:40', '5', 1, 'kasir');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
