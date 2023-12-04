-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 11:47 AM
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
-- Database: `pcc-cancer-repo-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `hospital_general_information`
--

CREATE TABLE `hospital_general_information` (
  `hospital_id` int(100) NOT NULL,
  `repo_admin_id` int(11) DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `hospital_level` varchar(255) DEFAULT NULL,
  `hospital_region` varchar(255) DEFAULT NULL,
  `hospital_province` varchar(255) DEFAULT NULL,
  `type_of_institution` varchar(255) DEFAULT NULL,
  `hospital_city` varchar(255) DEFAULT NULL,
  `hospital_barangay` varchar(255) DEFAULT NULL,
  `hospital_street` varchar(255) DEFAULT NULL,
  `hospital_equipments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_general_information`
--

INSERT INTO `hospital_general_information` (`hospital_id`, `repo_admin_id`, `hospital_name`, `hospital_level`, `hospital_region`, `hospital_province`, `type_of_institution`, `hospital_city`, `hospital_barangay`, `hospital_street`, `hospital_equipments`) VALUES
(24, 1, 'CITY GLOBAL ORGTIGAS', 'Level 2 General Hospital', '05', '0541', 'Private', '054117', '054117018', '288 Masigla Street', 'X-ray'),
(25, 1, 'Quezon City General Hospital', 'Level 3 General Hospital', '13', '1374', 'Private', '137404', '137404139', '112 Matapang street', 'Chemotherapy chairs.');

-- --------------------------------------------------------

--
-- Table structure for table `patient_cancer_diagnosis`
--

CREATE TABLE `patient_cancer_diagnosis` (
  `patient_id` int(10) NOT NULL,
  `date_of_diagnosis` date DEFAULT NULL,
  `valid_diagnosis_non_microscopic` varchar(50) DEFAULT NULL,
  `valid_diagnosis_microscopic` varchar(50) DEFAULT NULL,
  `multiple_primaries` varchar(50) DEFAULT NULL,
  `primary_site` varchar(100) DEFAULT NULL,
  `laterality` varchar(50) DEFAULT NULL,
  `histology` varchar(50) DEFAULT NULL,
  `tumor_size` varchar(50) DEFAULT NULL,
  `nodes` varchar(50) DEFAULT NULL,
  `metastasis` varchar(50) DEFAULT NULL,
  `staging_in_situ` varchar(10) DEFAULT NULL,
  `direct_extension` varchar(10) DEFAULT NULL,
  `regional_lymph_node` varchar(10) DEFAULT NULL,
  `distant_metastasis` varchar(50) DEFAULT NULL,
  `final_diagnosis` varchar(100) DEFAULT NULL,
  `final_diagnosis_icd_10` varchar(100) DEFAULT NULL,
  `treatment` varchar(100) DEFAULT NULL,
  `patient_status` varchar(50) DEFAULT NULL,
  `cause_of_death` varchar(100) DEFAULT NULL,
  `place_of_death` varchar(100) DEFAULT NULL,
  `date_of_death` date DEFAULT NULL,
  `disposition` varchar(50) DEFAULT NULL,
  `transferred_hospital` varchar(100) DEFAULT NULL,
  `reason_for_referral` varchar(50) DEFAULT NULL,
  `repository_user_lname` varchar(50) DEFAULT NULL,
  `repository_user_fname` varchar(50) DEFAULT NULL,
  `repository_user_mname` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `date_of_completion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_general_info`
--

CREATE TABLE `patient_general_info` (
  `patient_id` int(10) NOT NULL,
  `hospital_id` int(10) DEFAULT NULL,
  `repo_user_id` int(10) DEFAULT NULL,
  `type_of_patient` varchar(50) DEFAULT NULL,
  `patient_lname_initial` varchar(5) DEFAULT NULL,
  `patient_fname_initial` varchar(5) DEFAULT NULL,
  `sex` varchar(5) DEFAULT NULL,
  `civil_status` varchar(10) DEFAULT NULL,
  `address_region` varchar(50) DEFAULT NULL,
  `address_province` varchar(50) DEFAULT NULL,
  `address_city_municipality` varchar(50) DEFAULT NULL,
  `address_barangay` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `place_of_birth` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `educational_attainment` varchar(50) DEFAULT NULL,
  `race` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_history`
--

CREATE TABLE `patient_history` (
  `patient_id` int(10) NOT NULL,
  `smoking` varchar(10) DEFAULT NULL,
  `esti_no_of_years` varchar(50) DEFAULT NULL,
  `physical_activity` varchar(50) DEFAULT NULL,
  `diet` varchar(50) DEFAULT NULL,
  `drinking_alcohol` varchar(10) DEFAULT NULL,
  `chemical_exposure` varchar(50) DEFAULT NULL,
  `no_of_sexual_partners` varchar(50) DEFAULT NULL,
  `early_age_sexual_intercourse` varchar(10) DEFAULT NULL,
  `use_of_contraceptive` varchar(10) DEFAULT NULL,
  `family_history` varchar(50) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `bmi` varchar(20) DEFAULT NULL,
  `classification_bmi` varchar(20) DEFAULT NULL,
  `waist_circumference` varchar(20) DEFAULT NULL,
  `classification_wc` varchar(20) DEFAULT NULL,
  `human_papillomavirus` varchar(10) DEFAULT NULL,
  `helicobacter_pylori` varchar(10) DEFAULT NULL,
  `hepatitis_b_virus` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repo_admin`
--

CREATE TABLE `repo_admin` (
  `repo_admin_id` int(50) NOT NULL,
  `sa_id` int(11) DEFAULT NULL,
  `attendance_id` int(11) DEFAULT NULL,
  `calendar_id` int(11) DEFAULT NULL,
  `admin_fname` varchar(50) DEFAULT NULL,
  `admin_lname` varchar(50) DEFAULT NULL,
  `admin_username` varchar(50) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repo_admin`
--

INSERT INTO `repo_admin` (`repo_admin_id`, `sa_id`, `attendance_id`, `calendar_id`, `admin_fname`, `admin_lname`, `admin_username`, `admin_password`, `created_at`) VALUES
(1, 1, 1, 1, 'Admin', 'User', 'admin_username', '$2y$10$1Ac4Qz7VOtmvme.RnAzZO.9Dr.B3pPENUIfTKhwR3mwIRwm4J1/bG', '2023-11-25');

-- --------------------------------------------------------

--
-- Table structure for table `repo_user`
--

CREATE TABLE `repo_user` (
  `repo_user_id` int(10) NOT NULL,
  `repo_admin_id` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `user_fname` varchar(50) DEFAULT NULL,
  `user_mname` varchar(50) DEFAULT NULL,
  `user_lname` varchar(50) DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repo_user`
--

INSERT INTO `repo_user` (`repo_user_id`, `repo_admin_id`, `hospital_id`, `user_fname`, `user_mname`, `user_lname`, `user_name`, `password`, `region`, `address`) VALUES
(1, NULL, NULL, 'John', 'Doe', 'Smith', 'user_name', '$2y$10$2OYQiftwBGLFTNXz3c8ccuoP5c.O2bEDp87YZpH5E22Lj4LEItqYC', 'Your Region', 'Your Address');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hospital_general_information`
--
ALTER TABLE `hospital_general_information`
  ADD PRIMARY KEY (`hospital_id`),
  ADD KEY `repo_admin_id` (`repo_admin_id`);

--
-- Indexes for table `patient_cancer_diagnosis`
--
ALTER TABLE `patient_cancer_diagnosis`
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patient_general_info`
--
ALTER TABLE `patient_general_info`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `repo_user_id` (`repo_user_id`);

--
-- Indexes for table `patient_history`
--
ALTER TABLE `patient_history`
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `repo_admin`
--
ALTER TABLE `repo_admin`
  ADD PRIMARY KEY (`repo_admin_id`);

--
-- Indexes for table `repo_user`
--
ALTER TABLE `repo_user`
  ADD PRIMARY KEY (`repo_user_id`),
  ADD KEY `repo_admin_id` (`repo_admin_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hospital_general_information`
--
ALTER TABLE `hospital_general_information`
  MODIFY `hospital_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `patient_general_info`
--
ALTER TABLE `patient_general_info`
  MODIFY `patient_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repo_admin`
--
ALTER TABLE `repo_admin`
  MODIFY `repo_admin_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repo_user`
--
ALTER TABLE `repo_user`
  MODIFY `repo_user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hospital_general_information`
--
ALTER TABLE `hospital_general_information`
  ADD CONSTRAINT `hospital_general_information_ibfk_1` FOREIGN KEY (`repo_admin_id`) REFERENCES `repo_admin` (`repo_admin_id`);

--
-- Constraints for table `patient_cancer_diagnosis`
--
ALTER TABLE `patient_cancer_diagnosis`
  ADD CONSTRAINT `patient_cancer_diagnosis_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_general_info` (`patient_id`);

--
-- Constraints for table `patient_general_info`
--
ALTER TABLE `patient_general_info`
  ADD CONSTRAINT `patient_general_info_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital_general_information` (`hospital_id`),
  ADD CONSTRAINT `patient_general_info_ibfk_2` FOREIGN KEY (`repo_user_id`) REFERENCES `repo_user` (`repo_user_id`);

--
-- Constraints for table `patient_history`
--
ALTER TABLE `patient_history`
  ADD CONSTRAINT `patient_history_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_general_info` (`patient_id`);

--
-- Constraints for table `repo_user`
--
ALTER TABLE `repo_user`
  ADD CONSTRAINT `repo_user_ibfk_1` FOREIGN KEY (`repo_admin_id`) REFERENCES `repo_admin` (`repo_admin_id`),
  ADD CONSTRAINT `repo_user_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospital_general_information` (`hospital_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
