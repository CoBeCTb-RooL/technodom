-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.15 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица technodom.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы technodom.categories: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT IGNORE INTO `categories` (`id`, `title`, `code`) VALUES
	(1, 'DVD', 'dvd'),
	(2, 'Книги', 'books'),
	(3, 'Мебель', 'furniture');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Дамп структуры для таблица technodom.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '0',
  `sku` varchar(50) DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `categoryId` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_products_categories` (`categoryId`),
  CONSTRAINT `FK_products_categories` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы technodom.products: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT IGNORE INTO `products` (`id`, `title`, `sku`, `price`, `categoryId`) VALUES
	(1, 'группа Disturbed концерт', 'fxv54', 12.00, 1),
	(2, 'Книга "Симулякры и симуляция"', '2347345', 21.00, 2),
	(3, 'Кожаное кресло "Потейка"', '0ыва345', 188.00, 3),
	(4, 'Дискотека Авария - все альбомы', '16373', 19.50, 1),
	(9, '"11" e\'w\'r <script>alert(3213)</script>', '\'2\'', 21213.00, 2);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица technodom.props
DROP TABLE IF EXISTS `props`;
CREATE TABLE IF NOT EXISTS `props` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_props_categories` (`categoryId`),
  CONSTRAINT `FK_props_categories` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы technodom.props: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `props` DISABLE KEYS */;
INSERT IGNORE INTO `props` (`id`, `categoryId`, `code`, `title`, `unit`) VALUES
	(1, 1, 'size', 'Размер', 'мб.'),
	(2, 2, 'weight', 'Вес', 'кг.'),
	(3, 2, 'author', 'Автор', NULL),
	(4, 3, 'length', 'Длина', 'м'),
	(5, 3, 'width', 'Ширина', 'м'),
	(6, 3, 'height', 'Высота', 'м');
/*!40000 ALTER TABLE `props` ENABLE KEYS */;

-- Дамп структуры для таблица technodom.propvalues__cat1
DROP TABLE IF EXISTS `propvalues__cat1`;
CREATE TABLE IF NOT EXISTS `propvalues__cat1` (
  `productId` int(11) NOT NULL,
  `size` int(11) DEFAULT NULL,
  PRIMARY KEY (`productId`),
  UNIQUE KEY `objId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы technodom.propvalues__cat1: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `propvalues__cat1` DISABLE KEYS */;
INSERT IGNORE INTO `propvalues__cat1` (`productId`, `size`) VALUES
	(1, 4500),
	(4, 1700);
/*!40000 ALTER TABLE `propvalues__cat1` ENABLE KEYS */;

-- Дамп структуры для таблица technodom.propvalues__cat2
DROP TABLE IF EXISTS `propvalues__cat2`;
CREATE TABLE IF NOT EXISTS `propvalues__cat2` (
  `productId` int(11) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  PRIMARY KEY (`productId`),
  UNIQUE KEY `objId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы technodom.propvalues__cat2: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `propvalues__cat2` DISABLE KEYS */;
INSERT IGNORE INTO `propvalues__cat2` (`productId`, `author`, `weight`) VALUES
	(2, 'Ж. Бодрийяр', 1.5),
	(9, '"11" e\'w\'r <script>alert(3213)</script>', 2);
/*!40000 ALTER TABLE `propvalues__cat2` ENABLE KEYS */;

-- Дамп структуры для таблица technodom.propvalues__cat3
DROP TABLE IF EXISTS `propvalues__cat3`;
CREATE TABLE IF NOT EXISTS `propvalues__cat3` (
  `productId` int(11) NOT NULL,
  `height` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `length` float DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `objId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы technodom.propvalues__cat3: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `propvalues__cat3` DISABLE KEYS */;
INSERT IGNORE INTO `propvalues__cat3` (`productId`, `height`, `width`, `length`) VALUES
	(3, 2.5, 225.5, 0.8);
/*!40000 ALTER TABLE `propvalues__cat3` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
