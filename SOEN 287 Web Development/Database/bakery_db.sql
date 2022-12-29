-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2020 at 09:51 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `precheckout`
--

CREATE TABLE `precheckout` (
  `id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL,
  `image` varchar(500) NOT NULL,
  `name` varchar(500) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `precheckout`
--

INSERT INTO `precheckout` (`id`, `quantity`, `image`, `name`, `price`) VALUES
(6, 1, 'test img 2.jpg', 'test name 2', 5),
(7, 2, 'test img 3.jpg', 'test name 16', 2),
(8, 3, 'test img.jpg', 'test name 16', 3);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `ingredients` varchar(250) NOT NULL,
  `type` varchar(69) NOT NULL DEFAULT 'misc',
  `url` varchar(255) NOT NULL DEFAULT 'under_construction.php'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `ingredients`, `type`, `url`) VALUES
(1, 'Almond Cookies', 'Almond cookies.jpg', 0.5, 'Wheat flour, eggs, lard, sugar, almonds', 'biscuit', 'Almond_Cookies.php'),
(2, 'Cheese Cake', 'Cheese cake.jpg', 1, 'Wheat flour, eggs, milk, cream cheese, margarine, cornstarch', 'cake', 'Cheese_Cake.php'),
(3, 'Chicken Biscuit', 'Chk bisc2.jpg', 0.5, 'Wheat flour, eggs, water, sugar, salt, maltose, oil, pork fat, red fermented bean curd, sesame seeds, garlic, onion', 'biscuit', 'Chicken_Biscuit.php'),
(4, 'Egg Tart', 'Egg tart.jpg', 1, 'Wheat flour, eggs, evaporated milk, sugar, water, butter, custard power', 'misc', 'Egg_Tart.php'),
(5, 'Guava Bites', 'Guava bites.jpg', 0.6, 'Wheat flour, eggs, condensed milk. powdered milk, guava paste', 'bites', 'Guava_Bites.php'),
(6, 'Coconut Mochi', 'Coconut mochi.jpg', 1, 'Rice flour, sugar, water, coconut, peanut', 'misc', 'Coconut_Mochi.php'),
(7, 'Pineapple Bites', 'Pineapple bites.jpg', 0.6, 'Wheat flour, eggs, condensed milk, powdered milk, pineapple', 'bites', 'Pineapple_Bites.php'),
(8, 'Pineapple Cake', 'Pineapple cake.jpg', 1, 'Wheat flour, eggs, milk, raisins, oil, pineapple', 'cake', 'Pineapple_Cake.php'),
(9, 'Tan Wong Su', 'Tan Wong.jpg', 1, 'Wheat flour, eggs, water, dough conditioner, vegetable oil, sugar, vegetable shortening, red bean paste, salted egg yolk', 'misc', 'Tan_Wong_Su.php'),
(10, 'Tau Sa Pen', 'Tau sa.jpg', 0.7, 'Wheat flour, eggs, lard, sugar, almonds', 'misc', 'Tau_Sa_Pen.php'),
(11, 'Pork Bun', 'Pork bun2.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, bbq pork', 'buns', 'Pork_Bun.php'),
(12, 'Red Bean Paste Bun', 'RBP22.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, red bean paste', 'buns', 'Red_Bean_Paste_Bun.php'),
(13, 'Coconut Bun', 'Coconut bun22.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, coconut', 'buns', 'Coconut_Bun.php'),
(14, 'Custard Bun', 'Custard bun.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, custard', 'buns', 'Custard_Bun.php');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `username`, `password`, `email`) VALUES
(1, 'JackSparow', 'ruum', 'jackruum@gmail.com'),
(2, 'johnwick3', '7Jgevbp4XMpu', 'johnwick69@johnwick.inc'),
(3, 'jacksparrow159', '7Jgevbp4XMpu', 'jacksparrow96@gmail.com'),
(4, 'madiro501', '7Jgevbp4XMpu', 'madiro501@gmail.com'),
(5, 'sdaf', '7Jgevbp4XMpu', 'jacksparrow96@gmail.com'),
(6, '69sparrow69Jack', '7Jgevbp4XMpu', 'j6s9@jacksparrow.rum'),
(7, 'jacksparrow159', '7Jgevbp4XMpu', 'jacksparrow96@gmail.com'),
(8, 'jacksparrow159', '269R5VbDSTcR', 'jacksparrow96@gmail.com'),
(9, 'johnwick3', '123456', 'johnwick69@johnwick.inc'),
(10, 'user123', '123456', 'jacksparrow96@gmail.com'),
(11, 'it has to work', '$2y$10$DoKSa', 'now@orIkill.myself');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `precheckout`
--
ALTER TABLE `precheckout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `precheckout`
--
ALTER TABLE `precheckout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
