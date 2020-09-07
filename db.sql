/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for currency_convertor
CREATE DATABASE IF NOT EXISTS `currency_convertor` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `currency_convertor`;

-- Dumping structure for table currency_convertor.rates
CREATE TABLE IF NOT EXISTS `rates` (
  `source` varchar(50) NOT NULL DEFAULT '',
  `base_currency` char(3) NOT NULL COMMENT 'base currency in ISO 4217',
  `quote_currency` char(3) NOT NULL COMMENT 'quote currency in ISO 4217',
  `from_date` date NOT NULL COMMENT 'date when rate was set',
  `rate` decimal(19,4) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT 0 COMMENT 'bigger weight will be considered in case of concurrent rates from different sources',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`source`,`base_currency`,`quote_currency`,`from_date`),
  CONSTRAINT `source` FOREIGN KEY (`source`) REFERENCES `sources` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping structure for table currency_convertor.sources
CREATE TABLE IF NOT EXISTS `sources` (
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `default_weight` int(11) NOT NULL COMMENT 'Default weight will be used for rates from this source',
  PRIMARY KEY (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
