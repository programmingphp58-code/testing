-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 04, 2023 at 02:41 PM
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
-- Database: `federal`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `acct_image` varchar(255) DEFAULT 'user.png',
  `internetid` varchar(50) DEFAULT NULL,
  `current_acctno` varchar(255) DEFAULT NULL,
  `savings_acctno` varchar(255) DEFAULT NULL,
  `acct_currency` varchar(55) DEFAULT '$',
  `savings_balance` varchar(255) DEFAULT '0',
  `loan_balance` varchar(255) DEFAULT '0',
  `current_balance` varchar(255) DEFAULT '0',
  `acct_status` varchar(50) DEFAULT 'hold' COMMENT 'active, hold',
  `kyc_status` int(11) DEFAULT 0 COMMENT '1=Approved, 2=processing, 0=Pending',
  `kyc_pending` int(11) NOT NULL DEFAULT 1 COMMENT '1 = approved, 0 = pending',
  `phoneverify` int(11) NOT NULL DEFAULT 1 COMMENT '1 = verified, 0 = unverified',
  `acct_email` varchar(200) DEFAULT NULL,
  `acct_phone` varchar(20) DEFAULT NULL,
  `acct_gender` text DEFAULT NULL,
  `acct_dob` varchar(255) DEFAULT NULL,
  `state` text DEFAULT NULL,
  `acct_ssn` varchar(255) DEFAULT NULL,
  `acct_address` text DEFAULT NULL,
  `acct_password` text DEFAULT NULL,
  `resettoken` varchar(50) DEFAULT NULL,
  `resettokenexp` date DEFAULT NULL,
  `billing_code` int(55) DEFAULT 0,
  `transfer` int(55) DEFAULT 1,
  `idfront` varchar(255) DEFAULT NULL,
  `idBack` varchar(255) DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `proofaddress` varchar(255) DEFAULT NULL,
  `acct_pin` varchar(6) DEFAULT '123456',
  `acct_otp` varchar(6) DEFAULT '876545',
  `manager_name` varchar(255) DEFAULT NULL,
  `manager_email` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `developer_name` varchar(255) DEFAULT '''Ofofonobs''',
  `Developer_phone` varchar(255) DEFAULT '''2348114313795'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `firstname`, `lastname`, `acct_image`, `internetid`, `current_acctno`, `savings_acctno`, `acct_currency`, `savings_balance`, `loan_balance`, `current_balance`, `acct_status`, `kyc_status`, `kyc_pending`, `phoneverify`, `acct_email`, `acct_phone`, `acct_gender`, `acct_dob`, `state`, `acct_ssn`, `acct_address`, `acct_password`, `resettoken`, `resettokenexp`, `billing_code`, `transfer`, `idfront`, `idBack`, `id_no`, `proofaddress`, `acct_pin`, `acct_otp`, `manager_name`, `manager_email`, `createdAt`, `developer_name`, `Developer_phone`) VALUES
(1, 'Ofofonobs', 'Developer', 'user.png', '3000615625', '7654456987', '3597456900', '$', '20', '789', '8993', 'active', 0, 1, 0, 'ofofonobs@gmail.com', '2348114313795', 'Male', '1997-08-06', 'Ibadan', '876556709789', '54, Old Ife Road', '$2y$10$GvESYvpe6vYllRs5GvquiOCieanLtQIFp2cc4mT/fFc.DHmyKAv5O', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, '123456', NULL, '', 'manager@dirtyscript.shop', '2023-06-07 10:24:46', '\'Ofofonobs\'', '\'2348114313795\'');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(55) NOT NULL,
  `internetid` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `adminimage` text DEFAULT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `adminimage`, `admin_email`, `admin_password`) VALUES
(1, 'Ofofonobs', 'Developer', 'user.png', 'support@dirtyscripts.shop', '$2y$10$GvESYvpe6vYllRs5GvquiOCieanLtQIFp2cc4mT/fFc.DHmyKAv5O');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `internetid` varchar(255) DEFAULT NULL,
  `device` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ipAddress` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `datenow` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `seria_key` text NOT NULL,
  `internetid` varchar(255) NOT NULL,
  `card_number` text NOT NULL,
  `card_name` text NOT NULL,
  `card_expiration` varchar(50) NOT NULL,
  `card_security` text NOT NULL,
  `payment_account` varchar(255) NOT NULL,
  `card_limit` double NOT NULL DEFAULT 5000,
  `card_limit_remain` double NOT NULL DEFAULT 5000,
  `card_status` int(11) DEFAULT 2 COMMENT '1=Active,2=Process,3=hold, 4=PAUSE',
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `digital_payment`
--

CREATE TABLE `digital_payment` (
  `id` int(11) NOT NULL,
  `crypto_name` varchar(200) NOT NULL,
  `wallet_address` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `digital_payment`
--

INSERT INTO `digital_payment` (`id`, `crypto_name`, `wallet_address`, `created_at`) VALUES
(1, 'Bitcoin', 'bc1qz90y4ydmcwzy3fl55rammn5x2cuncxl0d998ld', '2022-11-06 21:58:35'),
(5, 'Etheruem', '0x1A3e0a84031b2F655684473D7FE96072cBb9807E', '2022-11-06 21:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `title`, `content`, `createdAt`) VALUES
(1, 'Get started', 'How to register a account', '2023-09-29 10:21:11'),
(2, 'How to send wire transfer', 'When sending wire transfer, u need to ....... soooooooo', '2023-09-29 10:21:11');

-- --------------------------------------------------------

--
-- Table structure for table `list_payment`
--

  CREATE TABLE `list_payment` (
    `id` int(55) NOT NULL,
    `internetid` varchar(255) NOT NULL,
    `bname` varchar(255) NOT NULL,
    `baddress` varchar(255) NOT NULL,
    `account_name` varchar(255) NOT NULL,
    `refrence_id` varchar(255) NOT NULL,
    `iban` varchar(255) NOT NULL,
    `swift_code` varchar(255) NOT NULL,
    `createdAt` datetime NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

  --
  -- Dumping data for table `list_payment`
  --

  INSERT INTO `list_payment` (`id`, `internetid`, `bname`, `baddress`, `account_name`, `refrence_id`, `iban`, `swift_code`, `createdAt`) VALUES
  (1, '3000615625', 'USa Bank', 'Old New York USA', 'David Huggins', '34567890987', '876545678', '987787654456', '2023-10-13'),
  (2, '1202215933', 'New Bank', 'Old New York USA', 'James Huggins', '34567890987', '876545678', '4567898765', '2023-10-13');


--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `website_name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Name',
  `website_tel` varchar(15) DEFAULT NULL COMMENT 'Company Number',
  `website_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Email',
  `website_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Address',
  `image` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Logo',
  `padiwise_sms` int(11) NOT NULL DEFAULT 0 COMMENT '1=Activate, 0=Disactivate',
  `billing_code` int(11) NOT NULL DEFAULT 1 COMMENT '1=Activate, 0=Disactivate',
  `kyc_status` int(11) NOT NULL DEFAULT 0 COMMENT ' 	1=Activate, 0=Disactivate',
  `transfer` int(11) NOT NULL DEFAULT 1 COMMENT '1=Activate, 0=Disactivate',
  `cot_code` varchar(11) NOT NULL DEFAULT 'COT5654',
  `tax_code` varchar(11) NOT NULL DEFAULT 'TAX8765',
  `imf_code` varchar(11) NOT NULL DEFAULT 'IMF9876',
  `otp_code` int(11) NOT NULL DEFAULT 1 COMMENT '1=On, 0=Off',
  `cardfee` text NOT NULL,
  `selffee` text DEFAULT NULL,
  `wirefee` text DEFAULT NULL,
  `domesticfee` text DEFAULT NULL,
  `loanlimit` varchar(255) DEFAULT '1000000',
  `domesticlimit` varchar(255) DEFAULT '50000000',
  `wirelimit` varchar(255) DEFAULT '50000000',
  `currency` varchar(255) DEFAULT '$',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_name`, `website_tel`, `website_email`, `website_address`, `image`, `padiwise_sms`, `billing_code`, `kyc_status`, `transfer`, `cot_code`, `tax_code`, `imf_code`, `otp_code`, `cardfee`, `selffee`, `wirefee`, `domesticfee`, `loanlimit`, `domesticlimit`, `wirelimit`, `currency`, `created_at`) VALUES
(1, 'Federal Bank Script', '2348114313795', 'support@dirtyscripts.shop', '3 Abbey Road, San Francisco CA 94102', 'logo.png', 0, 1, 0, 1, 'COT7678', 'TAX7678', 'IMF6578', 1, '20', '28', '35', '30', '1000000', '50000000', '50000000', '$', '2023-03-28 14:51:33');

-- --------------------------------------------------------

--
-- Table structure for table `sms_api`
--

CREATE TABLE `sms_api` (
  `id` int(11) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `access_token` text DEFAULT NULL,
  `transaction_pin` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_api`
--

INSERT INTO `sms_api` (`id`, `display_name`, `access_token`, `transaction_pin`) VALUES
(1, 'SenderID', 'paste access token here', '0000');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_setting`
--

CREATE TABLE `smtp_setting` (
  `id` int(11) NOT NULL,
  `host` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `smtp_from` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `port` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `smtp_auth` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smtp_setting`
--

INSERT INTO `smtp_setting` (`id`, `host`, `username`, `smtp_from`, `password`, `port`, `display_name`, `smtp_auth`) VALUES
(1, 'dirtyscripts.shop', '_mainaccount@dirtyscripts.shop', 'support@dirtyscripts.shop', 'Password', '465', 'Union Demo Scripts', 'ssl');

-- --------------------------------------------------------

--
-- Table structure for table `temp_dumps`
--

CREATE TABLE `temp_dumps` (
  `trans_id` int(11) NOT NULL,
  `internetid` varchar(255) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `account_number` text DEFAULT NULL,
  `account_name` text DEFAULT NULL,
  `bank_name` text DEFAULT NULL,
  `routine_number` text DEFAULT NULL,
  `account_type` text DEFAULT NULL,
  `payment_account` text DEFAULT NULL,
  `bank_country` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `trans_type` text DEFAULT NULL,
  `transaction_type` text DEFAULT NULL,
  `refrence_id` text DEFAULT NULL,
  `trans_status` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `internetid` varchar(255) NOT NULL,
  `ticket_message` text NOT NULL,
  `ticket_type` varchar(255) DEFAULT 'ticket',
  `image` varchar(255) DEFAULT NULL,
  `ticket_status` varchar(255) NOT NULL DEFAULT 'open' COMMENT 'approved,open, closed, processing',
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `trans_id` int(11) NOT NULL,
  `internetid` varchar(255) NOT NULL,
  `crypto_id` int(11) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `account_number` text DEFAULT NULL,
  `account_name` text DEFAULT NULL,
  `bank_name` text DEFAULT NULL,
  `loan_type` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `routine_number` text DEFAULT NULL,
  `account_type` text DEFAULT NULL,
  `payment_account` text DEFAULT NULL,
  `bank_country` text DEFAULT NULL,
  `trans_type` text DEFAULT NULL,
  `transaction_type` text DEFAULT NULL,
  `refrence_id` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `trans_status` text DEFAULT NULL COMMENT 'completed, pending, processing, failed.',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `digital_payment`
--
ALTER TABLE `digital_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faq_id`);


--
-- Indexes for table `list_payment`
--
ALTER TABLE `list_payment`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_api`
--
ALTER TABLE `sms_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_dumps`
--
ALTER TABLE `temp_dumps`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`trans_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_payment`
--
ALTER TABLE `digital_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `list_payment`
--
ALTER TABLE `list_payment`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_api`
--
ALTER TABLE `sms_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temp_dumps`
--
ALTER TABLE `temp_dumps`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
