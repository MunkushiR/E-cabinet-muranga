-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 07:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `log_type`, `datetime_log`, `date_updated`) VALUES
(10, 9, 1, '2020-09-16 08:00:00', '2020-09-29 16:16:57'),
(11, 9, 2, '2020-09-16 12:00:00', '2020-09-29 16:16:57'),
(12, 9, 3, '2020-09-16 13:00:00', '2020-09-29 16:16:57'),
(16, 9, 4, '2020-09-16 17:00:00', '2020-09-29 16:16:57');

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
(4, 'Budget and economic council');

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
(2, 'minutes of the cabinet meeting.pdf', '66a2caafcf7b51.11428408.pdf', 'application/pdf', '2024-07-25 21:59:11'),
(3, 'MINUTES OF THE CABINET MEETING 28TH FEB.pdf', '66ab2fa52b6387.45098804.pdf', 'application/pdf', '2024-08-01 06:48:05');

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
(9, 'Pius Njuguna', 'Macharia', '2345167', 'Chief of staff', 'kiptoke@ueab.ac.ke', '0789467833', 223435767, ''),
(10, 'Janet ', 'Naliaka', 'WKUC29', 'Deputy Governor', 'janetnaliaka@wkuc.com', '0707235678', 23457889, ''),
(11, 'Isaac', 'Wainaina', 'IWA3467', 'Director(s) of the department', 'wainainaisaiah@gmail.com', '0789563415', 345799689, ''),
(32, 'John', 'Marande', 'MJ12345', 'Chief officer of the Department', 'marandej@wku.adventist.org', '734572018', 0, ''),
(36, 'H.E Dr Irungu ', 'Kang\'ata', '20200462759', 'Governor', 'irungu@muranga.com', '0783736388', 26425599, '');

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
(1, 'Board mee', '2024-06-02 09:57:00', '2024-06-02 10:57:00', 0, 'Bungoma', 1, 0),
(2, 'CEE meeting', '2024-06-02 10:10:00', '2024-06-02 02:15:00', 1, 'Kisumu', 0, 0),
(3, 'Assembly', '2024-06-13 08:10:00', '2024-06-02 09:10:00', 0, 'Kisumu', 1, 0),
(4, 'Conference meeting', '2024-06-13 11:30:00', '2024-06-02 12:30:00', 0, 'Conference hall', 1, 0),
(5, 'Budget planning', '2024-06-06 08:00:00', '2024-06-06 11:00:00', 0, 'Conference hall', 0, 0),
(6, 'Board meeting', '2024-07-29 09:03:00', '2024-07-29 11:05:00', 0, 'Conference hall', 1, 0);

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

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `type`, `title`, `date`, `time`, `present_members`, `agenda`, `absent`, `attendees`, `content`, `signed_by`, `file`) VALUES
(9, 'Budget and economic council', 'Meeting held to discuss and come up with the budget for the year 2024', '2024-06-07', '09:00:00', 'Paul Ng\'anga\r\nPhilip Musau', '1. Interviews2. Awards and appreciations', 'none', 'all governor working committee members', 'come with departmental plans', 'Paul Francis', 'downloads/MINUTES OF THE CABINET MEETING 28TH FEB.pdf'),
(13, 'Budget and economic council', 'Meeting held to discuss and come up with the budget for the year 2024', '2024-06-14', '00:00:00', '', 'discuss the work plan and come up with a budget', 'none', 'all members of the committee present', 'governors working committee for the year 2024', 'Philip Musau', 'minutes_7.pdf'),
(17, 'Budget and economic council', '', '2024-08-01', '00:00:00', '', 'Checking the progress of each department and presenting their plan for the whole year', 'none', 'all members were present', 'departmental meeting', '', ''),
(21, 'Governors working committee', '', '2024-07-30', '00:00:00', '', 'Checking the progress of each department and presenting their plan for the whole year', 'none', 'all members were present', 'departmental meeting', '', ''),
(22, 'Governors working committee', '', '2024-07-30', '00:00:00', '', 'Checking the progress of each department and presenting their plan for the whole year', 'none', 'all members were present', 'departmental meeting', '', ''),
(23, 'Governors working committee', '', '2024-07-30', '00:00:00', '', 'Checking the progress of each department and presenting their plan for the whole year', 'none', 'all members were present', 'departmental meeting', '', ''),
(24, 'Budget and economic council', '', '2024-07-20', '00:00:00', '', 'Checking the progress of each department and presenting their plan for the whole year', 'none', 'all members were present', 'departmental meeting', '', '');

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
(2, 'Governor\r\n\r\n', 2),
(3, 'Deputy Governor\r\n', 1),
(4, 'County Secretary', 1),
(5, 'Deputy county secretary', 1),
(6, 'All CECMs', 1),
(7, 'County Attorney', 1),
(8, 'Chief of staff', 1),
(9, 'Secretariat Support', 1),
(10, 'Deputy Governor', 2),
(11, 'County Secretary/Deputy County secretary', 2),
(12, 'CECM of the department', 2),
(13, 'Chief officer(s) of the department', 2),
(14, 'Director(s) of the department', 2),
(15, 'Secreatriat support', 2),
(16, 'Governor', 3),
(17, 'Governor', 4),
(18, 'Deputy Governor', 3),
(19, 'Deputy Governor', 4),
(20, 'County Secretary', 3),
(21, 'Deputy County Secretary', 3),
(22, 'All CECMs', 4),
(23, 'Council Members', 4),
(24, 'Council Secretariat', 4);

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

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`user_id`, `subject`, `message`, `from`, `date`, `is_read`) VALUES
(1, 'Project Assistance', 'please assist me with this project on password reset using email', 'Kevin Bengi', '2021-06-28 00:00:00', 0),
(2, 'Project Assistance', 'I will be happy to assist you. I will create a link so that we can work on it together tomorrow', ' Isaiah Wainaina', '2021-06-28 00:00:00', 0),
(3, 'Project Assistance', 'thanks. i will be waiting', 'Kevin Bengi', '2021-06-28 00:00:00', 0),
(4, 'project assistance', 'noted', 'kevin', '2024-06-03 00:00:00', 0),
(5, 'project assistance', 'noted', 'kevin', '2024-07-21 00:00:00', 0);

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
  `file` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `minutes`
--

INSERT INTO `minutes` (`id`, `type`, `date`, `location`, `time`, `attendees`, `file`) VALUES
(6, 'Budget and economic council', '2024-08-02', 'Conference hall', '11:25:00.000000', 'CECM of the department, Chief of staff, Chief officer(s) of the department, Council Members, Council', ''),
(8, 'County Executive Committee(Cabinet) Meeting', '2024-08-09', 'Governors board room', '11:50:00.000000', 'CECM of the department, Governor\r\n, Secretariat Support', ''),
(9, 'Department Evaluation Meetings', '2024-08-16', 'Governors board room', '00:00:00.000000', 'Chief of staff, County Attorney, Deputy county secretary, Deputy Governor, Governor\r\n\r\n', ''),
(18, 'Department Evaluation Meetings', '2024-08-09', 'Governors board room', '12:00:00.000000', 'All CECMs, CECM of the department, Chief of staff, Chief officer(s) of the department, Council Membe', ''),
(19, 'Department Evaluation Meetings', '2024-08-03', 'Governors board room', '07:28:00.000000', 'Deputy Governor, Governor\r\n', 'downloads/minutes_1.pdf'),
(21, 'Budget and economic council', '2024-08-09', 'Conference hall', '12:00:00.000000', 'CECM of the department, Chief of staff', 'downloads/MINUTES OF THE CABINET MEETING 28TH FEB.pdf');

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

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`Id`, `Subject`, `Message`, `From`, `Date`) VALUES
(2, 'Employees Work From Home', 'You are hereby notified that the work from home period has been extended up to June 16th', '', '0000-00-00'),
(4, '', '', '', '0000-00-00'),
(5, 'birthday celebration', 'we are celebrating the birthday of our manager Mr. Peter. you are all invited', 'Welfare department', '2024-07-21');

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
(1, 'Benard Kariuki', '12345678', 'countysec', 1),
(7, 'winie Kuria', '20200462759', '26425599', 2),
(10, 'peter njoroge', '12345678', 'secretary', 2),
(11, 'peter Njuguna', '79978586', 'admin01', 1),
(21, 'Kelvin Wafula', '667786257', 'Steve02', 2),
(26, 'Frank', '556644683', '36684487492', 3),
(27, 'Naserian', '37027741', '37027741', 1),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
