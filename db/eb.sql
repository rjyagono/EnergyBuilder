-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Sep 20, 2019 at 01:12 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `eb_inventory`
--
CREATE DATABASE IF NOT EXISTS `eb_inventory` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `eb_inventory`;

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `business_settings_id` int(11) NOT NULL,
  `type` longtext,
  `status` varchar(10) DEFAULT NULL,
  `value` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `picture` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coa`
--

CREATE TABLE `coa` (
  `MAIN_CODE` varchar(1) NOT NULL,
  `SUB_CODE` varchar(2) NOT NULL,
  `TR_HEAD` varchar(4) NOT NULL,
  `HEAD_TITLE` varchar(100) NOT NULL,
  `AMOUNT` float DEFAULT NULL,
  `EFFECTED_DATE` date DEFAULT NULL,
  `UNIQUE_NO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coa_trans`
--

CREATE TABLE `coa_trans` (
  `VNO` int(11) NOT NULL,
  `SNO` int(2) DEFAULT NULL,
  `PART` varchar(500) DEFAULT NULL,
  `DRCR` varchar(1) DEFAULT NULL,
  `TRDATE` date NOT NULL,
  `VALDATE` date DEFAULT NULL,
  `SUPFLAG` int(1) DEFAULT NULL,
  `AMOUNT` float DEFAULT NULL,
  `REFNO` varchar(10) DEFAULT NULL,
  `PAIDTO` varchar(100) DEFAULT NULL,
  `TRANS_TYPE` varchar(2) DEFAULT NULL,
  `MAIN_CODE` varchar(1) NOT NULL,
  `SUB_CODE` varchar(2) NOT NULL,
  `TR_HEAD` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(100) DEFAULT NULL,
  `fax_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_information`
--

CREATE TABLE `company_information` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `website` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currency_settings`
--

CREATE TABLE `currency_settings` (
  `currency_settings_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `exchange_rate` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `exchange_rate_def` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(100) DEFAULT NULL,
  `fax_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `trn` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `id` int(1) NOT NULL,
  `host` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `port` int(3) NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sent_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sent_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `reply_email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `reply_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EMP_NO` varchar(20) CHARACTER SET utf8 NOT NULL,
  `EMP_NAME` varchar(40) CHARACTER SET utf8 NOT NULL,
  `EMP_F_NAME` varchar(40) CHARACTER SET utf8 NOT NULL,
  `EMP_CURR_ADDRESS` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `EMP_PAR_ADDRESS` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `CNIC_NO` varchar(16) CHARACTER SET utf8 NOT NULL,
  `APPOINTMENT_DATE` date NOT NULL,
  `GENDER` varchar(10) CHARACTER SET utf8 NOT NULL,
  `COUNTRY_ID` int(11) DEFAULT NULL,
  `PROV_ID` int(11) DEFAULT NULL,
  `DIV_ID` int(11) DEFAULT NULL,
  `DIS_ID` int(11) DEFAULT NULL,
  `BATCH_NO` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ENTRY_TO_GOV` date DEFAULT NULL,
  `PIC` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `PHONE` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `MOBILE_SMS` varchar(40) CHARACTER SET utf8 NOT NULL,
  `MOBILE` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `EMAIL` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `PERSONAL_FILE_NO` int(11) DEFAULT NULL,
  `MACHINE_ID` int(10) DEFAULT NULL,
  `MACHINE_NO` int(2) DEFAULT NULL,
  `REMARKS` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `BARCODE` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `E_USER_ID` int(11) DEFAULT NULL,
  `E_DATE_TIME` datetime DEFAULT NULL,
  `U_USER_ID` int(11) DEFAULT NULL,
  `U_DATE_TIME` datetime DEFAULT NULL,
  `FLAG` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_profile`
--

CREATE TABLE `employee_profile` (
  `EMP_ID` int(11) NOT NULL,
  `EMP_NAME` varchar(300) NOT NULL,
  `EMP_ADDRESS` varchar(300) NOT NULL,
  `EMP_PHONE` varchar(300) NOT NULL,
  `EMP_CELL` varchar(300) NOT NULL,
  `EMP_EMAIL` varchar(300) NOT NULL,
  `EMP_PIC` varchar(300) NOT NULL,
  `EMP_GENDER` varchar(11) NOT NULL,
  `EMP_DATE` date NOT NULL,
  `CREATED_DATE` date DEFAULT NULL,
  `CREATED_USERID` int(11) DEFAULT NULL,
  `UPDATED_DATE` date DEFAULT NULL,
  `UPDATED_USERID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` varchar(13) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `color` varchar(15) DEFAULT NULL,
  `flag` int(1) DEFAULT NULL,
  `purchase_rate` float DEFAULT NULL,
  `article_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `purchase_no` int(11) NOT NULL,
  `item_id` varchar(13) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `expire_date` date NOT NULL,
  `purchase_qty` int(11) DEFAULT NULL,
  `purchase_amount` float(11,2) DEFAULT '0.00',
  `purchase_rate` float(11,3) DEFAULT '0.000',
  `sales_rate` float(11,2) NOT NULL DEFAULT '0.00',
  `balance` float(11,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_company`
--

CREATE TABLE `purchase_company` (
  `purchase_no` int(11) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `purchase_discount` float(11,2) DEFAULT '0.00',
  `purchase_amount_total` float(11,2) DEFAULT '0.00',
  `purchase_status` int(1) DEFAULT '0',
  `payment_mode` varchar(1) DEFAULT NULL,
  `balance` float(11,2) DEFAULT '0.00',
  `grand_total` float(11,2) DEFAULT '0.00',
  `due_amount` float(11,2) DEFAULT NULL,
  `purchase_user_id` int(11) DEFAULT NULL,
  `pur_no` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

CREATE TABLE `purchase_return` (
  `return_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `purchase_no` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `item_id` varchar(13) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `purchase_qty` int(11) DEFAULT NULL,
  `return_qty` int(11) NOT NULL,
  `purchase_amount` float(11,2) DEFAULT NULL,
  `purchase_rate` float(11,3) DEFAULT NULL,
  `sales_rate` float(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `route_charges`
--

CREATE TABLE `route_charges` (
  `charge_id` int(11) NOT NULL,
  `source` varchar(100) DEFAULT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `amount` float(11,2) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_no` int(11) NOT NULL,
  `sales_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `sales_discount` int(11) NOT NULL,
  `sales_amount_total` float(11,2) DEFAULT NULL,
  `paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `sales_status` varchar(1) DEFAULT NULL,
  `payment_mode` varchar(1) DEFAULT NULL,
  `grand_total` float(11,2) DEFAULT NULL,
  `invoice_no` int(11) DEFAULT NULL,
  `payment` varchar(10) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `vat` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_detail`
--

CREATE TABLE `sales_detail` (
  `sales_id` int(11) NOT NULL,
  `sales_no` int(11) DEFAULT NULL,
  `item_id` varchar(13) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sales_qty` int(11) DEFAULT NULL,
  `sales_discount` float(11,2) DEFAULT NULL,
  `sales_rate` int(11) DEFAULT NULL,
  `sales_amount` float(11,2) DEFAULT NULL,
  `sales_status` varchar(1) DEFAULT NULL,
  `payment_mode` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE `sales_return` (
  `return_id` int(11) NOT NULL,
  `sales_no` int(11) DEFAULT NULL,
  `sales_id` int(11) NOT NULL,
  `sales_date` date NOT NULL,
  `return_date` date NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sales_qty` int(11) DEFAULT NULL,
  `return_qty` int(11) DEFAULT NULL,
  `sales_rate` float(11,2) DEFAULT NULL,
  `sales_amount` float(11,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `value` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_no` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `item_id` varchar(13) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `stock_qty` int(11) DEFAULT NULL,
  `purchase_rate` int(11) DEFAULT NULL,
  `stock_rate` float(11,2) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `stock_transfer_id` int(11) NOT NULL,
  `transfer_order_no` varchar(100) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `source_warehouse_id` int(11) DEFAULT NULL,
  `destination_warehouse_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `transfer_status` varchar(1) DEFAULT NULL,
  `invoice_no` int(11) DEFAULT NULL,
  `reason` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_details`
--

CREATE TABLE `stock_transfer_details` (
  `stock_transfer_detail_id` int(11) NOT NULL,
  `stock_transfer_id` int(11) DEFAULT NULL,
  `item_id` varchar(13) DEFAULT NULL,
  `transfer_qty` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usr_group`
--

CREATE TABLE `usr_group` (
  `GROUP_ID` int(11) NOT NULL,
  `GROUP_NAME` varchar(100) NOT NULL,
  `CREATED_DATE` date DEFAULT NULL,
  `CREATED_USERID` int(11) DEFAULT NULL,
  `UPDATED_DATE` date DEFAULT NULL,
  `UPDATED_USERID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usr_menu`
--

CREATE TABLE `usr_menu` (
  `MENU_ID` int(11) NOT NULL,
  `MENU_TEXT` varchar(100) DEFAULT NULL,
  `MENU_URL` varchar(500) DEFAULT NULL,
  `PARENT_ID` int(11) DEFAULT NULL,
  `SORT_ORDER` int(11) DEFAULT NULL,
  `SHOW_IN_MENU` int(11) DEFAULT NULL,
  `IS_ADMIN` varchar(1) DEFAULT NULL,
  `CREATED_DATE` date DEFAULT NULL,
  `CREATED_USERID` int(11) DEFAULT NULL,
  `UPDATED_DATE` date DEFAULT NULL,
  `UPDATED_USERID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usr_permission`
--

CREATE TABLE `usr_permission` (
  `PER_ID` int(11) NOT NULL,
  `GROUP_ID` int(11) NOT NULL,
  `MENU_ID` int(11) NOT NULL,
  `PER_SELECT` varchar(1) NOT NULL,
  `PER_INSERT` varchar(1) NOT NULL,
  `PER_UPDATE` varchar(1) NOT NULL,
  `PER_DELETE` varchar(1) NOT NULL,
  `CREATED_DATE` date DEFAULT NULL,
  `CREATED_USERID` int(11) DEFAULT NULL,
  `UPDATED_DATE` date DEFAULT NULL,
  `UPDATED_USERID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usr_user`
--

CREATE TABLE `usr_user` (
  `USER_ID` int(11) NOT NULL,
  `USER_NAME` varchar(100) NOT NULL,
  `U_PASSWORD` varchar(500) NOT NULL,
  `EMP_NO` varchar(20) DEFAULT NULL,
  `logged_in` int(1) DEFAULT NULL,
  `IS_ACTIVE` varchar(1) NOT NULL,
  `GROUP_ID` int(11) NOT NULL,
  `SUP_ADMIN` varchar(1) DEFAULT NULL,
  `CREATED_DATE` date DEFAULT NULL,
  `CREATED_USERID` int(11) DEFAULT NULL,
  `UPDATED_DATE` date DEFAULT NULL,
  `UPDATED_USERID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(100) DEFAULT NULL,
  `fax_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `vendor_address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `warehouse_id` int(11) NOT NULL,
  `warehouse_name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(100) DEFAULT NULL,
  `fax_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `trn` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`business_settings_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `coa`
--
ALTER TABLE `coa`
  ADD PRIMARY KEY (`MAIN_CODE`,`SUB_CODE`,`TR_HEAD`);

--
-- Indexes for table `coa_trans`
--
ALTER TABLE `coa_trans`
  ADD PRIMARY KEY (`VNO`,`TRDATE`,`MAIN_CODE`,`SUB_CODE`,`TR_HEAD`),
  ADD KEY `FK_coa_trans_coa_id` (`MAIN_CODE`,`SUB_CODE`,`TR_HEAD`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `company_information`
--
ALTER TABLE `company_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_settings`
--
ALTER TABLE `currency_settings`
  ADD PRIMARY KEY (`currency_settings_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_profile`
--
ALTER TABLE `employee_profile`
  ADD PRIMARY KEY (`EMP_ID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_company`
--
ALTER TABLE `purchase_company`
  ADD PRIMARY KEY (`purchase_no`);

--
-- Indexes for table `purchase_return`
--
ALTER TABLE `purchase_return`
  ADD PRIMARY KEY (`return_id`);

--
-- Indexes for table `route_charges`
--
ALTER TABLE `route_charges`
  ADD PRIMARY KEY (`charge_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_no`);

--
-- Indexes for table `sales_detail`
--
ALTER TABLE `sales_detail`
  ADD KEY `sales_id` (`sales_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_no`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`stock_transfer_id`);

--
-- Indexes for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  ADD KEY `sales_id` (`stock_transfer_detail_id`);

--
-- Indexes for table `usr_group`
--
ALTER TABLE `usr_group`
  ADD PRIMARY KEY (`GROUP_ID`),
  ADD UNIQUE KEY `UK_GROUP_NAME` (`GROUP_NAME`);

--
-- Indexes for table `usr_menu`
--
ALTER TABLE `usr_menu`
  ADD PRIMARY KEY (`MENU_ID`),
  ADD KEY `FK_usr_menu_usr_menu_menu_id` (`PARENT_ID`);

--
-- Indexes for table `usr_permission`
--
ALTER TABLE `usr_permission`
  ADD PRIMARY KEY (`PER_ID`),
  ADD KEY `FK_usr_permission_usr_group_group_id` (`GROUP_ID`),
  ADD KEY `FK_usr_permission_usr_menu_menu_id` (`MENU_ID`);

--
-- Indexes for table `usr_user`
--
ALTER TABLE `usr_user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `UK_USER_NAME` (`USER_NAME`),
  ADD KEY `FK_usr_user_hrm_employees_emp_no` (`EMP_NO`),
  ADD KEY `FK_usr_user_usr_group_group_id` (`GROUP_ID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `business_settings_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_information`
--
ALTER TABLE `company_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currency_settings`
--
ALTER TABLE `currency_settings`
  MODIFY `currency_settings_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_profile`
--
ALTER TABLE `employee_profile`
  MODIFY `EMP_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `route_charges`
--
ALTER TABLE `route_charges`
  MODIFY `charge_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_detail`
--
ALTER TABLE `sales_detail`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `stock_transfer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  MODIFY `stock_transfer_detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT;