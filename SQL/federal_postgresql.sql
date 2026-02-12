-- PostgreSQL Database Dump
-- Converted from MySQL
-- Database: federal

-- --------------------------------------------------------

--
-- Table structure for table accounts
--

CREATE TABLE accounts (
  id SERIAL PRIMARY KEY,
  firstname VARCHAR(200) DEFAULT NULL,
  lastname VARCHAR(200) DEFAULT NULL,
  acct_image VARCHAR(255) DEFAULT 'user.png',
  internetid VARCHAR(50) DEFAULT NULL,
  current_acctno VARCHAR(255) DEFAULT NULL,
  savings_acctno VARCHAR(255) DEFAULT NULL,
  acct_currency VARCHAR(55) DEFAULT '$',
  savings_balance VARCHAR(255) DEFAULT '0',
  loan_balance VARCHAR(255) DEFAULT '0',
  current_balance VARCHAR(255) DEFAULT '0',
  acct_status VARCHAR(50) DEFAULT 'hold',
  kyc_status INTEGER DEFAULT 0,
  kyc_pending INTEGER NOT NULL DEFAULT 1,
  phoneverify INTEGER NOT NULL DEFAULT 1,
  acct_email VARCHAR(200) DEFAULT NULL,
  acct_phone VARCHAR(20) DEFAULT NULL,
  acct_gender TEXT DEFAULT NULL,
  acct_dob VARCHAR(255) DEFAULT NULL,
  state TEXT DEFAULT NULL,
  acct_ssn VARCHAR(255) DEFAULT NULL,
  acct_address TEXT DEFAULT NULL,
  acct_password TEXT DEFAULT NULL,
  resettoken VARCHAR(50) DEFAULT NULL,
  resettokenexp DATE DEFAULT NULL,
  billing_code INTEGER DEFAULT 0,
  transfer INTEGER DEFAULT 1,
  idfront VARCHAR(255) DEFAULT NULL,
  idBack VARCHAR(255) DEFAULT NULL,
  id_no VARCHAR(255) DEFAULT NULL,
  proofaddress VARCHAR(255) DEFAULT NULL,
  acct_pin VARCHAR(6) DEFAULT '123456',
  acct_otp VARCHAR(6) DEFAULT '876545',
  manager_name VARCHAR(255) DEFAULT NULL,
  manager_email VARCHAR(255) DEFAULT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  developer_name VARCHAR(255) DEFAULT '0000000',
  Developer_phone VARCHAR(255) DEFAULT '00000000'
);

COMMENT ON COLUMN accounts.acct_status IS 'active, hold';
COMMENT ON COLUMN accounts.kyc_status IS '1=Approved, 2=processing, 0=Pending';
COMMENT ON COLUMN accounts.kyc_pending IS '1 = approved, 0 = pending';
COMMENT ON COLUMN accounts.phoneverify IS '1 = verified, 0 = unverified';

--
-- Dumping data for table accounts
--

INSERT INTO accounts (id, firstname, lastname, acct_image, internetid, current_acctno, savings_acctno, acct_currency, savings_balance, loan_balance, current_balance, acct_status, kyc_status, kyc_pending, phoneverify, acct_email, acct_phone, acct_gender, acct_dob, state, acct_ssn, acct_address, acct_password, resettoken, resettokenexp, billing_code, transfer, idfront, idBack, id_no, proofaddress, acct_pin, acct_otp, manager_name, manager_email, createdAt, developer_name, Developer_phone) VALUES
(1, 'Ofofonobs', 'Developer', 'user.png', '3000615625', '7654456987', '3597456900', '$', '20', '789', '8993', 'active', 0, 1, 0, 'ofofonobs@gmail.com', '2348114313795', 'Male', '1997-08-06', 'Ibadan', '876556709789', '54, Old Ife Road', '$2y$10$GvESYvpe6vYllRs5GvquiOCieanLtQIFp2cc4mT/fFc.DHmyKAv5O', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, '123456', '176411', '', 'manager@dirtyscript.shop', '2023-06-07 10:24:46', 'Ofofonobs', '2348114313795'),
(3, 'a', 'a', '1202269464mastercard.png', '1202269464', '36378525987', '67392444987', '$', '2960', '0', '5000', 'active', 0, 1, 1, 'ad@sf.com', '+1 343534634', NULL, NULL, NULL, NULL, NULL, '$2y$10$05xPlWsOb59Ytm8YF/xL1.LYOZoBbhEbUa1hLEthbs9kb093uAWc2', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, '123456', '273957', NULL, NULL, '2024-04-07 13:31:53', 'Ofofonobs', '2348114313795'),
(4, 'dsd', 'dsfsd', 'user.png', '1202260007', '36378333119', '67392285076', '$', '0', '0', '0', 'active', 0, 1, 1, 'programmingphp58@gmail.com', '2347034564522', NULL, NULL, NULL, NULL, NULL, '$2y$10$v0ar2tRB49LXxirCs.ljv.V58oTlQG086uVkmhsdXpAHHUdgVvWO2', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, '123456', '238779', NULL, NULL, '2024-04-07 14:00:36', 'Ofofonobs', '2348114313795');

-- Update sequence
SELECT setval('accounts_id_seq', (SELECT MAX(id) FROM accounts));

-- --------------------------------------------------------

--
-- Table structure for table activities
--

CREATE TABLE activities (
  id SERIAL PRIMARY KEY,
  internetid VARCHAR(255) NOT NULL,
  details VARCHAR(255) NOT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table activities
--

INSERT INTO activities (id, internetid, details, createdAt) VALUES
(1, '3000615625', 'Login into dashboard', '2024-04-06 23:17:47'),
(2, '3000615625', 'Login into dashboard', '2024-04-06 23:21:55'),
(3, '3000615625', 'Login into dashboard', '2024-04-06 23:24:12'),
(4, '3000615625', 'Login into dashboard', '2024-04-06 23:24:23'),
(5, '3000615625', 'Login into dashboard', '2024-04-06 23:25:24'),
(6, '3000615625', 'Login into dashboard', '2024-04-06 23:26:17'),
(7, '3000615625', 'Login into dashboard', '2024-04-06 23:28:14'),
(8, '3000615625', 'Login into dashboard', '2024-04-06 23:28:29'),
(9, '3000615625', 'Login into dashboard', '2024-04-06 23:29:46'),
(10, '3000615625', 'Login into dashboard', '2024-04-06 23:29:50'),
(11, '3000615625', 'Login into dashboard', '2024-04-06 23:29:59'),
(12, '3000615625', 'Login into dashboard', '2024-04-06 23:30:11'),
(13, '3000615625', 'Login into dashboard', '2024-04-06 23:30:31'),
(14, '3000615625', 'Login into dashboard', '2024-04-06 23:36:53'),
(15, '3000615625', 'Login into dashboard', '2024-04-06 23:43:52'),
(16, '3000615625', 'Login into dashboard', '2024-04-06 23:46:23'),
(17, '3000615625', 'Login into dashboard', '2024-04-06 23:48:18'),
(18, '3000615625', 'Login into dashboard', '2024-04-06 23:51:31'),
(19, '3000615625', 'Login into dashboard', '2024-04-07 12:04:48'),
(20, '3000615625', 'Login into dashboard', '2024-04-07 12:12:30'),
(21, '3000615625', 'Login into dashboard', '2024-04-07 12:22:40'),
(22, '3000615625', 'Login into dashboard', '2024-04-07 12:52:25'),
(23, '3000615625', 'Login into dashboard', '2024-04-07 13:05:51'),
(24, '1202269464', 'New Registration', '2024-04-07 13:31:53'),
(25, '3000615625', 'Login into dashboard', '2024-04-07 13:51:12'),
(26, '3000615625', 'Login into dashboard', '2024-04-07 13:51:43'),
(27, '1202269464', 'Login into dashboard', '2024-04-07 13:52:19'),
(28, '1202269464', 'Login into dashboard', '2024-04-07 13:53:39'),
(29, '3000615625', 'Login into dashboard', '2024-04-07 13:58:07'),
(30, '1202269464', 'Login into dashboard', '2024-04-07 13:59:02'),
(31, '1202260007', 'New Registration', '2024-04-07 14:00:37'),
(32, '1202269464', 'Login into dashboard', '2024-04-07 14:02:06'),
(33, '1202269464', 'Login into dashboard', '2024-04-07 14:39:24'),
(34, '1202260007', 'Login into dashboard', '2024-04-07 19:43:50'),
(35, '1202269464', 'Login into dashboard', '2024-04-07 20:03:44'),
(36, '3000615625', 'Login into dashboard', '2024-04-07 20:05:10'),
(37, '3000615625', 'Login into dashboard', '2024-04-07 20:05:27'),
(38, '1202260007', 'Login into dashboard', '2024-04-07 20:08:17'),
(39, '1202260007', 'Login into dashboard', '2024-04-07 20:11:22'),
(40, '1202269464', 'Login into dashboard', '2024-04-07 20:17:39'),
(41, '1202269464', 'New Crypto Deposit', '2024-04-07 20:24:16'),
(42, '1202269464', 'New Wire Transfer', '2024-04-07 20:47:42'),
(43, '1202269464', 'New Crypto Deposit', '2024-04-07 20:50:00'),
(44, '1202269464', 'Login into dashboard', '2024-04-07 20:56:17'),
(45, '1202269464', 'Profile Picture Upadate', '2024-04-07 21:00:57'),
(46, '1202269464', 'Login into dashboard', '2024-04-08 13:49:18'),
(47, '1202269464', 'Login into dashboard', '2024-04-08 13:49:34'),
(48, '1202269464', 'Login into dashboard', '2024-04-08 13:55:08'),
(49, '3000615625', 'Login into dashboard', '2024-04-08 13:56:25'),
(50, '1202269464', 'Login into dashboard', '2024-04-08 13:58:21'),
(51, '3000615625', 'Login into dashboard', '2024-04-08 13:59:25'),
(52, '1202269464', 'Login into dashboard', '2024-04-08 14:00:26'),
(53, '1202269464', 'Login into dashboard', '2024-04-08 14:03:37'),
(54, '1202269464', 'Login into dashboard', '2024-04-08 14:05:06'),
(55, '1202269464', 'Login into dashboard', '2024-04-08 14:05:58'),
(56, '1202269464', 'Login into dashboard', '2024-04-08 14:06:11'),
(57, '1202269464', 'Login into dashboard', '2024-04-08 18:45:03'),
(58, '1202269464', 'Card Application', '2024-04-08 19:26:58'),
(59, '1202269464', 'Card Application', '2024-04-08 19:27:50'),
(60, '1202269464', 'Login into dashboard', '2024-04-08 20:11:56'),
(61, '1202269464', 'Login into dashboard', '2024-04-08 20:21:40'),
(62, '1202269464', 'Login into dashboard', '2024-04-08 20:35:18'),
(63, '1202269464', 'Login into dashboard', '2024-04-08 20:42:06'),
(64, '1202269464', 'Login into dashboard', '2024-04-08 20:54:46'),
(65, '3000615625', 'Login into dashboard', '2024-04-08 21:02:35'),
(66, '1202269464', 'Login into dashboard', '2024-04-08 21:16:08'),
(67, '1202269464', 'Login into dashboard', '2024-04-09 19:23:33'),
(68, '1202269464', 'Login into dashboard', '2024-04-12 10:42:30'),
(69, '1202269464', 'Login into dashboard', '2024-04-12 10:43:24');

SELECT setval('activities_id_seq', (SELECT MAX(id) FROM activities));

-- --------------------------------------------------------

--
-- Table structure for table admin
--

CREATE TABLE admin (
  id SERIAL PRIMARY KEY,
  firstname VARCHAR(200) NOT NULL,
  lastname VARCHAR(200) NOT NULL,
  adminimage TEXT DEFAULT NULL,
  admin_email VARCHAR(200) NOT NULL,
  admin_password VARCHAR(200) NOT NULL
);

--
-- Dumping data for table admin
--

INSERT INTO admin (id, firstname, lastname, adminimage, admin_email, admin_password) VALUES
(1, 'Highlander', 'Gavenstky', 'user.png', 'admin@admin.admin', '$2y$10$GvESYvpe6vYllRs5GvquiOCieanLtQIFp2cc4mT/fFc.DHmyKAv5O');

SELECT setval('admin_id_seq', (SELECT MAX(id) FROM admin));

-- --------------------------------------------------------

--
-- Table structure for table audit_logs
--

CREATE TABLE audit_logs (
  id SERIAL PRIMARY KEY,
  internetid VARCHAR(255) DEFAULT NULL,
  device TEXT NOT NULL,
  ipAddress VARCHAR(200) NOT NULL,
  datenow TIMESTAMP NULL DEFAULT NULL
);

--
-- Dumping data for table audit_logs
--

INSERT INTO audit_logs (id, internetid, device, ipAddress, datenow) VALUES
(1, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:17:47'),
(2, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:21:55'),
(3, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:24:12'),
(4, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:24:23'),
(5, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:25:24'),
(6, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:26:16'),
(7, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:28:14'),
(8, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:28:29'),
(9, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:29:46'),
(10, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:29:49'),
(11, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:29:58'),
(12, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:30:11'),
(13, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:30:31'),
(14, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:36:53'),
(15, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:43:52'),
(16, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:46:23'),
(17, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:48:18'),
(18, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-06 23:51:31'),
(19, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 12:04:48'),
(20, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 12:12:30'),
(21, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 12:22:40'),
(22, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 12:52:25'),
(23, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:05:50'),
(24, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:31:53'),
(25, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:51:12'),
(26, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:51:43'),
(27, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:52:19'),
(28, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:53:39'),
(29, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:58:07'),
(30, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 13:59:02'),
(31, '1202260007', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 14:00:36'),
(32, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 14:02:06'),
(33, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 14:39:24'),
(34, '1202260007', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 19:43:50'),
(35, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 20:03:43'),
(36, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 20:05:10'),
(37, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 20:05:26'),
(38, '1202260007', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 20:08:17'),
(39, '1202260007', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 20:11:21'),
(40, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 20:17:39'),
(41, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-07 20:56:17'),
(42, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 13:49:17'),
(43, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 13:49:34'),
(44, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 13:55:08'),
(45, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 13:56:25'),
(46, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 13:58:21'),
(47, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 13:59:25'),
(48, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 14:00:26'),
(49, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 14:03:37'),
(50, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 14:05:05'),
(51, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 14:05:58'),
(52, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 14:06:11'),
(53, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 18:45:02'),
(54, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 20:11:55'),
(55, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 20:21:40'),
(56, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 20:35:18'),
(57, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 20:42:06'),
(58, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 20:54:46'),
(59, '3000615625', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 21:02:35'),
(60, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-08 21:16:08'),
(61, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-09 19:23:33'),
(62, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-12 10:42:30'),
(63, '1202269464', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 OPR/95.0.0.0 (Edition Campaign 34)', '::1', '2024-04-12 10:43:24');

SELECT setval('audit_logs_id_seq', (SELECT MAX(id) FROM audit_logs));

-- --------------------------------------------------------

--
-- Table structure for table card
--

CREATE TABLE card (
  id SERIAL PRIMARY KEY,
  seria_key TEXT NOT NULL,
  internetid VARCHAR(255) NOT NULL,
  card_number TEXT NOT NULL,
  card_name TEXT NOT NULL,
  card_expiration VARCHAR(50) NOT NULL,
  card_security TEXT NOT NULL,
  payment_account VARCHAR(255) NOT NULL,
  card_limit DOUBLE PRECISION NOT NULL DEFAULT 5000,
  card_limit_remain DOUBLE PRECISION NOT NULL DEFAULT 5000,
  card_status INTEGER DEFAULT 2,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

COMMENT ON COLUMN card.card_status IS '1=Active,2=Process,3=hold, 4=PAUSE';

--
-- Dumping data for table card
--

INSERT INTO card (id, seria_key, internetid, card_number, card_name, card_expiration, card_security, payment_account, card_limit, card_limit_remain, card_status, createdAt) VALUES
(1, 'CARD661436f20fd5b', '1202269464', '5276 7547 8976 3982', 'Credit Card', '06 / 27', '629', 'savings_account', 5000, 5000, 3, '2024-04-08 19:26:58'),
(2, 'CARD661437263de6c', '1202269464', '5276 7547 8976 2331', 'Credit Card', '06 / 27', '285', 'savings_account', 5000, 5000, 3, '2024-04-08 19:27:50');

SELECT setval('card_id_seq', (SELECT MAX(id) FROM card));

-- --------------------------------------------------------

--
-- Table structure for table digital_payment
--

CREATE TABLE digital_payment (
  id SERIAL PRIMARY KEY,
  crypto_name VARCHAR(200) NOT NULL,
  wallet_address TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table digital_payment
--

INSERT INTO digital_payment (id, crypto_name, wallet_address, created_at) VALUES
(1, 'Bitcoin', 'bc1qz90y4ydmcwzy3fl55rammn5x2cuncxl0d998ld', '2022-11-06 21:58:35'),
(5, 'Etheruem', '0x1A3e0a84031b2F655684473D7FE96072cBb9807E', '2022-11-06 21:58:35');

SELECT setval('digital_payment_id_seq', (SELECT MAX(id) FROM digital_payment));

-- --------------------------------------------------------

--
-- Table structure for table faqs
--

CREATE TABLE faqs (
  faq_id SERIAL PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table faqs
--

INSERT INTO faqs (faq_id, title, content, createdAt) VALUES
(1, 'Get started', 'How to register a account', '2023-09-29 10:21:11'),
(2, 'How to send wire transfer', 'When sending wire transfer, u need to ....... soooooooo', '2023-09-29 10:21:11');

SELECT setval('faqs_faq_id_seq', (SELECT MAX(faq_id) FROM faqs));

-- --------------------------------------------------------

--
-- Table structure for table list_payment
--

CREATE TABLE list_payment (
  id SERIAL PRIMARY KEY,
  internetid VARCHAR(255) NOT NULL,
  bname VARCHAR(255) NOT NULL,
  baddress VARCHAR(255) NOT NULL,
  account_name VARCHAR(255) NOT NULL,
  refrence_id VARCHAR(255) NOT NULL,
  iban VARCHAR(255) NOT NULL,
  swift_code VARCHAR(255) NOT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table list_payment
--

INSERT INTO list_payment (id, internetid, bname, baddress, account_name, refrence_id, iban, swift_code, createdAt) VALUES
(1, '3000615625', 'USa Bank', 'Old New York USA', 'David Huggins', '34567890987', '876545678', '987787654456', '2023-10-13 00:00:00'),
(2, '1202215933', 'New Bank', 'Old New York USA', 'James Huggins', '34567890987', '876545678', '4567898765', '2023-10-13 00:00:00');

SELECT setval('list_payment_id_seq', (SELECT MAX(id) FROM list_payment));

-- --------------------------------------------------------

--
-- Table structure for table settings
--

CREATE TABLE settings (
  id SERIAL PRIMARY KEY,
  website_name TEXT NOT NULL,
  website_tel VARCHAR(15) DEFAULT NULL,
  website_email VARCHAR(100) NOT NULL,
  website_address TEXT NOT NULL,
  image TEXT NOT NULL,
  padiwise_sms INTEGER NOT NULL DEFAULT 0,
  billing_code INTEGER NOT NULL DEFAULT 1,
  kyc_status INTEGER NOT NULL DEFAULT 0,
  transfer INTEGER NOT NULL DEFAULT 1,
  cot_code VARCHAR(11) NOT NULL DEFAULT 'COT5654',
  tax_code VARCHAR(11) NOT NULL DEFAULT 'TAX8765',
  imf_code VARCHAR(11) NOT NULL DEFAULT 'IMF9876',
  otp_code INTEGER NOT NULL DEFAULT 1,
  cardfee TEXT NOT NULL,
  selffee TEXT DEFAULT NULL,
  wirefee TEXT DEFAULT NULL,
  domesticfee TEXT DEFAULT NULL,
  loanlimit VARCHAR(255) DEFAULT '1000000',
  domesticlimit VARCHAR(255) DEFAULT '50000000',
  wirelimit VARCHAR(255) DEFAULT '50000000',
  currency VARCHAR(255) DEFAULT '$',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

COMMENT ON COLUMN settings.padiwise_sms IS '1=Activate, 0=Disactivate';
COMMENT ON COLUMN settings.billing_code IS '1=Activate, 0=Disactivate';
COMMENT ON COLUMN settings.kyc_status IS '1=Activate, 0=Disactivate';
COMMENT ON COLUMN settings.transfer IS '1=Activate, 0=Disactivate';
COMMENT ON COLUMN settings.otp_code IS '1=On, 0=Off';

--
-- Dumping data for table settings
--

INSERT INTO settings (id, website_name, website_tel, website_email, website_address, image, padiwise_sms, billing_code, kyc_status, transfer, cot_code, tax_code, imf_code, otp_code, cardfee, selffee, wirefee, domesticfee, loanlimit, domesticlimit, wirelimit, currency, created_at) VALUES
(1, 'Dogwood State Bank', '+1 234 234 0000', 'support@dirtyscripts.shop', '3 Abbey Road, San Francisco CA 94102', 'logo.png', 0, 1, 0, 1, 'COT7678', 'TAX7678', 'IMF6578', 0, '20', '28', '35', '30', '1000000', '50000000', '50000000', '$', '2023-03-28 14:51:33');

SELECT setval('settings_id_seq', (SELECT MAX(id) FROM settings));

-- --------------------------------------------------------

--
-- Table structure for table sms_api
--

CREATE TABLE sms_api (
  id SERIAL PRIMARY KEY,
  display_name VARCHAR(50) NOT NULL,
  access_token TEXT DEFAULT NULL,
  transaction_pin VARCHAR(5) NOT NULL
);

--
-- Dumping data for table sms_api
--

INSERT INTO sms_api (id, display_name, access_token, transaction_pin) VALUES
(1, 'SenderID', 'paste access token here', '0000');

SELECT setval('sms_api_id_seq', (SELECT MAX(id) FROM sms_api));

-- --------------------------------------------------------

--
-- Table structure for table smtp_setting
--

CREATE TABLE smtp_setting (
  id SERIAL PRIMARY KEY,
  host VARCHAR(50) NOT NULL,
  username VARCHAR(255) NOT NULL,
  smtp_from VARCHAR(255) NOT NULL,
  password VARCHAR(50) NOT NULL,
  port VARCHAR(50) NOT NULL,
  display_name VARCHAR(50) NOT NULL,
  smtp_auth VARCHAR(50) NOT NULL
);

--
-- Dumping data for table smtp_setting
--

INSERT INTO smtp_setting (id, host, username, smtp_from, password, port, display_name, smtp_auth) VALUES
(1, 'dirtyscripts.shop', '_mainaccount@dirtyscripts.shop', 'support@dirtyscripts.shop', 'Password', '465', 'Union Demo Scripts', 'ssl');

SELECT setval('smtp_setting_id_seq', (SELECT MAX(id) FROM smtp_setting));

-- --------------------------------------------------------

--
-- Table structure for table temp_dumps
--

CREATE TABLE temp_dumps (
  trans_id SERIAL PRIMARY KEY,
  internetid VARCHAR(255) DEFAULT NULL,
  amount DOUBLE PRECISION NOT NULL DEFAULT 0,
  account_number TEXT DEFAULT NULL,
  account_name TEXT DEFAULT NULL,
  bank_name TEXT DEFAULT NULL,
  routine_number TEXT DEFAULT NULL,
  account_type TEXT DEFAULT NULL,
  payment_account TEXT DEFAULT NULL,
  bank_country TEXT DEFAULT NULL,
  description VARCHAR(255) DEFAULT NULL,
  trans_type TEXT DEFAULT NULL,
  transaction_type TEXT DEFAULT NULL,
  refrence_id TEXT DEFAULT NULL,
  trans_status TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table temp_dumps
--

INSERT INTO temp_dumps (trans_id, internetid, amount, account_number, account_name, bank_name, routine_number, account_type, payment_account, bank_country, description, trans_type, transaction_type, refrence_id, trans_status, created_at) VALUES
(1, '1202269464', 2000, '52323632623', 'afsdf', 'dsg', '34634634', 'Savings', 'savings_account', 'Moldova', 'asgsdhgd', 'Wire transfer', 'debit', '6612f85eb9933', 'completed', '2024-04-07 20:47:42');

SELECT setval('temp_dumps_trans_id_seq', (SELECT MAX(trans_id) FROM temp_dumps));

-- --------------------------------------------------------

--
-- Table structure for table ticket
--

CREATE TABLE ticket (
  ticket_id SERIAL PRIMARY KEY,
  internetid VARCHAR(255) NOT NULL,
  ticket_message TEXT NOT NULL,
  ticket_type VARCHAR(255) DEFAULT 'ticket',
  image VARCHAR(255) DEFAULT NULL,
  ticket_status VARCHAR(255) NOT NULL DEFAULT 'open',
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

COMMENT ON COLUMN ticket.ticket_status IS 'approved,open, closed, processing';

-- --------------------------------------------------------

--
-- Table structure for table transactions
--

CREATE TABLE transactions (
  trans_id SERIAL PRIMARY KEY,
  internetid VARCHAR(255) NOT NULL,
  crypto_id INTEGER DEFAULT NULL,
  amount VARCHAR(255) NOT NULL,
  account_number TEXT DEFAULT NULL,
  account_name TEXT DEFAULT NULL,
  bank_name TEXT DEFAULT NULL,
  loan_type VARCHAR(255) DEFAULT NULL,
  duration VARCHAR(255) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  routine_number TEXT DEFAULT NULL,
  account_type TEXT DEFAULT NULL,
  payment_account TEXT DEFAULT NULL,
  bank_country TEXT DEFAULT NULL,
  trans_type TEXT DEFAULT NULL,
  transaction_type TEXT DEFAULT NULL,
  refrence_id TEXT DEFAULT NULL,
  image TEXT DEFAULT NULL,
  trans_status TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

COMMENT ON COLUMN transactions.trans_status IS 'completed, pending, processing, failed.';

--
-- Dumping data for table transactions
--

INSERT INTO transactions (trans_id, internetid, crypto_id, amount, account_number, account_name, bank_name, loan_type, duration, description, routine_number, account_type, payment_account, bank_country, trans_type, transaction_type, refrence_id, image, trans_status, created_at) VALUES
(1, '1202269464', 1, '5000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'savings_account', NULL, 'Crypto Deposit', 'credit', '6612f2e071c54', '1712517856mastercard.png', 'completed', '2024-04-07 20:24:16'),
(2, '1202269464', NULL, '2000', '52323632623', 'afsdf', 'dsg', NULL, NULL, 'asgsdhgd', '34634634', 'Savings', 'savings_account', 'Moldova', 'Wire transfer', 'debit', '6612f86a16159', NULL, 'completed', '2024-04-07 20:47:54'),
(3, '1202269464', 1, '5000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'current_account', NULL, 'Crypto Deposit', 'credit', '6612f8e897b2a', '1712519400mastercard.png', 'completed', '2024-04-07 20:50:00');

SELECT setval('transactions_trans_id_seq', (SELECT MAX(trans_id) FROM transactions));
