-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2011 at 02:16 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `description`, `photo`) VALUES
(1, 'Lionel Messi', 'Football player', 'messi.jpg'),
(17, 'David Villa', 'Football player', 'villa.jpg'),
(3, 'Brad Delson', 'Musician', 'brad.jpg'),
(4, 'Fabio Cannavaro', 'Football player', 'cannavaro.jpg'),
(5, 'Chester Bennington', 'Musician', 'chester.jpg'),
(6, 'Hernan Crespo', 'Football player', 'crespo.jpg'),
(7, 'Joseph Hahn', 'Musician', 'joe.jpg'),
(8, 'Johnny Depp', 'Actor', 'johnny_depp.jpg'),
(9, 'Katy Perry', 'Musician', 'katy_perry.jpg'),
(10, 'Kierra Knightley', 'Actress', 'kierra_knightley.jpg'),
(11, 'Lady Gaga', 'Musician', 'lady_gaga.png'),
(12, 'Mike Shinoda', 'Musician', 'mike.jpg'),
(13, 'Dave Farrell', 'Musician', 'phoenix.jpg'),
(14, 'Rob Bourdon', 'Musician', 'rob.jpg'),
(15, 'Cristiano Ronaldo', 'Football player', 'ronaldo.jpg'),
(16, 'Shakira', 'Musician', 'shakira.jpg'),
(18, 'Angelina Jolie', 'Actress', 'jolie.jpg'),
(19, 'Jon Bon Jovi', 'Musician', 'bon_jovi.jpg'),
(20, 'Rob Thomas', 'Musician', 'rob_thomas.jpg'),
(21, 'Liv Tyler', 'Actress', 'liv_tyler.jpg'),
(22, 'Ben Affleck', 'Actor', 'ben_affleck.jpg'),
(23, 'Anthony Kiedis', 'Musician', 'kiedis.jpg'),
(24, 'Tobey Maguire', 'Actor', 'tobey.jpg'),
(25, 'Kirsten Dunst', 'Actress', 'dunst.jpg'),
(26, 'Viggo Mortensen', 'Actor', 'viggo.jpg'),
(27, 'Orlando Bloom', 'Actor', 'bloom.jpg'),
(28, 'Cate Blanchett', 'Actress', 'blanchett.jpg'),
(29, 'Rachel Weisz', 'Actress', 'weisz.jpg'),
(30, 'Billie Joe Armstrong', 'Musician', 'billie_joe.jpg'),
(31, 'Vin Diesel', 'Actor', 'vin_diesel.jpg');
