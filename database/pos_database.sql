-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 03:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

CREATE TABLE `order_table` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `date` date DEFAULT NULL,
  `receipt_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_table`
--

CREATE TABLE `product_table` (
  `product_id` int(11) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_table`
--

INSERT INTO `product_table` (`product_id`, `product_image`, `product_name`, `size`, `unit_price`, `category`) VALUES
(1, NULL, 'Blueberry Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(2, NULL, 'Cheesecake', '500 ml', 39.00, 'Cheesecake & Cloud Series'),
(3, NULL, 'Mango Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(4, NULL, 'Oreo Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(5, NULL, 'Strawberry Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(6, NULL, 'Choco Cloud', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(7, NULL, 'Mango Float', '500 ml', 69.00, 'Cheesecake & Cloud Series'),
(8, NULL, 'Matcha Cloud', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(9, NULL, 'Very Berry Snow', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(10, NULL, 'Blueberry Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(11, NULL, 'Cheesecake', '700 ml', 49.00, 'Cheesecake & Cloud Series'),
(12, NULL, 'Mango Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(13, NULL, 'Oreo Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(14, NULL, 'Strawberry Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(15, NULL, 'Choco Cloud', '700 ml', 64.00, 'Cheesecake & Cloud Series'),
(16, NULL, 'Mango Float', '700 ml', 89.00, 'Cheesecake & Cloud Series'),
(17, NULL, 'Matcha Cloud', '700 ml', 64.00, 'Cheesecake & Cloud Series'),
(18, NULL, 'Very Berry Snow', '700 ml', 64.00, 'Cheesecake & Cloud Series'),
(19, NULL, 'Berry Cafe', 'Regular', 49.00, 'Coffee Series'),
(20, NULL, 'Cafe Americano', 'Regular', 39.00, 'Coffee Series'),
(21, NULL, 'Cafe Mocha', 'Regular', 49.00, 'Coffee Series'),
(22, NULL, 'Caramel Machiato', 'Regular', 49.00, 'Coffee Series'),
(23, NULL, 'Choco Lava', 'Regular', 64.00, 'Coffee Series'),
(24, NULL, 'Coffee Jelly', 'Regular', 49.00, 'Coffee Series'),
(25, NULL, 'Dirty Matcha', 'Regular', 49.00, 'Coffee Series'),
(26, NULL, 'Himalayan Cafe', 'Regular', 64.00, 'Coffee Series'),
(27, NULL, 'Salted Caramel Machiato', 'Regular', 49.00, 'Coffee Series'),
(28, NULL, 'Salted Toffee Nut', 'Regular', 49.00, 'Coffee Series'),
(29, NULL, 'Sparkling Coffee', 'Regular', 49.00, 'Coffee Series'),
(30, NULL, 'Sunset Coffee', 'Regular', 49.00, 'Coffee Series'),
(31, NULL, 'Toffee NUT', 'Regular', 39.00, 'Coffee Series'),
(32, NULL, 'Very Berry Cafe', 'Regular', 64.00, 'Coffee Series'),
(33, NULL, 'Vintage', 'Regular', 39.00, 'Coffee Series'),
(34, NULL, 'Apple Berry', '500 ml', 29.00, 'Fruit Teas'),
(35, NULL, 'Blue Lemonade', '500 ml', 29.00, 'Fruit Teas'),
(36, NULL, 'Blue Berry', '500 ml', 29.00, 'Fruit Teas'),
(37, NULL, 'Green Apple', '500 ml', 29.00, 'Fruit Teas'),
(38, NULL, 'Lemon', '500 ml', 29.00, 'Fruit Teas'),
(39, NULL, 'Lychee', '500 ml', 29.00, 'Fruit Teas'),
(40, NULL, 'Passion Fruit', '500 ml', 29.00, 'Fruit Teas'),
(41, NULL, 'Strawberry', '500 ml', 29.00, 'Fruit Teas'),
(42, NULL, 'Apple Berry', '700 ml', 39.00, 'Fruit Teas'),
(43, NULL, 'Blue Lemonade', '700 ml', 39.00, 'Fruit Teas'),
(44, NULL, 'Blue Berry', '700 ml', 39.00, 'Fruit Teas'),
(45, NULL, 'Green Apple', '700 ml', 39.00, 'Fruit Teas'),
(46, NULL, 'Lemon', '700 ml', 39.00, 'Fruit Teas'),
(47, NULL, 'Lychee', '700 ml', 39.00, 'Fruit Teas'),
(48, NULL, 'Passion Fruit', '700 ml', 39.00, 'Fruit Teas'),
(49, NULL, 'Strawberry', '700 ml', 39.00, 'Fruit Teas'),
(50, NULL, 'Choco Matcha', '500 ml', 39.00, 'Premium Flavors'),
(51, NULL, 'Dark Choco', '500 ml', 39.00, 'Premium Flavors'),
(52, NULL, 'Dark Velvet', '500 ml', 39.00, 'Premium Flavors'),
(53, NULL, 'Double Cookies & Cream', '500 ml', 39.00, 'Premium Flavors'),
(54, NULL, 'Matcha', '500 ml', 39.00, 'Premium Flavors'),
(55, NULL, 'Matcha Red', '500 ml', 39.00, 'Premium Flavors'),
(56, NULL, 'Premium Matcha', '500 ml', 39.00, 'Premium Flavors'),
(57, NULL, 'Premium Okinawa', '500 ml', 39.00, 'Premium Flavors'),
(58, NULL, 'Premium Velvet', '500 ml', 39.00, 'Premium Flavors'),
(59, NULL, 'Strawberry & Cream', '500 ml', 39.00, 'Premium Flavors'),
(60, NULL, 'Tea Blossom', '500 ml', 39.00, 'Premium Flavors'),
(61, NULL, 'Tiger Sugar', '500 ml', 39.00, 'Premium Flavors'),
(62, NULL, 'Choco Matcha', '700 ml', 49.00, 'Premium Flavors'),
(63, NULL, 'Dark Choco', '700 ml', 49.00, 'Premium Flavors'),
(64, NULL, 'Dark Velvet', '700 ml', 49.00, 'Premium Flavors'),
(65, NULL, 'Double Cookies & Cream', '700 ml', 49.00, 'Premium Flavors'),
(66, NULL, 'Matcha', '700 ml', 49.00, 'Premium Flavors'),
(67, NULL, 'Matcha Red', '700 ml', 49.00, 'Premium Flavors'),
(68, NULL, 'Premium Matcha', '700 ml', 49.00, 'Premium Flavors'),
(69, NULL, 'Premium Okinawa', '700 ml', 49.00, 'Premium Flavors'),
(70, NULL, 'Premium Velvet', '700 ml', 49.00, 'Premium Flavors'),
(71, NULL, 'Strawberry & Cream', '700 ml', 49.00, 'Premium Flavors'),
(72, NULL, 'Tea Blossom', '700 ml', 49.00, 'Premium Flavors'),
(73, NULL, 'Tiger Sugar', '700 ml', 49.00, 'Premium Flavors'),
(74, NULL, 'BTS', '500 ml', 39.00, 'Surprise Blends Flavors'),
(75, NULL, 'Chuckie', '500 ml', 39.00, 'Surprise Blends Flavors'),
(76, NULL, 'K-Pop Oreo', '500 ml', 39.00, 'Surprise Blends Flavors'),
(77, NULL, 'Matcha Pink Drink', '500 ml', 39.00, 'Surprise Blends Flavors'),
(78, NULL, 'Meui Apollo', '500 ml', 39.00, 'Surprise Blends Flavors'),
(79, NULL, 'Melona', '500 ml', 39.00, 'Surprise Blends Flavors'),
(80, NULL, 'Mysterious Flames', '500 ml', 39.00, 'Surprise Blends Flavors'),
(81, NULL, 'Nutella', '500 ml', 39.00, 'Surprise Blends Flavors'),
(82, NULL, 'Pinoy Halo-Halo', '500 ml', 39.00, 'Surprise Blends Flavors'),
(83, NULL, 'Pistachio', '500 ml', 39.00, 'Surprise Blends Flavors'),
(84, NULL, 'Sakura Unicorn Dream', '500 ml', 39.00, 'Surprise Blends Flavors'),
(85, NULL, 'Tropical Pink Sip', '500 ml', 39.00, 'Surprise Blends Flavors'),
(86, NULL, 'BTS', '700 ml', 49.00, 'Surprise Blends Flavors'),
(87, NULL, 'Chuckie', '700 ml', 49.00, 'Surprise Blends Flavors'),
(88, NULL, 'K-Pop Oreo', '700 ml', 49.00, 'Surprise Blends Flavors'),
(89, NULL, 'Matcha Pink Drink', '700 ml', 49.00, 'Surprise Blends Flavors'),
(90, NULL, 'Meui Apollo', '700 ml', 49.00, 'Surprise Blends Flavors'),
(91, NULL, 'Melona', '700 ml', 49.00, 'Surprise Blends Flavors'),
(92, NULL, 'Mysterious Flames', '700 ml', 49.00, 'Surprise Blends Flavors'),
(93, NULL, 'Nutella', '700 ml', 49.00, 'Surprise Blends Flavors'),
(94, NULL, 'Pinoy Halo-Halo', '700 ml', 49.00, 'Surprise Blends Flavors'),
(95, NULL, 'Pistachio', '700 ml', 49.00, 'Surprise Blends Flavors'),
(96, NULL, 'Sakura Unicorn Dream', '700 ml', 49.00, 'Surprise Blends Flavors'),
(97, NULL, 'Tropical Pink Sip', '700 ml', 49.00, 'Surprise Blends Flavors'),
(98, NULL, 'Classic', '500 ml', 29.00, 'Traditional Flavors'),
(99, NULL, 'Cookies & Cream', '500 ml', 29.00, 'Traditional Flavors'),
(100, NULL, 'Okinawa', '500 ml', 29.00, 'Traditional Flavors'),
(101, NULL, 'Red Velvet', '500 ml', 29.00, 'Traditional Flavors'),
(102, NULL, 'Taro', '500 ml', 29.00, 'Traditional Flavors'),
(103, NULL, 'Wintermelon', '500 ml', 29.00, 'Traditional Flavors'),
(104, NULL, 'Classic', '700 ml', 39.00, 'Traditional Flavors'),
(105, NULL, 'Cookies & Cream', '700 ml', 39.00, 'Traditional Flavors'),
(106, NULL, 'Okinawa', '700 ml', 39.00, 'Traditional Flavors'),
(107, NULL, 'Red Velvet', '700 ml', 39.00, 'Traditional Flavors'),
(108, NULL, 'Taro', '700 ml', 39.00, 'Traditional Flavors'),
(109, NULL, 'Wintermelon', '700 ml', 39.00, 'Traditional Flavors'),
(110, NULL, 'Apple Berry Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(111, NULL, 'Blueberry Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(112, NULL, 'Green Apple Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(113, NULL, 'Lemon Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(114, NULL, 'Lychee Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(115, NULL, 'Passion Fruit Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(116, NULL, 'Strawberry Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(117, NULL, 'Apple Berry Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(118, NULL, 'Blueberry Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(119, NULL, 'Green Apple Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(120, NULL, 'Lemon Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(121, NULL, 'Lychee Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(122, NULL, 'Passion Fruit Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(123, NULL, 'Strawberry Yogurt', '500 ml', 49.00, 'Yogurt Series');

-- --------------------------------------------------------

--
-- Table structure for table `staff_table`
--

CREATE TABLE `staff_table` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_table`
--

INSERT INTO `staff_table` (`user_id`, `email`, `password`, `role`, `name`, `contact_number`) VALUES
(1, 'admin@example.com', 'admin_password', 'Admin', 'Admin Name', '123-456-7890'),
(2, 'staff@example.com', 'staff_password', 'Staff', 'Staff Name', '987-654-3210');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_table`
--
ALTER TABLE `product_table`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `staff_table`
--
ALTER TABLE `staff_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_table`
--
ALTER TABLE `order_table`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_table`
--
ALTER TABLE `product_table`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `staff_table`
--
ALTER TABLE `staff_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_table`
--
ALTER TABLE `order_table`
  ADD CONSTRAINT `order_table_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
