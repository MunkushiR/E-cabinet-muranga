-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 01:53 PM
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
(10, 'COS meeting'),
(12, 'Board of Directors Meeting'),
(13, 'Monthly review meeting'),
(14, 'Hospital Board Meeting'),
(16, 'Department of Water Irrigation Environment & Natural Resources'),
(17, 'Department of Roads Housing & Infrastructure'),
(18, 'Department of Youth affairs Culture and Social Services'),
(19, 'Department of Finance & Economic Planning'),
(20, 'Department of Health and Sanitization'),
(21, 'Department of Lands Physical Planning & Urban Development'),
(22, 'Department of Education & Technical Training'),
(23, 'Department of Agriculture Trade & Cooperatives'),
(24, 'Department of Public Service Administration & ICT'),
(25, 'Department of Governorship County Coordination and Administration\r\n'),
(26, 'Department of ⁠Devolution and External Linkages'),
(27, 'Department of ⁠Murang’a County Budget and Economic Council'),
(28, 'Department of County Public Service Board'),
(29, 'Department of Communication and Media'),
(30, 'Legal Department'),
(31, 'Department of Revenue and Supply Chain'),
(32, 'Murang\'a Municipality Meeting'),
(33, 'Kenol Municipality Meeting'),
(34, 'Kangari Municipality Meeting'),
(35, 'Gatanga Water'),
(36, 'Murang\'a South Water(MUSWASCO)'),
(37, 'Muranga Water(MUWASCO)'),
(38, 'Gatamathi Water'),
(39, 'Murang\'a West Water'),
(40, 'Murang\'a Level V Hospital'),
(41, 'Kiwara Level IV Hospital'),
(42, 'Kandara Level IV Hospital'),
(43, '⁠kigumo level Iv Hospital'),
(44, '⁠Kenneth Matiba Hospital'),
(45, 'Muriranjas Level Iv Hospital'),
(46, 'Kangema Level IV Hospital'),
(47, 'Maragwa subcounty Hospital');

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

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`, `path`, `type`, `uploaded_at`) VALUES
(4, 'Department evaluation.xlsx', '66b202ed4145f2.95410887.xlsx', 'application/vnd.openxmlformats-officedocument.spre', '2024-08-06 11:03:09'),
(5, 'Ecabinet Login Credentials.xlsx', '66b3033acd5638.05979522.xlsx', 'application/vnd.openxmlformats-officedocument.spre', '2024-08-07 05:16:42'),
(6, 'Ecabinet Login Credentials.xlsx', '66b320e8135da4.00197805.xlsx', 'application/vnd.openxmlformats-officedocument.spre', '2024-08-07 07:23:20');

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
(37, 'H.E Stephen', 'Munaina', 'Deputy Governor', 'Deputy Governor', 'deputygovernor@gmai.com', '0700000000', 2, ''),
(38, 'county', ' secretary', 'county sec', 'county secretary', ' countysecreatry@gmail.com', '0700000000', 3, ''),
(39, 'Deputy ', 'County Secretary', 'dep county sec', 'Deputy County Secretary', 'depcountysec@gmail.com', '0700000000', 4, ''),
(40, 'CECMs', 'CECMs', 'CECMs', 'CECMs', 'CECMs@gmail.com', '0700000000', 5, ''),
(41, 'County ', 'Attorney', 'County Attorney', 'County Attorney', 'CountyAttorney@gmail.com', '0700000000', 6, ''),
(42, 'Chief of ', 'staff', 'Chief of Staff', 'Chief of Staff', 'ChieffStaff@gmail.com', '0700000000', 5, ''),
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
(58, 'members of the', ' hospital board meeting', 'member HBM', 'members of the hospital board meeting', 'memberhbm@gmail.com', '0700000000', 23, ''),
(60, 'Philemon', 'Kibiru', 'Kibiru', 'Chief of Staff', 'philkibiru@gmail.com', '07181223827', 1234, ''),
(61, 'Paul ', 'Kimani Mugo', 'Mugo', 'CECM Trade Industrialization & Tourism', 'mmugojjj@gmail.com', '0722985453', 1234, ''),
(62, 'Mary ', 'Muthoni Magochi', 'Magochi', 'CECM Water Irrigation Environment & Natural Resources', 'marymuthoni12@gmail.com', '0725712750', 1234, ''),
(63, 'Pius', ' Nguguna Macharia', 'Macharia', 'CECM Roads Housing & Infrastructure', 'macpius@gmail.com', '072873554', 1234, ''),
(64, 'Noah ', 'Gachucha Gachanja', 'Gachanja', 'CECM Youth affairs Culture and Social Services', 'noahgacha@gmail.com', '0726940871', 1234, ''),
(65, 'prof. Kiarie', 'Mwaura', 'prof. Mwaura', 'CECM Finance & Economic Planning', 'mwaura.advocate@gmail.com', '0725712750', 1234, ''),
(66, 'Dr. Fredrick k.', 'Mbugua', 'Dr. Mbugua', 'CECM Health and Sanitization', 'fkamondia@yahoo.co.uk', '0722709759', 1234, ''),
(67, 'Dr. Winfred', 'Njeri Mwangi', 'Dr. Mwangi', 'CECM  Lands Physical Planning & Urban Development', 'wnyika@hotmail.com', '0722743187', 1234, ''),
(68, 'Faith', 'Wairimu Njoroge', ' Njoroge', 'CECM Education & Technical Training', 'faithwairimunjoroge@gmail.com', '0722427015', 1234, ''),
(69, 'Kamau ', 'Kiringai', 'Kiringai', 'CECM Agriculture Livestock & Cooperatives', 'kiringai@gmai.com', '0722800986', 1234, ''),
(70, 'James ', 'Simon Gatuna', 'Gatuna', 'CECM Public Service Administration & ICT ', 'itskinuthia@gmail.com', '07196440930', 1234, ''),
(71, 'Fridah', 'Waithira', 'Waithira', 'Director Transport', 'fridah@gmail.com', '0720772881', 1234, ''),
(72, 'Bilha ', 'Wanjiku', 'Wanjiku', 'Director Disaster and fire', 'wanjiku@gmail.com', '0722971416', 1234, ''),
(73, 'Beatrice ', 'Gicheha', 'Gicheha', 'Director Admin', 'gicheha@gmail.com', '072374194', 1234, ''),
(74, 'Catherine', 'Kabuki', 'Kabuki', 'Director Accountant Governorship and coordination', 'kabuki@gmail.com', '0721311122', 1234, ''),
(75, 'Edwin', ' Kimuyu', ' Kimuyu', 'Director Finance', 'kimuyu@gmail.com', '0700000000', 1234, ''),
(76, 'Emilyo', 'Muchunu', 'Muchunu', 'Director Budget', 'muchunu@gmai.com', '0700000000', 1234, ''),
(77, 'Anthony', 'Waithaka', 'Waithaka', 'Director Accounting Services', 'waithaka@gmail.com', '0700000000', 1234, ''),
(78, 'Stephen K', 'Mwangi', 'Mwangi', 'Director Economic Planning', 'mwangi@gmail.com', '0700000000', 1234, ''),
(79, 'Samuel', 'Kaaga', 'Kaaga', 'Director Internal Audit', 'kaaga@gmail.com', '0700000000', 1234, ''),
(80, 'Caroline ', 'Githiru', 'Githiru', 'Assistant Director Accounting Services', 'githiru@gmail.com', '0700000000', 1234, ''),
(81, 'Thomas ', 'Gakahu', 'Gakahu', 'Director Revenue', 'gakahu@gmail.com', '0700000000', 1234, ''),
(82, 'Stanley', ' Mwaniki', ' Mwaniki', 'Director Supply Chain Management', 'mwaniki@gmail.com', '0700000000', 1234, ''),
(83, 'Jackson ', 'Kinuthia', 'Kinuthia', 'Director Supply Chain Management', 'Kinuthia@gmail.com', '0700000000', 1234, ''),
(84, 'Irungu', 'Francis Mwangi', 'Francis Mwangi', 'Director Survey', 'francismwangi@gmail.com', '0790222181', 1234, ''),
(85, 'Kameri', ' Anthony Gathura', ' Anthony G', 'Director Valuation', ' Anthonygathura@gmail.com', '0722271210', 1234, ''),
(87, 'Wanjiku', ' Josphine', 'Wanjiku J', 'Chief Officer Lands Survey', 'Wanjiku@gmail.com', '0725912629', 1234, ''),
(89, 'Dr. James', ' Mburu', 'Dr. Mburu', 'County Director Health', 'mbugujamesm@gmail.com', '0722229845', 1234, ''),
(90, 'Dr. Kairo ', 'Kimende', 'Dr. Kimende', 'Deputy Director Health', 'kimende.kairo@gmail.com', '0725259925', 1234, ''),
(91, 'Dr. Florence', ' Kagwaini', 'Dr. Kagwaini', 'Medical Superintendent Muranga', 'fkagwaine@gmail.com', '0721991493', 1234, ''),
(92, 'Dr. Stephen ', 'Karangau', 'Dr. Karangau', 'Medical Superintendent Maragua Sub-county hospital', 'karanhusteve@gmail.com', '0724885130', 1234, ''),
(93, 'Dr. Karen', 'Mwangi', 'Dr. Karen', 'Medical Superintendent Kangema Sub-county hospital', 'MwangiKaren@gmail.com', '0712272071', 1234, ''),
(94, 'Dr. Eutychus ', 'Muguku', 'Dr. Eutychus ', 'Medical Superintendent Muriranjas Sub-county hospital', 'muguku23@gmail.com', '0723233002', 1234, ''),
(95, 'Dr. Chrissie ', 'Kerubo', 'Dr. Chrissie ', 'Medical Superintendent Kigumo Sub-county hospital', 'chrissiekerubo@gmail.com', '0703409941', 1234, ''),
(96, 'Dr. Esther ', 'Maina', 'Dr. Esther ', 'Medical Superintendent Kirwara Sub-county hospital', 'esthermaina.em@gmail.com', '07219963699', 1234, ''),
(97, 'Dr. Lina', 'Gakera', 'Dr. Lina', 'Medical Superintendent Kandara Sub-county hospital', 'linagakera@gmail.com', '0725722395', 1234, ''),
(98, 'Dr. Tessy ', 'Semo Oranga', 'Dr. Tessy ', 'Medical Superintendent Kenneth Matiba hospital', 'cesca.ces@gmail.com', '0721263699', 1234, ''),
(99, 'Dr. Godfrey', 'Gatacha', 'Dr. Gatacha', 'Head of HPTU/Pharms', 'gatacha@gmail.com', '0724126038', 1234, ''),
(100, 'Purity', 'Wawira Njangi', 'Wawira', 'Departmental Accountant Health and Sanitization', 'npwawira@gmail.com', '0724126038', 1234, ''),
(101, 'Pauline ', 'Ngigi', 'Puline Ngigi', 'PA-Health', 'plnwairimu@gmail.com', '0722654465', 1234, ''),
(102, 'Romano', 'Kang\'ethe', 'Romano', 'County Laboratory Coordinator', 'kangetheromano@gmail.com', '0721169446', 1234, ''),
(103, 'Veronica ', 'Kang\'ethe', 'Veronica', 'County Logistician', 'vkangethe@gmail.com', '0722697684', 1234, ''),
(104, 'Salome ', 'Kimani', 'Salome', 'County Nursing Officer', 'kimwani2004@yahoo.com', '0722697684', 1234, ''),
(105, 'Bancy', 'Wawira', 'Bancy', 'D/Director-HR-Health', 'wawira.bancy@gmail.com', '0724888816', 1234, ''),
(106, 'John', 'Muriithi', 'Ngunjiri', 'Director Sports', 'johnmurithi@gmail.com', '0722674831', 1234, ''),
(107, 'Samuel', 'Ndungu Kungu', 'Samuel Kungu', 'Director Youth', 'smauelkungu@gmail.com', '0722218876', 1234, ''),
(108, 'Catherine', 'Wairimu Mwangi', 'Wairimu Mwangi', 'Director Culture', 'wairimumwangi@gmail.com', '0722667037', 1234, ''),
(109, 'Simon ', 'Muingai Ichahuria', 'Ichahuria', 'Director Accountant Youth Affairs sports culture social services', 'ichahuria@gmail.com', '071159834', 1234, ''),
(110, 'Jennifer', ' Kabura Kamau', ' Kabura ', 'Director Social Services', 'kabura@gmail.com', '0720479183', 1234, ''),
(111, 'Esther ', 'Nduati Maina', 'Esther Nduati', 'Director Communication', 'esthernduati@gmail.com', '0708879294', 1234, ''),
(112, 'Eng. John ', 'Macharia', 'Eng. Macharia', 'MD Murang\' a South-Muswasco', 'engmacharia@gmail.com', '0722158672', 1234, ''),
(113, 'Eng. Daniel', ' Ng\'ang\'a', ' Eng. Ng\'ang\'a', 'MD Muwasco', 'daniel@gmail.com', '071626795', 1234, ''),
(114, 'Eng. Ephantus', ' Kamau', 'Eng. Ephantus', 'MD Mwewasco-Kahuti', 'ephantus@gmail.com', '072265188', 1234, ''),
(115, 'Eng. John', ' Kairu', 'Eng. Kairu', 'MD Gatanga', 'kiaru@gmail.com', '0729350329', 1234, ''),
(116, 'Charles', ' Muiruki', 'Charles Muiruki', 'MD Gatamathi', 'charlesmuiruki@gmail.com', '0725382238', 1234, ''),
(117, 'Vera ', 'Wema', 'Vera Wema', 'Admin Kenneth Matiba hospital', 'verawema@gmai.com', '07000000', 1234, '');

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

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start`, `end`, `all_day`, `location`, `recurring`, `notification_sent`) VALUES
(7, 'ecabinet system presentation', '2024-08-05 17:47:00', '2024-08-05 17:48:00', 0, 'confrence hall', 0, 0),
(8, 'ECABINET SYTEM PRESENTATION', '2024-08-07 08:30:00', '2024-08-08 10:30:00', 1, 'onLINE', 0, 0);

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
  `absent` varchar(10000) NOT NULL,
  `attendees` varchar(10000) NOT NULL,
  `content` varchar(4000) NOT NULL,
  `signed_by` varchar(1000) NOT NULL,
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
(0, 'Medical Superintendent Muranga\'a Referral hospital', 14),
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
(48, 'County Attorney', 3),
(49, 'Chief of Staff', 3),
(50, 'Secretary Support', 3),
(52, 'Departmental Accountant', 3),
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
(68, 'member of the COS meeting', 10),
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
(99, 'CECM Health and Sanitization', 14),
(100, 'County Attorney', 14),
(101, 'Chief of Staff', 14),
(102, 'Secretary Support', 14),
(104, 'members of the hospital board meeting', 14),
(106, 'CECM Trade Industrialization & Tourism', 1),
(107, 'CECM Water Irrigation Environment & Natural Resources', 1),
(108, 'CECM Roads Housing & Infrastructure', 1),
(109, 'CECM Youth affairs Culture and Social Services', 1),
(110, 'CECM Finance & Economic Planning', 1),
(111, 'CECM Health and Sanitization', 1),
(112, 'CECM  Lands Physical Planning & Urban Development', 1),
(113, 'CECM Education & Technical Training', 1),
(114, 'CECM Agriculture Livestock & Cooperatives', 1),
(115, 'CECM Public Administration & ICT', 1),
(116, 'CECM Governorship County Coordination and Administration', 1),
(117, 'CECM Devolution and External Linkages', 1),
(119, 'CECM Murang’a County Budget and Economic Council', 1),
(121, 'CECM County Public Service Board', 1),
(122, 'CECM Communication and Media', 1),
(123, 'CECM Legal', 1),
(124, 'Director Transport', 25),
(125, 'Director Disaster and Fire', 25),
(126, 'Director Admin', 25),
(127, 'Director Accountant Governorship and coordination', 25),
(128, 'CECM Governorship County Coordination and Administration', 25),
(129, 'CECM Finance & Economic Planning', 19),
(130, 'Director Finance ', 19),
(131, 'Director Budget ', 19),
(132, 'Director Accounting Services', 19),
(133, 'Director Economic Planning', 19),
(134, 'Director Internal Audit', 19),
(135, 'Assistant Director Accounting Services', 19),
(136, 'CECM  Revenue and Supply Chain', 31),
(137, 'Director Revenue', 31),
(138, 'Director Supply Chain Management', 31),
(139, 'CECM  Lands Physical Planning & Urban Development', 21),
(140, 'Director Survey', 21),
(141, 'Director Valuation', 21),
(142, 'Chief Officer Lands Survey', 21),
(143, 'CECM Health and Sanitization', 20),
(144, 'County Director Health', 20),
(145, 'Deputy Director Health', 20),
(146, 'Medical Superintendent Muranga\'a Referral hospital', 20),
(147, 'Medical Superintendent Maragua Sub-county hospital', 20),
(148, 'Medical Superintendent Kangema Sub-county hospital', 20),
(149, 'Medical Superintendent Muriranjas Sub-county hospital', 20),
(150, 'Medical Superintendent Kigumo Sub-county hospital', 20),
(151, 'Medical Superintendent Kirwara Sub-county hospital', 20),
(152, 'Medical Superintendent Kandara Sub-county hospital', 20),
(153, 'Medical Superintendent Kenneth Matiba hospital', 20),
(154, 'Head of HPTU/Pharms', 20),
(155, 'Chief Officer Health', 20),
(156, 'Hospital Board Member', 20),
(157, 'Departmental Accountant Health and Sanitization', 20),
(158, 'PA-Health', 20),
(159, 'County Laboratory Coordinator', 20),
(160, 'County Logistician', 20),
(161, 'D/Director-HR-Health', 20),
(164, 'Medical Superintendent Muranga\'a Referral hospital', 40),
(165, 'Medical Superintendent Maragua Sub-county hospital', 47),
(167, 'Medical Superintendent Kangema Sub-county hospital', 46),
(169, 'Medical Superintendent Muriranjas Sub-county hospital', 45),
(171, 'Medical Superintendent Kigumo Sub-county hospital', 43),
(172, 'Medical Superintendent Kirwara Sub-county hospital', 41),
(173, 'Medical Superintendent Kandara Sub-county hospital', 42),
(175, 'Medical Superintendent Kenneth Matiba hospital', 44),
(176, 'County Nursing Officer', 20),
(177, 'CECM Youth affairs Culture and Social Services', 18),
(178, 'Director Sports', 18),
(179, 'Director Youth', 18),
(180, 'Director Culture', 18),
(181, 'Director Social Services', 18),
(182, 'Director Accountant Youth Affairs sports culture social services', 18),
(183, 'CECM Communication and Media', 29),
(184, 'Director Communication', 29),
(185, 'CECM Legal', 30),
(186, 'MD Gatamathi', 30),
(187, 'MD Gatanga', 30),
(188, 'MD Mwewasco-Kahuti', 30),
(189, 'MD Muwasco', 30),
(190, 'MD Murang\' a South-Muswasco', 30),
(191, 'CECM Water Irrigation Environment & Natural Resources', 35),
(192, 'CECM Water Irrigation Environment & Natural Resources', 36),
(193, 'CECM Water Irrigation Environment & Natural Resources', 37),
(194, 'CECM Water Irrigation Environment & Natural Resources', 38),
(195, 'CECM Water Irrigation Environment & Natural Resources', 39),
(197, 'Chief of staff Water', 35),
(198, 'Chief of staff Water', 16),
(199, 'Chief of staff Water', 36),
(200, 'Chief of staff Water', 37),
(201, 'Chief of staff Water', 39),
(202, 'Chief of staff Water', 38),
(203, 'MD Gatamathi', 38),
(204, 'MD Gatanga', 35),
(205, 'MD Murang\' a South-Muswasco', 36),
(206, 'MD Mwewasco-Kahuti', 39),
(207, 'MD Muwasco', 37),
(208, 'Chief Officer Health', 14),
(209, 'Hospital Board Member', 14),
(212, 'Medical Superintendent Kangema Sub-county hospital\r\n', 14),
(213, 'Medical Superintendent Maragua Sub-county hospital\r\n\r\n', 14),
(214, 'Medical Superintendent Kigumo Sub-county hospital', 14),
(215, 'Medical Superintendent Muriranjas Sub-county hospital', 14),
(216, 'Medical Superintendent Muranga\'a Referral hospital', 14),
(217, 'Medical Superintendent Kirwara Sub-county hospital', 14),
(218, 'Medical Superintendent Kandara Sub-county hospital', 14),
(219, 'Medical Superintendent Kenneth Matiba hospital', 14),
(221, 'Chief of staff Health', 14),
(222, 'Deputy Director Health', 14),
(223, 'Head of HPTU/Pharms', 14),
(224, 'PA-Health', 14),
(225, 'County Laboratory Coordinator', 14),
(226, 'County Logistician', 14),
(227, 'County Nursing Officer', 14),
(228, 'D/Director-HR-Health', 14),
(229, 'Departmental Accountant Health and Sanitization', 14),
(230, 'County Secretary', 32),
(231, 'Deputy County Secretary', 32),
(232, 'CECM  Lands Physical Planning & Urban Development', 32),
(233, 'CECM  Lands Physical Planning & Urban Development', 33),
(234, 'CECM  Lands Physical Planning & Urban Development', 34),
(235, 'County Secretary\r\n', 33),
(236, 'County Secretary\r\n', 34),
(237, 'Deputy County Secretary', 34),
(238, 'Deputy County Secretary', 33),
(239, 'chief of staff Physical Planning', 32),
(240, 'chief of staff Physical Planning', 33),
(241, 'chief of staff Physical Planning', 34),
(242, 'Director Physical Planning', 32),
(243, 'Director Physical Planning', 33),
(244, 'Director Physical Planning', 34),
(245, 'Member of Municipal Board', 32),
(246, 'Member of Municipal Board', 33),
(247, 'Member of Municipal Board', 34),
(248, 'Advisor of the Governor', 10),
(249, 'Member Muranga\'a Referral hospital', 40),
(250, 'Member Kirwara Sub-county hospitaL', 41),
(251, 'Member Kandara Sub-county hospital', 42),
(252, 'Member Kigumo Sub-county hospital', 43),
(253, 'Member Kenneth Matiba Hospital', 44),
(254, 'Member Muriranjas Sub-county hospital', 45),
(255, 'Member Kangema Sub-county hospital', 46),
(256, 'Member Maragwa subcounty Hospital', 47),
(257, 'Admin Muranga\'a Referral hospital  ', 40),
(258, 'Admin Kirwara Sub-county hospital', 41),
(259, 'Admin Kandara Sub-county hospital', 42),
(260, 'Admin Kigumo Sub-county hospital', 43),
(261, 'Admin Kenneth Matiba hospital', 44),
(262, 'Admin Muriranjas Sub-county hospital', 45),
(263, 'Admin Kangema Sub-county hospital', 46),
(264, 'Admin Maragua Sub-county hospital', 47),
(265, 'Chief Officer Revenue', 31),
(266, 'Chief Officer Supply Chain', 31),
(267, 'Chief Officer Legal', 30),
(268, 'Member of Legal Department', 30),
(269, 'Member of 	\r\nDepartment of Revenue and Supply Chain', 31),
(270, 'Chief Officer Communication and Media', 29),
(271, 'Member Department of Communication and Media', 29),
(272, 'Member County Public Service Board', 28),
(273, 'Secretary County Public Service Board', 28),
(274, 'CECM County Public Service Board', 28),
(275, 'Chair County Public Service Board', 28),
(276, 'Chief officer Department of County Public Service Board', 28),
(277, 'Member of Department of Murang’a County Budget and Economic Council', 27),
(278, 'CECM Murang’a County Budget and Economic Council', 27),
(279, 'Chair Economic Council', 27),
(280, 'Secretariat Economic Council', 27),
(281, 'Chief officer Economic Council', 27),
(282, 'CECM Devolution and External Linkages', 26),
(283, 'Chief officer Devolution and External Linkages', 26),
(284, 'Director Devolution and External Linkages', 26),
(285, 'Member Devolution and External Linkages', 26),
(286, 'Member Department of Governorship County Coordination and Administration', 25),
(287, 'Chief Officer Department of Governorship County Coordination and Administration', 25),
(288, 'CECM Public Administration & ICT', 24),
(289, 'Chief Officer Public Administration & ICT', 24),
(290, 'Director Public Administration & ICT', 24),
(291, 'Member Public Administration & ICT', 24),
(292, 'Chief Officer ICT', 24),
(293, 'CECM Agriculture Livestock & Cooperatives', 23),
(294, 'CECM Trade Industrialization & Tourism', 23),
(295, 'Chief officer Trade', 23),
(296, 'Chief officer agriculture', 23),
(297, 'Director Trade', 23),
(298, 'Director Agriculture', 23),
(299, 'Member Department of Agriculture Livestock & Cooperatives', 23),
(300, 'CECM Education & Technical Training', 22),
(301, 'Chief officer Education', 22),
(302, 'Director  Education', 22),
(303, 'Chief officer Technical Training', 22),
(304, 'Director Technical Training', 22),
(305, 'Member Education & Technical Training', 22),
(306, 'Member Department of Lands Physical Planning & Urban Development', 21),
(307, 'Director Health ', 20),
(308, 'Member Department of Health and Sanitization', 20),
(309, 'Chief Officer Finance', 19),
(310, 'Chief Officer Economic Planning', 19),
(311, 'Member Department of Finance & Economic Planning', 19),
(312, 'Member Department of Youth affairs Culture and Social Services', 18),
(313, 'Chief Officer Youth', 18),
(314, 'Chief Officer Culture ', 18),
(315, 'Chief Officer  Sports', 18),
(316, 'Chief Officer Roads', 17),
(317, 'Chief Officer Infrastructure ', 17),
(318, 'Member Department of Roads Housing & Infrastructure', 17),
(319, 'CECM Roads Housing & Infrastructure', 17),
(320, 'CECM Water Irrigation Environment & Natural Resources', 16),
(321, 'Member Department of  Water Irrigation Environment & Natural Resources', 16),
(322, 'Governor', 27),
(323, 'CECM Agriculture Livestock & Cooperatives', 3),
(324, 'CECM Trade Industrialization & Tourism', 3),
(325, 'CECM Water Irrigation Environment & Natural Resources', 3),
(326, 'CECM Roads Housing & Infrastructure', 3),
(327, 'CECM Youth affairs Culture and Social Services', 3),
(328, 'CECM Finance & Economic Planning', 3),
(329, 'CECM Health and Sanitization', 3),
(330, 'CECM Lands Physical Planning & Urban Development', 3),
(331, 'CECM Education & Technical Training', 3),
(332, 'CECM Public Administration & ICT', 3),
(333, 'CECM Governorship County Coordination and Administration', 3),
(334, 'CECM Devolution and External Linkages', 3),
(335, 'CECM County Public Service Board', 3),
(336, 'CECM Communication and Media', 3),
(337, 'CECM Legal', 3),
(338, 'CECM Murang’a County Budget and Economic Council', 3),
(339, 'Director Sports', 3),
(340, 'Director Youth', 3),
(341, 'Director Culture', 3),
(342, 'Director Social Services', 3),
(343, 'Director Accountant Youth Affairs sports culture social services', 3),
(344, 'Director Finance', 3),
(345, 'Director Budget', 3),
(346, 'Director Accounting Services', 3),
(347, 'Director Economic Planning', 3),
(348, 'Director Internal Audit', 3),
(349, 'Director Health', 3),
(350, 'D/Director-HR-Health', 3),
(351, 'Director Survey', 3),
(352, 'Director Valuation', 3),
(353, 'Director Education', 3),
(354, 'Director Technical Training', 3),
(355, 'Director Trade', 3),
(356, 'Director Agriculture', 3),
(357, 'Director Public Administration & ICT', 3),
(358, 'Director Transport', 3),
(359, 'Director Disaster and Fire', 3),
(360, 'Director Admin', 3),
(361, 'Director Accountant', 3),
(362, 'Director Devolution and External Linkages', 3),
(363, 'Medical Superintendent Kangema Sub-county hospital', 3),
(364, 'Medical Superintendent Maragua Sub-county hospital', 3),
(365, 'Medical Superintendent Kigumo Sub-county hospital', 3),
(366, 'Medical Superintendent Muriranjas Sub-county hospital', 3),
(367, 'Medical Superintendent Muranga\'a Referral hospital', 3),
(368, 'Medical Superintendent Kirwara Sub-county hospital', 3),
(369, 'Medical Superintendent Kandara Sub-county hospital', 3),
(370, 'Medical Superintendent Kenneth Matiba hospital', 3),
(371, 'Governor', 27),
(372, 'Deputy Governor', 27),
(373, 'CECM Agriculture Livestock & Cooperatives', 27),
(374, 'CECM Trade Industrialization & Tourism', 27),
(375, 'CECM Water Irrigation Environment & Natural Resources', 27),
(376, 'CECM Roads Housing & Infrastructure', 27),
(377, 'CECM Youth affairs Culture and Social Services', 27),
(378, 'CECM Finance & Economic Planning', 27),
(379, 'CECM Health and Sanitization', 27),
(380, 'CECM Lands Physical Planning & Urban Development', 27),
(381, 'CECM Education & Technical Training', 27),
(382, 'CECM Public Administration & ICT', 27),
(383, 'CECM Governorship County Coordination and Administration', 27),
(384, 'CECM Devolution and External Linkages', 27),
(385, 'CECM County Public Service Board', 27),
(386, 'CECM Communication and Media', 27),
(387, 'CECM Legal', 27),
(388, 'CECM Murang’a County Budget and Economic Council', 27);

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
  `type` varchar(1000) NOT NULL,
  `date` date NOT NULL,
  `location` text NOT NULL,
  `time` time(6) NOT NULL,
  `attendees` varchar(10000) NOT NULL,
  `agenda` varchar(10000) NOT NULL,
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
(1, 'Benard Kariuki', 'County Sec', 'Benardk', 1),
(7, 'winnie Kuria', '20200462759', 'Winniek', 3),
(10, 'Dorcas', 'Dorcas', 'Dorcas', 3),
(21, 'Secretary', 'Secretary', 'Secretary', 3),
(25, 'Council Secretary', 'council sec', 'council sec', 3),
(26, 'Admin', 'Admin', 'Admin', 1),
(27, 'Naserian', 'Naserian', 'Naserian', 1),
(28, 'Meshack Kipkorir', 'Meshack', 'Meshack', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `departmental`
--
ALTER TABLE `departmental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=389;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `minutes`
--
ALTER TABLE `minutes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
