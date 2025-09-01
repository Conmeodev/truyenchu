-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 31, 2025 lúc 04:33 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webtruyen`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `matkhau` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `ten`, `email`, `matkhau`, `avatar`, `role_id`) VALUES
(1, 'admin', 'stackskill2@gmail.com', '123456', NULL, 1),
(2, 'dev', 'daylanoidungkhongcotaht', '123456', NULL, 2),
(8, 'dev', 'daylanoidungkhongcotaht', '123456', NULL, 2),
(9, 'dev', 'daylanoidungkhongcotaht', '123456', NULL, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_anhtrangbia`
--

CREATE TABLE `tbl_anhtrangbia` (
  `id_anhtrangbia` int(11) NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `thutu` int(11) NOT NULL,
  `tinhtrang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_binhluan`
--

CREATE TABLE `tbl_binhluan` (
  `id_binhluan` int(11) NOT NULL,
  `noidung` text DEFAULT NULL,
  `ngaybinhluan` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_truyen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_chuong`
--

CREATE TABLE `tbl_chuong` (
  `id_chuong` int(11) NOT NULL,
  `tenchuong` varchar(255) NOT NULL,
  `noidung` text DEFAULT NULL,
  `sochuong` int(11) DEFAULT NULL,
  `thoigian` datetime DEFAULT NULL,
  `id_truyen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_danhgia`
--

CREATE TABLE `tbl_danhgia` (
  `id_danhgia` int(11) NOT NULL,
  `id_truyen` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `noidung` text NOT NULL,
  `ngaydanhgia` datetime DEFAULT NULL,
  `tinhcach` float DEFAULT NULL,
  `cottruyen` float DEFAULT NULL,
  `bocuc` float DEFAULT NULL,
  `chatluong` float DEFAULT NULL,
  `tongdiem` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_reading_status`
--

CREATE TABLE `tbl_reading_status` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_truyen` int(11) DEFAULT NULL,
  `id_chuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_theloai`
--

CREATE TABLE `tbl_theloai` (
  `id_theloai` int(11) NOT NULL,
  `tentheloai` varchar(255) DEFAULT NULL,
  `thutu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_truyen`
--

CREATE TABLE `tbl_truyen` (
  `id_truyen` int(11) NOT NULL,
  `tieude` varchar(255) DEFAULT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `tomtat` text NOT NULL,
  `tacgia` varchar(255) NOT NULL,
  `ngaydang` datetime DEFAULT NULL,
  `status_tt` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `luotdoc` int(11) DEFAULT 0,
  `decu` int(11) NOT NULL,
  `yeuthich` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_truyen_theloai`
--

CREATE TABLE `tbl_truyen_theloai` (
  `id_truyen_theloai` int(11) NOT NULL,
  `id_truyen` int(11) DEFAULT NULL,
  `id_theloai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `tenuser` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `matkhau` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `ngaysinh` varchar(255) DEFAULT NULL,
  `sodienthoai` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Chỉ mục cho bảng `tbl_anhtrangbia`
--
ALTER TABLE `tbl_anhtrangbia`
  ADD PRIMARY KEY (`id_anhtrangbia`);

--
-- Chỉ mục cho bảng `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  ADD PRIMARY KEY (`id_binhluan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_truyen` (`id_truyen`);

--
-- Chỉ mục cho bảng `tbl_chuong`
--
ALTER TABLE `tbl_chuong`
  ADD PRIMARY KEY (`id_chuong`),
  ADD KEY `id_truyen` (`id_truyen`);

--
-- Chỉ mục cho bảng `tbl_danhgia`
--
ALTER TABLE `tbl_danhgia`
  ADD PRIMARY KEY (`id_danhgia`),
  ADD KEY `id_truyen` (`id_truyen`),
  ADD KEY `id_user` (`id_user`);

--
-- Chỉ mục cho bảng `tbl_reading_status`
--
ALTER TABLE `tbl_reading_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reading_status` (`id_user`,`id_truyen`),
  ADD KEY `id_truyen` (`id_truyen`),
  ADD KEY `id_chuong` (`id_chuong`);

--
-- Chỉ mục cho bảng `tbl_theloai`
--
ALTER TABLE `tbl_theloai`
  ADD PRIMARY KEY (`id_theloai`);

--
-- Chỉ mục cho bảng `tbl_truyen`
--
ALTER TABLE `tbl_truyen`
  ADD PRIMARY KEY (`id_truyen`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Chỉ mục cho bảng `tbl_truyen_theloai`
--
ALTER TABLE `tbl_truyen_theloai`
  ADD PRIMARY KEY (`id_truyen_theloai`),
  ADD KEY `id_truyen` (`id_truyen`),
  ADD KEY `id_theloai` (`id_theloai`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `tbl_anhtrangbia`
--
ALTER TABLE `tbl_anhtrangbia`
  MODIFY `id_anhtrangbia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  MODIFY `id_binhluan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_chuong`
--
ALTER TABLE `tbl_chuong`
  MODIFY `id_chuong` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_danhgia`
--
ALTER TABLE `tbl_danhgia`
  MODIFY `id_danhgia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_reading_status`
--
ALTER TABLE `tbl_reading_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_theloai`
--
ALTER TABLE `tbl_theloai`
  MODIFY `id_theloai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_truyen`
--
ALTER TABLE `tbl_truyen`
  MODIFY `id_truyen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_truyen_theloai`
--
ALTER TABLE `tbl_truyen_theloai`
  MODIFY `id_truyen_theloai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  ADD CONSTRAINT `tbl_binhluan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`),
  ADD CONSTRAINT `tbl_binhluan_ibfk_2` FOREIGN KEY (`id_truyen`) REFERENCES `tbl_truyen` (`id_truyen`);

--
-- Các ràng buộc cho bảng `tbl_chuong`
--
ALTER TABLE `tbl_chuong`
  ADD CONSTRAINT `tbl_chuong_ibfk_1` FOREIGN KEY (`id_truyen`) REFERENCES `tbl_truyen` (`id_truyen`);

--
-- Các ràng buộc cho bảng `tbl_danhgia`
--
ALTER TABLE `tbl_danhgia`
  ADD CONSTRAINT `tbl_danhgia_ibfk_1` FOREIGN KEY (`id_truyen`) REFERENCES `tbl_truyen` (`id_truyen`),
  ADD CONSTRAINT `tbl_danhgia_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`);

--
-- Các ràng buộc cho bảng `tbl_reading_status`
--
ALTER TABLE `tbl_reading_status`
  ADD CONSTRAINT `tbl_reading_status_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`),
  ADD CONSTRAINT `tbl_reading_status_ibfk_2` FOREIGN KEY (`id_truyen`) REFERENCES `tbl_truyen` (`id_truyen`),
  ADD CONSTRAINT `tbl_reading_status_ibfk_3` FOREIGN KEY (`id_chuong`) REFERENCES `tbl_chuong` (`id_chuong`);

--
-- Các ràng buộc cho bảng `tbl_truyen`
--
ALTER TABLE `tbl_truyen`
  ADD CONSTRAINT `tbl_truyen_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `tbl_admin` (`id_admin`);

--
-- Các ràng buộc cho bảng `tbl_truyen_theloai`
--
ALTER TABLE `tbl_truyen_theloai`
  ADD CONSTRAINT `tbl_truyen_theloai_ibfk_1` FOREIGN KEY (`id_truyen`) REFERENCES `tbl_truyen` (`id_truyen`),
  ADD CONSTRAINT `tbl_truyen_theloai_ibfk_2` FOREIGN KEY (`id_theloai`) REFERENCES `tbl_theloai` (`id_theloai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
