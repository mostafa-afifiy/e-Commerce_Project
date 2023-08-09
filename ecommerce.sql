-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2023 at 06:24 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ordaring` int(11) DEFAULT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT 0,
  `allow_comment` tinyint(4) NOT NULL DEFAULT 0,
  `allow_ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `ordaring`, `visibility`, `allow_comment`, `allow_ads`) VALUES
(13, 'PC Device', 'PC Device from HP company', 3, 1, 0, 0),
(14, 'iPhone', 'Mobile from Apple company', 1, 0, 0, 0),
(15, 'Labtop', 'Laptop from Apple company', 5, 1, 0, 1),
(17, 'Dell', 'Laptop from Dell company', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `com_date` date NOT NULL,
  `com_status` tinyint(1) NOT NULL DEFAULT 0,
  `com_from_user` int(11) NOT NULL,
  `com_to_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `country` varchar(50) NOT NULL,
  `price` varchar(20) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `item_date` date NOT NULL,
  `item_status` varchar(30) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `country`, `price`, `category`, `image`, `item_date`, `item_status`, `approve`) VALUES
(27, 'uuuuuuuu', 'ljklnlk lkj;l ;lkjoin;o ;lkjon ;lknoln', 'egypt', '23$', 'laptop', '../../uploads/images/232690826903483147815078159.png', '2023-08-03', 'very old', 1),
(29, 'new_item28', 'ljklnlk lkj;l ;lkjoin;o ;lkjon ;lknoln', 'egypt', '2300$', 'pc', './uploads/images/2381608816046231356125624.jpg', '2023-08-04', 'like new', 1),
(30, 'new_item2', 'ljklnlk lkj;l ;lkjoin;o ;lkjon ;lknoln', 'egypt', '2500$', 'pc', './uploads/images/232920829204150101344913455.jpg', '2023-08-04', 'like new', 1),
(35, 'ipad 54', 'Mobile from Apple company', 'egypt', '2500$', 'iPhone', './uploads/images/238740887408196086660966606.png', '2023-08-04', 'like new', 1),
(36, 'mac book', 'Laptop from Apple company', 'egypt', '2500$', 'Labtop', './uploads/images/2358908589089120862346229.jpg', '2023-08-08', 'new', 1),
(37, 'Iphone 11 Pro', 'Mobile from Apple company', 'egypt', '1500$', 'iPhone', './uploads/images/238500885008979081254612557.png', '2023-08-08', 'new', 1),
(38, 'Dell Laptop', 'Laptop from Dell company', 'egypt', '2300$', 'Labtop', './uploads/images/2396708967088730918031830.jpg', '2023-08-08', 'new', 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `likes` int(11) DEFAULT NULL,
  `dis_likes` int(11) DEFAULT NULL,
  `like_status` tinyint(1) DEFAULT 0 COMMENT 'for user',
  `dis_like_status` tinyint(1) DEFAULT 0 COMMENT 'for user',
  `like_from_user` int(11) NOT NULL,
  `like_to_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reg_time` datetime NOT NULL,
  `pass` varchar(500) NOT NULL,
  `group_id` tinyint(4) DEFAULT 0,
  `reg_status` tinyint(4) DEFAULT 0,
  `trust_status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `email`, `reg_time`, `pass`, `group_id`, `reg_status`, `trust_status`) VALUES
(1, 'Mostafa Amer', 'mostafa', 'mostafaamer2500@gmail.com', '2023-07-26 15:51:00', '$2y$10$Jj2x8lnPpk2FmaOim3Tb7u2xvpUfsDwfUqJHB4a4cd1TRittyXDq2', 1, 1, 1),
(2, 'Mostafa Amer', 'MostafaAmer', 'mostafaamer25080@gmail.com', '2023-07-26 16:04:15', '$2y$10$blB0i.NubY.sK.pgrJra9.nod97P98UtGtn9s4XmJ9CyP3yGYVD0G', 0, 1, 0),
(3, 'Mostafa Amer', 'mostafa1', 'mostafaamer2500k@gmail.com', '2023-07-26 16:22:48', '$2y$10$.h3La9Dckxy/bafs4APlXua4oTkrCxwsHcvKqJyUazvgFWstr996S', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `com_from_user` (`com_from_user`),
  ADD KEY `com_to_item` (`com_to_item`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `idx_name` (`name`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `like_from_user` (`like_from_user`),
  ADD KEY `like_to_item` (`like_to_item`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`com_from_user`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`com_to_item`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`like_from_user`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`like_to_item`) REFERENCES `items` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
