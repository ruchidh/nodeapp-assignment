
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `Description` longtext NOT NULL,
  `Address` longtext NOT NULL,
  `StartDate&Time` datetime NOT NULL,
  `EndDate&Time` datetime NOT NULL,
  `JoinType` varchar(10) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Latitude` int(11) NOT NULL,
  `Longitude` int(11) NOT NULL,
  `Image` varchar(535) NOT NULL,
  `Tags` varchar(535) NOT NULL
) ;

ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Financial Year` varchar(20) NOT NULL,
  `Issued To` text NOT NULL,
  `Address` text NOT NULL,
  `Heading` text NOT NULL,
  `Date & time` datetime NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `Particulars` varchar(535) NOT NULL,
  `Gross Amount` decimal(10,2) NOT NULL,
  `Service Tax` decimal(10,2) NOT NULL,
  `Net Amount` decimal(10,2) NOT NULL
) ;

ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

