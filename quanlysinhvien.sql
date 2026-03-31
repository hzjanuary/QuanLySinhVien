-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 02:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlysinhvien`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL COMMENT 'Khóa học',
  `class_name` varchar(50) DEFAULT NULL COMMENT 'Tên lớp',
  `major` varchar(100) DEFAULT NULL COMMENT 'Ngành học'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `phone`, `avatar`, `course`, `class_name`, `major`) VALUES
(5, 'Vo Anh Nghia', 'vo.anh.nghia@tdu.edu.com', '227060084', NULL, NULL, NULL, NULL),
(6, 'Huynh Nhat Anh', 'huynh.nhat.anh@tdu.edu.com', '227060085', NULL, NULL, NULL, NULL),
(8, 'Nguyen Bao Khang', 'nguyen.bao.khang@tdu.edu.com', '227060087', NULL, NULL, NULL, NULL),
(9, 'Luu Quoc Thai', 'luu.quoc.thai@tdu.edu.com', '227060088', NULL, NULL, NULL, NULL),
(10, 'Nguyen Duy Manh', 'nguyen.duy.manh@tdu.edu.com', '227060089', NULL, NULL, NULL, NULL),
(11, 'Tran Han Minh', 'tran.han.minh@tdu.edu.com', '227060090', NULL, NULL, NULL, NULL),
(12, 'Le Thi Nhu Y', 'le.thi.nhu.y@tdu.edu.com', '227060091', NULL, NULL, NULL, NULL),
(13, 'Vo Thanh Trung', 'vo.thanh.trung@tdu.edu.com', '227060092', NULL, NULL, NULL, NULL),
(14, 'Tran Tan Loc', 'tran.tan.loc@tdu.edu.com', '227060093', NULL, NULL, NULL, NULL),
(15, 'Nguyen Huy Hoang', 'nguyen.huy.hoang@tdu.edu.com', '227060096', NULL, NULL, NULL, NULL),
(16, 'Nguyen Huy Phong', 'nguyen.huy.phong@tdu.edu.com', '227060098', NULL, NULL, NULL, NULL),
(17, 'Mai Huu Tai', 'mai.huu.tai@tdu.edu.com', '227060099', NULL, NULL, NULL, NULL),
(18, 'Huynh Thanh Hiep', 'huynh.thanh.hiep@tdu.edu.com', '227060100', NULL, NULL, NULL, NULL),
(19, 'Le Quoc Cuong', 'le.quoc.cuong@tdu.edu.com', '227060101', NULL, NULL, NULL, NULL),
(20, 'Dao Nhat Tuyen', 'dao.nhat.tuyen@tdu.edu.com', '227060102', NULL, NULL, NULL, NULL),
(21, 'Nguyen Ha Quyen', 'nguyen.ha.quyen@tdu.edu.com', '227060103', NULL, NULL, NULL, NULL),
(22, 'Le Tuan Khanh', 'le.tuan.khanh@tdu.edu.com', '227060104', NULL, NULL, NULL, NULL),
(23, 'Vo Du Thanh Tu', 'vo.du.thanh.tu@tdu.edu.com', '227060105', NULL, NULL, NULL, NULL),
(24, 'Tran Van Hieu', 'tran.van.hieu@tdu.edu.com', '227060106', NULL, NULL, NULL, NULL),
(25, 'Nguyen Tan Linh', 'nguyen.tan.linh@tdu.edu.com', '227060107', NULL, NULL, NULL, NULL),
(26, 'Ta Thai Nguyen', 'ta.thai.nguyen@tdu.edu.com', '227060108', NULL, NULL, NULL, NULL),
(27, 'Le Tri Nien', 'le.tri.nien@tdu.edu.com', '227060109', NULL, NULL, NULL, NULL),
(28, 'Lu Ho Gia Huy', 'lu.ho.gia.huy@tdu.edu.com', '227060110', NULL, NULL, NULL, NULL),
(29, 'Le Nhut Le', 'le.nhut.le@tdu.edu.com', '227060111', NULL, NULL, NULL, NULL),
(30, 'Huynh Duy Thien An', 'huynh.duy.thien.an@tdu.edu.com', '227060113', NULL, NULL, NULL, NULL),
(31, 'Tang Quoc Dat', 'tang.quoc.dat@tdu.edu.com', '227060114', NULL, NULL, NULL, NULL),
(32, 'Tran Minh Tan', 'tran.minh.tan@tdu.edu.com', '227060115', NULL, NULL, NULL, NULL),
(33, 'Le Du', 'le.du@tdu.edu.com', '227060117', NULL, NULL, NULL, NULL),
(34, 'Duong Van Qui', 'duong.van.qui@tdu.edu.com', '227060119', NULL, NULL, NULL, NULL),
(35, 'Nguyen Thai Hoa', 'nguyen.thai.hoa@tdu.edu.com', '227060120', NULL, NULL, NULL, NULL),
(36, 'Huynh Van Hai', 'huynh.van.hai@tdu.edu.com', '227060121', NULL, NULL, NULL, NULL),
(37, 'Nguyen The Sang', 'nguyen.the.sang@tdu.edu.com', '227060122', NULL, NULL, NULL, NULL),
(38, 'Tran Thuy Canh Van', 'tran.thuy.canh.van@tdu.edu.com', '227060124', NULL, NULL, NULL, NULL),
(39, 'Lu Van Tinh', 'lu.van.tinh@tdu.edu.com', '227060125', NULL, NULL, NULL, NULL),
(40, 'Mai Van Luan', 'mai.van.luan@tdu.edu.com', '227060126', NULL, NULL, NULL, NULL),
(41, 'Trinh Dang Khoa', 'trinh.dang.khoa@tdu.edu.com', '227060127', NULL, NULL, NULL, NULL),
(42, 'Tran Thi Hong Phan', 'tran.thi.hong.phan@tdu.edu.com', '227060128', NULL, NULL, NULL, NULL),
(43, 'Vo Gia Long', 'vo.gia.long@tdu.edu.com', '227060129', NULL, NULL, NULL, NULL),
(44, 'Nguyen Quyet An', 'nguyen.quyet.an@tdu.edu.com', '227060131', NULL, NULL, NULL, NULL),
(45, 'Nguyen Hong Ngoc', 'nguyen.hong.ngoc@tdu.edu.com', '227060132', NULL, NULL, NULL, NULL),
(46, 'Ho Chi Tuong', 'ho.chi.tuong@tdu.edu.com', '227060133', NULL, NULL, NULL, NULL),
(47, 'Tran Dang Khoi', 'tran.dang.khoi@tdu.edu.com', '227060134', NULL, NULL, NULL, NULL),
(48, 'Nguyen Binh Phu Thinh', 'nguyen.binh.phu.thinh@tdu.edu.com', '227060135', NULL, NULL, NULL, NULL),
(49, 'Nguyen Tri Tam', 'nguyen.tri.tam@tdu.edu.com', '227060136', NULL, NULL, NULL, NULL),
(50, 'Duong Hong Phat', 'duong.hong.phat@tdu.edu.com', '227060139', NULL, NULL, NULL, NULL),
(51, 'Huynh Ba Viet Tin', 'huynh.ba.viet.tin@tdu.edu.com', '227060140', NULL, NULL, NULL, NULL),
(52, 'Le Duc Nhanh', 'le.duc.nhanh@tdu.edu.com', '227060141', NULL, NULL, NULL, NULL),
(53, 'Le Kieu My', 'le.kieu.my@tdu.edu.com', '227060142', NULL, NULL, NULL, NULL),
(54, 'Truong Thanh Thong', 'truong.thanh.thong@tdu.edu.com', '227060144', NULL, NULL, NULL, NULL),
(55, 'Luong Trieu Vi', 'luong.trieu.vi@tdu.edu.com', '227060145', NULL, NULL, NULL, NULL),
(56, 'Nguyen Trung Kien', 'nguyen.trung.kien@tdu.edu.com', '227060146', NULL, NULL, NULL, NULL),
(57, 'Lam Van Khoe', 'lam.van.khoe@tdu.edu.com', '227060147', NULL, NULL, NULL, NULL),
(58, 'Nguyen Tuan Em', 'nguyen.tuan.em@tdu.edu.com', '227060148', NULL, NULL, NULL, NULL),
(59, 'Le Thai Binh', 'le.thai.binh@tdu.edu.com', '227060149', NULL, NULL, NULL, NULL),
(60, 'Nguyen Huu Loc', 'nguyen.huu.loc@tdu.edu.com', '227060150', NULL, NULL, NULL, NULL),
(61, 'Phan Nguyen Huu Loc', 'phan.nguyen.huu.loc@tdu.edu.com', '227060151', NULL, NULL, NULL, NULL),
(62, 'Do Thanh Do', 'do.thanh.do@tdu.edu.com', '227060152', NULL, NULL, NULL, NULL),
(63, 'Nguyen Manh Dinh', 'nguyen.manh.dinh@tdu.edu.com', '227060153', NULL, NULL, NULL, NULL),
(64, 'Nguyen Khanh Duy', 'nguyen.khanh.duy@tdu.edu.com', '227060154', NULL, NULL, NULL, NULL),
(65, 'Tran Thanh Long', 'tran.thanh.long@tdu.edu.com', '227060157', NULL, NULL, NULL, NULL),
(66, 'Nguyen Thanh Phuc', 'nguyen.thanh.phuc@tdu.edu.com', '227060158', NULL, NULL, NULL, NULL),
(67, 'Dinh Van Long', 'dinh.van.long@tdu.edu.com', '227060159', NULL, NULL, NULL, NULL),
(68, 'Le Tuan Kiet', 'le.tuan.kiet@tdu.edu.com', '227060160', NULL, NULL, NULL, NULL),
(69, 'Tran Van Kha', 'tran.van.kha@tdu.edu.com', '227060161', NULL, NULL, NULL, NULL),
(70, 'Huynh Gia Nguyen', 'huynh.gia.nguyen@tdu.edu.com', '227060163', NULL, NULL, NULL, NULL),
(71, 'Ma Quoc Quy', 'ma.quoc.quy@tdu.edu.com', '227060165', NULL, NULL, NULL, NULL),
(72, 'Tran Pham Cong Minh', 'tran.pham.cong.minh@tdu.edu.com', '227060166', NULL, NULL, NULL, NULL),
(73, 'Ly Chi Cuong', 'ly.chi.cuong@tdu.edu.com', '227060177', NULL, NULL, NULL, NULL),
(75, 'Vo Ho Quoc Huy', 'quochuy@tdu.edu.vn', '227060086', '69c8906292519-maxresdefault.jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `created_at`) VALUES
(3, 'Hoang', 'admin', '$2y$10$xhR7pgYfdSf.NF9p9kkmA.a34AKiV43P.rY6Gb9S7eA1KMOgPOFR.', '2026-03-29 01:46:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
