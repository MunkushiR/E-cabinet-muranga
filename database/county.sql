-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2024 at 01:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `county`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(20) NOT NULL,
  `log_type` tinyint(1) NOT NULL COMMENT '1 = AM IN,2 = AM out, 3= PM IN, 4= PM out\r\n',
  `datetime_log` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cabinets`
--

CREATE TABLE `cabinets` (
  `id` int(20) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cabinets`
--

INSERT INTO `cabinets` (`id`, `name`) VALUES
(1, 'Governor'),
(2, 'DG'),
(3, 'CECMs'),
(4, 'County Attorney'),
(5, 'DCS'),
(6, 'Chief of staff'),
(7, 'Secretary');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'County Executive Committee(Cabinet) Meeting'),
(2, 'Department Evaluation Meetings'),
(3, 'Interdepartmental Meeting'),
(4, 'Budget and economic council'),
(10, 'COC meeting'),
(11, 'CEC Meeting'),
(12, 'Board of Directors Meeting'),
(13, 'Monthly review meeting'),
(14, 'Hospital Board Meeting');

-- --------------------------------------------------------

--
-- Table structure for table `departmental`
--

CREATE TABLE `departmental` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departmental`
--

INSERT INTO `departmental` (`id`, `name`) VALUES
(2, 'Governor'),
(3, 'DG'),
(4, 'CECMS of the Department'),
(5, 'Chief officer of the Department'),
(6, 'Director(s) of the department'),
(7, 'Departmental Accountant');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `personal_number` varchar(15) NOT NULL,
  `position` text NOT NULL,
  `work_email` varchar(30) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `national_id` int(11) NOT NULL,
  `meeting_types` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `firstname`, `lastname`, `personal_number`, `position`, `work_email`, `phonenumber`, `national_id`, `meeting_types`) VALUES
(36, 'H.E Dr Irungu ', 'Kang\'ata', 'Governor', 'Governor', 'governor@muranga.go.ke', '0700000000', 1, ''),
(37, 'H.E Stephene', 'Munaina', 'Deputy Governor', 'Deputy Governor', 'deputygovernor@gmai.com', '0700000000', 2, ''),
(38, 'county', ' secretary', 'county sec', 'county secretary', ' countysecreatry@gmail.com', '0700000000', 3, ''),
(39, 'Deputy ', 'County Secretary', 'dep county sec', 'Deputy County Secretary', 'depcountysec@gmail.com', '0700000000', 4, ''),
(40, 'CECMs', 'CECMs', 'CECMs', 'CECMs', 'CECMs@gmail.com', '0700000000', 5, ''),
(41, 'County ', 'Attorney', 'County Attorney', 'County Attorney', 'CountyAttorney@gmail.com', '0700000000', 6, ''),
(42, 'Chief ', 'Staff', 'Chief of Staff', 'Chief of Staff', 'ChieffStaff@gmail.com', '0700000000', 7, ''),
(43, 'Secretary', ' Support', 'sec support', 'Secretary Support', 'SecretarySupport@gmail.com', '0700000000', 8, ''),
(44, 'Directors ', 'Directors ', 'Directors ', 'Directors ', 'Directors@gmail,com', '0700000000', 9, ''),
(45, 'Departmental', ' Accountant', 'Departmental Ac', 'Departmental Accountant', 'Departmentalacc@gmai.com', '0700000000', 10, ''),
(46, 'Medd ', 'supp', 'Medd supp', 'Medd supp', 'Meddsupp@gmail.com', '0700000000', 11, ''),
(47, 'Subcounty ', 'Administrator', 'subcounty admn', 'Subcounty Administrator', 'sucountyadm@gmail.com', '0700000000', 12, ''),
(48, 'Procurement ', 'Officers', 'Procurement Off', 'Procurement Officers', 'Procurementofficers@gmail.com', '0700000000', 13, ''),
(49, 'Council ', 'Secretariat', 'Council Sec', 'Council Secretariat', 'Councilsecretariat@gmail.com', '0700000000', 14, ''),
(50, 'members of the', ' Board of directors meeting', 'member BOD', 'members of the Board of directors meeting', 'member BOD@gmail.com', '0700000000', 15, ''),
(51, 'members of the CEC meeting', ' CEC meeting', 'member CEC', 'members of the CEC meeting', 'member CEC@gmail.com', '0700000000', 16, ''),
(52, 'Members of the', 'county Executive(Cabinet) meet', 'member cabinet', 'Members of the county Executive(Cabinet) meeting', 'member cabinet@gmail.com', '0700000000', 17, ''),
(53, 'Members of the ', 'Departmental meetings', 'member Depart', 'Members of the Departmental meetings', 'member Depart@gmail.com', '0700000000', 18, ''),
(54, 'members of', ' interdepartmental meeting', 'member interdep', 'members of interdepartmental meeting', 'member interdepart@gmail.com', '0700000000', 19, ''),
(55, 'members of the ', 'budget and economic council me', 'member BEC', 'members of the budget and economic council meeting', 'member BEC@gmail.com', '0700000000', 20, ''),
(56, 'members of the ', 'COC meeting', 'member COC', 'members of the COC meeting', 'membbercoc@gmai.com', '0700000000', 21, ''),
(57, 'members of the', 'monthly review meeting', 'member MRM', 'members of the monthly review meeting', 'membermrm@gmail.com', '0700000000', 22, ''),
(58, 'members of the', ' hospital board meeting', 'member HBM', 'members of the hospital board meeting', 'memberhbm@gmail.com', '0700000000', 23, '');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `all_day` tinyint(1) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `recurring` tinyint(1) NOT NULL,
  `notification_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(10) NOT NULL,
  `type` text NOT NULL,
  `title` varchar(400) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `present_members` text NOT NULL,
  `agenda` varchar(500) NOT NULL,
  `absent` varchar(100) NOT NULL,
  `attendees` varchar(50) NOT NULL,
  `content` varchar(4000) NOT NULL,
  `signed_by` varchar(30) NOT NULL,
  `file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `department_id`) VALUES
(1, 'Governor\r\n', 1),
(25, 'Deputy Governor', 1),
(26, 'county secretary', 1),
(27, 'Deputy County Secretary', 1),
(28, 'CECMs', 1),
(29, 'County Attorney', 1),
(30, 'Chief of Staff', 1),
(31, ' Secretary Support', 1),
(32, 'Members of the county Executive(Cabinet) meeting', 1),
(33, 'Governor', 2),
(34, 'Deputy Governor', 2),
(35, 'county secretary', 2),
(36, 'Deputy County Secretary', 2),
(37, 'CECMs', 2),
(38, 'County Attorney', 2),
(39, 'Chief of Staff', 2),
(40, 'Secretary Support', 2),
(41, 'Directors ', 2),
(42, 'Members of the Departmental meetings', 2),
(43, 'Governor', 3),
(44, 'Deputy Governor', 3),
(45, 'county secretary', 3),
(46, 'Deputy County Secretary', 3),
(47, 'CECMs', 3),
(48, 'County Attorney', 3),
(49, 'Chief of Staff', 3),
(50, 'Secretary Support', 3),
(51, 'Directors ', 3),
(52, 'Departmental Accountant', 3),
(53, 'Medd supp', 3),
(54, 'Subcounty Administrator', 3),
(55, 'Procurement Officers', 3),
(56, 'members of interdepartmental meeting', 3),
(57, 'Governor', 4),
(58, 'Deputy Governor', 4),
(59, 'CECMs', 4),
(60, 'Council Secretariat', 4),
(61, 'members of the budget and economic council meeting', 4),
(62, 'Governor', 10),
(63, 'Deputy Governor', 10),
(64, 'county secretary', 10),
(65, 'Deputy County Secretary', 10),
(66, 'Chief of Staff', 10),
(67, 'County Attorney', 10),
(68, 'members of the COC meeting', 10),
(69, 'Governor', 11),
(70, 'Deputy Governor', 11),
(71, 'county secretary', 11),
(72, 'Deputy County Secretary', 11),
(73, 'Chief of Staff', 11),
(74, 'Secretary Support', 11),
(75, 'members of the CEC meeting', 11),
(76, 'Governor', 12),
(77, 'Deputy Governor', 12),
(79, 'county secretary', 12),
(80, 'Deputy County Secretary', 12),
(81, 'CECMs', 12),
(82, 'County Attorney', 12),
(83, 'Chief of Staff', 12),
(84, 'Secretary Support', 12),
(85, 'Directors', 12),
(86, 'members of the Board of directors meeting', 12),
(87, 'Governor', 13),
(88, 'Deputy Governor', 13),
(89, 'county secretary', 13),
(90, 'CECMs', 13),
(91, 'County Attorney', 13),
(92, 'Chief of Staff', 13),
(93, 'Secretary Support', 13),
(94, 'members of the monthly review meeting', 13),
(95, 'Governor', 14),
(96, 'Deputy Governor', 14),
(97, 'county secretary', 14),
(98, 'Deputy County Secretary', 14),
(99, 'CECMs', 14),
(100, 'County Attorney', 14),
(101, 'Chief of Staff', 14),
(102, 'Secretary Support', 14),
(103, 'Medd supp', 14),
(104, 'members of the hospital board meeting', 14);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `user_id` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(400) NOT NULL,
  `from` text NOT NULL,
  `date` datetime NOT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `minutes`
--

CREATE TABLE `minutes` (
  `id` int(10) NOT NULL,
  `type` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `location` text NOT NULL,
  `time` time(6) NOT NULL,
  `attendees` varchar(100) NOT NULL,
  `agenda` varchar(250) NOT NULL,
  `file` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `Id` int(30) NOT NULL,
  `Subject` text NOT NULL,
  `Message` text NOT NULL,
  `From` varchar(30) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `department_id`, `name`) VALUES
(1, 1, 'Programmer'),
(2, 2, 'HR Supervisor'),
(4, 3, 'Accounting Clerk');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `work_id` varchar(15) NOT NULL,
  `work_email` varchar(30) NOT NULL,
  `department` text NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `salary` int(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `firstname`, `lastname`, `work_id`, `work_email`, `department`, `phonenumber`, `salary`, `password`, `image`) VALUES
(1, 'Isaac', 'Wainaina', 'IWA3467', 'wainainaisaiah@gmail.com', 'Human Resource', '0789563415', 20000, 'izo', ''),
(2, 'AUSTINE', 'OJUMA', 'J67836490', 'ojuma@gmail.com', 'Governor', '783736389', 30000, '1234567', ''),
(3, 'John', 'Marande', 'MJ12345', 'marandej@wku.adventist.org', 'Accounting and Finance', '734572018', 40000, 'marande', ''),
(4, 'Peter', 'Albert', 'PA567845', 'pert3@gmail.com', 'Human Resource', '756453790', 25000, 'peter', ''),
(5, 'KIPTANUI', 'PETER', 'PR3567', 'peter@gmail.com', 'Human Resource', '0747483647', 45000, 'wekesa', ''),
(6, 'isaiah', 'Wainaina', 'WK12345', 'wainaina58gmail.com', 'Accounting and Finance', '786345725', 35000, '78499', ''),
(7, 'AUSTINE', 'Aluoch', 'WKUC123', 'aluoch@wku.org', 'Human Resource', '0789467834', 70000, 'Aluoch', ''),
(8, 'Kevin', 'Bengi', 'SKEVBE1811', 'bengike@ueab.ac.ke', 'Accounting and Finance', '0796172980', 60000, 'love@2018', 'kevin.jpg'),
(9, 'Kevin', 'Kipto', 'WKU124', 'kiptoke@ueab.ac.ke', 'Accounting and Finance', '0789467834', 48000, 'kipto', 'kipto.jpg'),
(10, 'Janet ', 'Naliaka', 'WKUC29', 'janetnaliaka@wkuc.com', 'Human Resource', '0707235678', 45000, 'janet', '933f9a7495054639af6f79096eeb09fe.jpg'),
(11, '', '', '', '', '', '', 0, '', ''),
(12, '', '', '', '', '', '', 0, '', ''),
(13, '', '', '', '', '', '', 0, '', ''),
(14, '', '', '', '', '', '', 0, '', ''),
(15, '', '', '', '', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `personal_number` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = staff, 3=Secretary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `personal_number`, `password`, `type`) VALUES
(1, 'Kevin Bengi', '543754838', 'IEC61508', 1),
(7, 'Kevin Wekesa', '67464498', 'IEC61508', 1),
(10, 'Stephen Leto', '6868868', '78457599', 2),
(11, 'peter Njuguna', '79978586', 'Perfection@2024', 1),
(21, 'Kelvin Wafula', '667786257', 'STEVTO123', 2),
(25, 'DARRYL W HONDORP', '675857686', 'IEC61508', 3),
(26, 'Frank', '556644683', '36684487492', 3),
(27, 'Naserian', '78987467', '7875657', 1),
(28, 'Eunice Kiruto', '35368991', '123456', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cabinets`
--
ALTER TABLE `cabinets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departmental`
--
ALTER TABLE `departmental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `minutes`
--
ALTER TABLE `minutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cabinets`
--
ALTER TABLE `cabinets`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `departmental`
--
ALTER TABLE `departmental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `minutes`
--
ALTER TABLE `minutes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `Id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
