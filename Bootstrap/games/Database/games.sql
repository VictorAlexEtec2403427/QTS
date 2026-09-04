-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 04/09/2026 às 19:01
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `codgame` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `plataforma` varchar(50) NOT NULL,
  `preco` float NOT NULL,
  `arquivo` varchar(200) NOT NULL,
  `novidade` char(1) NOT NULL,
  PRIMARY KEY (`codgame`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `games`
--

INSERT INTO `games` (`codgame`, `nome`, `plataforma`, `preco`, `arquivo`, `novidade`) VALUES
(1, 'FIFA 23 - PlayStation 4', 'Playstation 4', 260, 'img/imagem_14-38-35_04-09-2026.jpg', 'S'),
(2, 'God of War Ragnarok', 'Playstation 4', 200, 'img/imagem_14-40-04_04-09-2026.jpg', 'S'),
(3, 'FIFA 23 - PlayStation 5', 'Playstation 5', 330, 'img/imagem_14-40-28_04-09-2026.jpg', 'S'),
(4, 'Gears 5 - Xbox One', 'Xbox One', 330, 'img/imagem_14-41-21_04-09-2026.jpg', 'S'),
(5, 'Resident Evil 2', 'Xbox One', 199, 'img/imagem_14-42-19_04-09-2026.jpg', 'N'),
(6, 'Lego Star Wars', 'Xbox One', 99, 'img/imagem_14-42-57_04-09-2026.jpg', 'N'),
(7, 'FIFA 22', 'Xbox One', 110, 'img/imagem_14-43-32_04-09-2026.jpg', 'N'),
(8, 'Battlefield 2042 - PS5', 'Playstation 5', 60, 'img/imagem_14-44-26_04-09-2026.jpg', 'N'),
(9, 'Sonic Frontiers', 'Playstation 4', 220, 'img/imagem_14-44-57_04-09-2026.jpg', 'S'),
(10, 'Marvel\'s Spider-Man', 'Playstation 4', 150, 'img/imagem_14-45-36_04-09-2026.jpg', 'N');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
