-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2020 at 05:00 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soen_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `username`, `comment`, `date`) VALUES
(1, 'harrypotter@gmail.com', 'Hello hello', '2020-12-07 22:56:37');

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
  `url` varchar(255) NOT NULL DEFAULT 'under_construction.php',
  `Related_Items1(id)` int(11) NOT NULL,
  `Related_Items2(id)` int(11) NOT NULL,
  `Related_Items3(id)` int(11) NOT NULL,
  `Related_Items4(id)` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `ingredients`, `type`, `url`, `Related_Items1(id)`, `Related_Items2(id)`, `Related_Items3(id)`, `Related_Items4(id)`) VALUES
(1, 'Almond Cookies', 'Almond cookies.jpg', 0.5, 'Wheat flour, eggs, lard, sugar, almonds', 'biscuit', 'Almond_Cookies.html', 10, 9, 4, 0),
(2, 'Cheese Cake', 'Cheese cake.jpg', 1, 'Wheat flour, eggs, milk, cream cheese, margarine, cornstarch', 'cake', 'Cheese_Cake.php', 8, 0, 0, 0),
(3, 'Chicken Biscuit', 'Chk bisc2.jpg', 0.5, 'Wheat flour, eggs, water, sugar, salt, maltose, oil, pork fat, red fermented bean curd, sesame seeds, garlic, onion', 'biscuit', 'Chicken_Biscuit.php', 11, 0, 0, 0),
(4, 'Egg Tart', 'Egg tart.jpg', 1, 'Wheat flour, eggs, evaporated milk, sugar, water, butter, custard power', 'misc', 'Egg_Tart.php', 14, 0, 0, 0),
(5, 'Guava Bites', 'Guava bites.jpg', 0.6, 'Wheat flour, eggs, condensed milk. powdered milk, guava paste', 'bites', 'Guava_Bites.php', 7, 0, 0, 0),
(6, 'Coconut Mochi', 'Coconut mochi.jpg', 1, 'Rice flour, sugar, water, coconut, peanut', 'misc', 'Coconut_Mochi.php', 0, 0, 0, 0),
(7, 'Pineapple Bites', 'Pineapple bites.jpg', 0.6, 'Wheat flour, eggs, condensed milk, powdered milk, pineapple', 'bites', 'Pineapple_Bites.php', 5, 0, 0, 0),
(8, 'Pineapple Cake', 'Pineapple cake.jpg', 1, 'Wheat flour, eggs, milk, raisins, oil, pineapple', 'cake', 'Pineapple_Cake.php', 2, 0, 0, 0),
(9, 'Tan Wong Su', 'Tan Wong.jpg', 1, 'Wheat flour, eggs, water, dough conditioner, vegetable oil, sugar, vegetable shortening, red bean paste, salted egg yolk', 'misc', 'Tan_Wong_Su.php', 10, 0, 0, 0),
(10, 'Tau Sa Pen', 'Tau sa.jpg', 0.7, 'Wheat flour, eggs, lard, sugar, almonds', 'misc', 'Tau_Sa_Pen.php', 9, 0, 0, 0),
(11, 'Steamed Pork Buns', 'Pork bun2.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, bbq pork', 'buns', 'Pork_Bun.php', 12, 13, 14, 0),
(12, 'Steamed Read Bean Paste Bun', 'RBP22.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, red bean paste', 'buns', 'Read_Bean _Paste _Bun.php', 11, 13, 14, 0),
(13, 'Steamed Coconut Bun', 'Coconut bun22.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, coconut', 'buns', 'Coconut_Bun.php', 11, 12, 14, 0),
(14, 'Steamed Custard Bun', 'Custard bun.jpg', 0.8, 'Wheat flour, water, sugar, dry yeast, baking powder, vegetable oil, salt, custard', 'buns', 'Custard_Bun.php', 11, 12, 13, 4),
(15, 'test name', 'test img 2.jpg', 69.69, 'Test ingredients: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam volutpat, neque ut auctor laoreet, massa ligula sodales urna sit.', 'misc', 'under_construction.php', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `pwrd` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `username`, `pwrd`, `email`) VALUES
(48, 'asdasd', 'aaaaaaaA1!', 'Samuellopez.f321321@gmail.com'),
(51, 'aasdasd', 'aaaaaaaA1!', 'aragorn@gmail.com'),
(52, 'aasdasd', 'aaaaaaaA1!', 'harrypotter@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
