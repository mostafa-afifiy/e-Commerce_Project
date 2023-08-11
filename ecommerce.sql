-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2023 at 06:08 AM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_date` date DEFAULT NULL,
  `quantity` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` smallint(6) NOT NULL,
  `name` varchar(100) NOT NULL,
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
(13, 'PC Device', 'PC Device from HP company', 3, 0, 0, 0),
(14, 'iPhone', 'Mobile from Apple company', 1, 0, 0, 0),
(15, 'Labtop', 'Laptop from Apple company', 5, 0, 0, 1),
(17, 'Dell', 'Laptop from Dell company', 1, 0, 1, 1),
(18, 'Mobiles', 'Mobile Phone From Trusted Companies', 22, 1, 1, 1),
(19, 'Electronics', 'Electronics Devices From Trusted Companies', 11, 1, 1, 1),
(20, 'Supermarket', 'Supermarket For Every Thing', 11111111, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `com_date` date NOT NULL,
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
  `category` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `item_date` date NOT NULL,
  `item_status` varchar(30) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `country`, `price`, `category`, `image`, `item_date`, `item_status`, `approve`) VALUES
(39, 'Iphone 14 Pro Max', '                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim ratione, cumque fugit rem id perspiciatis sint reprehenderit explicabo autem. Voluptates.', 'USA', '2500$', 'Mobiles', './uploads/images/2351408514107192073047350.jpg', '2023-08-10', 'new', 1),
(40, 'Iphone 14 plus', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'USA', '2500$', 'Mobiles', './uploads/images/2378508785117033232032306.jpg', '2023-08-11', 'new', 1),
(41, 'olive oil', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Egypt', '23$', 'Supermarket', './uploads/images/231850818511247031612616151.png', '2023-08-11', 'new', 1),
(42, 'Nescafe', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Egypt', '23$', 'Supermarket', './uploads/images/234000840011698034432844330.jpg', '2023-08-11', 'new', 1),
(43, 'Airbods', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Chana', '23$', 'Electronics', './uploads/images/235220852211174035833058312.jpg', '2023-08-11', 'new', 1),
(44, 'Camera 1', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Chana', '230$', 'Electronics', './uploads/images/238920889211810033673136715.jpg', '2023-08-11', 'used', 1),
(45, 'Camera 2', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Chana', '200$', 'Electronics', './uploads/images/231308131120032363223616.jpg', '2023-08-11', 'very old', 1),
(46, 'Camera 3', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Egypt', '290$', 'Electronics', './uploads/images/237240872411786037743377404.jpg', '2023-08-11', 'like new', 1),
(47, 'Oxi', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Egypt', '5$', 'Supermarket', './uploads/images/233210832111985031933419306.jpg', '2023-08-11', 'new', 1),
(48, 'Sumsung A12', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Chana', '1300$', 'Mobiles', './uploads/images/234960849611835036943569421.jpg', '2023-08-11', 'like new', 1),
(49, 'Ris', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus repellendus ab quisquam ipsam quaerat excepturi iusto cum. Nesciunt, et fugit.', 'Egypt', '3$', 'Supermarket', './uploads/images/237100871011831035423654239.jpg', '2023-08-11', 'new', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `reg_time` date NOT NULL,
  `pass` varchar(500) NOT NULL,
  `group_id` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `email`, `image`, `reg_time`, `pass`, `group_id`) VALUES
(1, 'Mostafa Amer', 'mostafa', 'mostafaamer2500@gmail.com', NULL, '2023-07-26', '$2y$10$Jj2x8lnPpk2FmaOim3Tb7u2xvpUfsDwfUqJHB4a4cd1TRittyXDq2', 1),
(2, 'Mostafa Amer', 'MostafaAmer', 'mostafaamer25080@gmail.com', NULL, '2023-07-26', '$2y$10$blB0i.NubY.sK.pgrJra9.nod97P98UtGtn9s4XmJ9CyP3yGYVD0G', 0),
(3, 'Mostafa Amer', 'mostafa1', 'mostafaamer2500k@gmail.com', NULL, '2023-07-26', '$2y$10$.h3La9Dckxy/bafs4APlXua4oTkrCxwsHcvKqJyUazvgFWstr996S', 0),
(4, 'mostafa amer', 'mostafa11', 'swsthelionanaa2500@gmail.com', '\n', '2023-08-09', '$2y$10$VJGb8JALSy9j28RYi1NvD.Dx3M6KKt3h6547/fUHE8svKgbkB7P02', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_2` (`name`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`com_from_user`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`com_to_item`) REFERENCES `items` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
