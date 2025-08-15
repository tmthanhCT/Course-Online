-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2025 at 09:31 PM
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
-- Database: `course_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(5, 'Business'),
(11, 'data'),
(6, 'Data Science'),
(3, 'Design'),
(9, 'Finance'),
(10, 'Health & Fitness'),
(4, 'Marketing'),
(7, 'Mobile Development'),
(8, 'Photography'),
(2, 'Programming'),
(1, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `duration` varchar(50) DEFAULT '0h',
  `url_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `instructor_id`, `title`, `description`, `price`, `category_id`, `created_at`, `duration`, `url_id`) VALUES
(1, 1, 'HTML & CSS for Beginners', 'Learn how to build responsive websites using HTML and CSS from scratch.', 50.00, 1, '2025-07-01 02:00:00', '28h', NULL),
(2, 2, 'Python Programming Masterclass', 'Master Python fundamentals and advanced features including OOP and file handling.', 89.00, 2, '2025-07-02 03:00:00', '35h', NULL),
(3, 2, 'Digital Marketing Essentials', 'Understand SEO, social media marketing, and Google Ads strategies.', 39.00, 4, '2025-07-03 04:15:00', '48h', NULL),
(4, 1, 'JavaScript Deep Dive', 'Explore advanced JavaScript concepts including async programming and DOM manipulation.', 56.00, 1, '2025-07-04 06:45:00', '68', NULL),
(5, 4, 'UI/UX Design Fundamentals', 'Learn the principles of user-centered design and how to prototype in Figma.', 35.00, 3, '2025-07-05 08:30:00', '40', NULL),
(13, 4, 'HTML & CSS for Beginners', 'Learn how to build responsive websites using HTML and CSS from scratch.', 60.00, 1, '2025-08-11 15:36:47', '30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_details`
--

CREATE TABLE `course_details` (
  `detail_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `duration_hours` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `lession_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_details`
--

INSERT INTO `course_details` (`detail_id`, `course_id`, `instructor_id`, `description`, `duration_hours`, `price`, `lession_id`, `is_active`) VALUES
(6, 1, 2, 'Basic Python course for beginners', 20, 49.99, 1, 1),
(7, 2, 1, 'Web design course with HTML, CSS, and JavaScript', 25, 59.99, 2, 1),
(8, 3, 1, 'Advanced SQL course for data analysis', 18, 45.00, 3, 1),
(9, 4, 4, 'Introduction to Artificial Intelligence and real-world applications', 30, 65.00, 4, 1),
(10, 5, 2, 'Programming logic and basic algorithms', 15, 39.00, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `enrolments`
--

CREATE TABLE `enrolments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('enrolled','completed','cancelled') DEFAULT 'enrolled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `avt_img` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `expertise` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `name`, `user_id`, `avt_img`, `bio`, `expertise`, `created_at`) VALUES
(1, 'John doeeeee', 2, 'file:///C:/xampp/htdocs/StudyHub/images/teacher-4.jpg', 'Web developer with 8 years of experience in front-end technologies.', 'HTML, CSS, JavaScript', '2025-06-20 02:00:00'),
(2, 'Emily Smith', 3, NULL, 'Python programmer and data analyst, passionate about teaching coding to beginners.', 'Python, Data Analysis', '2025-06-21 03:15:00'),
(4, 'Sarah Johnson', 5, NULL, 'UX/UI designer specialized in mobile-first design and Figma prototyping.', 'UI/UX Design, Figma', '2025-06-23 06:00:00'),
(5, 'Andy', 3, '', 'Web developer with 8 years of experience in front-end technologies.', 'Python, Data Analysis', '2025-08-01 01:03:49'),
(6, 'Andy', 3, '', 'Web developer with 8 years of experience in front-end technologies.', 'Python, Data Analysis', '2025-08-01 01:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `duration` varchar(50) DEFAULT '0m',
  `url_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `content`, `created_at`, `duration`, `url_id`) VALUES
(1, 1, 'Introduction to HTML & CSS', 'Learn the basic structure of a website using HTML and CSS.', '2025-07-01 02:00:00', '90m', NULL),
(2, 2, 'Variables and Data Types in Python', 'Understand variables, numbers, strings, and logic in Python.', '2025-07-02 03:30:00', '0m', NULL),
(3, 3, 'Basics of SEO', 'Learn how to optimize content for search engines.', '2025-07-03 04:00:00', '0m', NULL),
(4, 4, 'Asynchronous JavaScript', 'Explore async/await and Promises in modern JavaScript.', '2025-07-04 06:15:00', '0m', NULL),
(5, 5, 'Wireframing and Prototyping with Figma', 'Design user interfaces and experiences using Figma.', '2025-07-05 07:45:00', '0m', NULL),
(6, 1, 'HEHE', 'Learn the basic structure of a website using HTML and CSS.	', '2025-08-05 05:39:08', '20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Phone` varchar(255) DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `Birth_Day` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `Phone`, `Gender`, `Birth_Day`) VALUES
(1, 'Trần Minh Thành', 't@t.co', '$2y$10$0Hosz.90TkTG8e/wUwqt/uNoRS2kCoAlr0KC/kikn5r93slqVLBli', 'admin', '2025-07-29 17:41:54', '0129321837', 'Other', '2004-02-09'),
(2, '', 'thanh@t.co', '$2y$10$60E1rmuxy.zEBAPSE1p5z.4MBxRRSF8R46HOQPHmXNX8dP.RGMhIG', 'student', '2025-07-29 17:53:58', NULL, NULL, NULL),
(3, 'MInh Thanh', 'tt@t.co', '$2y$10$hxwhDRgVCqIW.Uf0NoRIf.lhgCdAbHR1HdaqZUXBlC8ygctgN9DUG', 'student', '2025-07-29 18:50:51', '0129213923290', 'Female', '3221-12-23'),
(5, '', 'abc@abc.co', '$2y$10$4KValVU8OHqXNF3cLij9mOle5g9XG1tLLCronJmT7CEGuDJIo2Q7i', 'student', '2025-07-31 13:49:49', NULL, NULL, NULL),
(6, '', 'lec@1.co', '$2y$10$yxfAFV4opof7VSOKXrZdZOQLW9l289rZyaQITVkRvPi7OQc7FkbWO', 'student', '2025-07-31 15:37:55', NULL, NULL, NULL),
(7, '', 'test@ga.co', '$2y$10$/kv2MWMPLBopnrsCklxMvelT7TgOvKZs.u/VcslVKg8S79V21i1zu', 'student', '2025-07-31 15:38:54', NULL, NULL, NULL),
(8, '', 'demo@demo.com', '$2y$10$3WTMKlIelg1Fu/sTrwZle.l2i852IHJNsI9C9fD2I64YebMALp9wy', 'student', '2025-07-31 15:40:51', NULL, NULL, NULL),
(9, 'Trần Minh Thành', 'thanh@user.com', '$2y$10$T568t6IJqcHIGFy5pJbRFeFhvdk3DZUerBZmnjwjjxwZig8gE//oO', 'student', '2025-08-11 15:27:42', '0123924224', 'Male', '2004-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_email`, `course_id`, `enrolled_at`) VALUES
(1, 'tt@t.co', 1, '2025-07-30 15:55:40'),
(4, 'abc@abc.co', 5, '2025-07-31 13:50:27'),
(5, 'demo@demo.com', 2, '2025-07-31 15:43:29'),
(6, 'demo@demo.com', 3, '2025-07-31 16:27:10'),
(7, 't@t.co', 5, '2025-07-31 16:54:43'),
(8, 'tt@t.co', 4, '2025-08-05 06:14:51'),
(9, 'thanh@user.com', 5, '2025-08-11 15:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `videos_images_url`
--

CREATE TABLE `videos_images_url` (
  `id` int(11) NOT NULL,
  `id_lession` int(11) DEFAULT NULL,
  `id_course` int(11) DEFAULT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos_images_url`
--

INSERT INTO `videos_images_url` (`id`, `id_lession`, `id_course`, `url`) VALUES
(1, 1, 2, 'https://www.youtube.com/watch?v=d_0rbHNImP0'),
(8, 3, 4, 'uploads/media_6891a5f8a46320.85841260.jpg'),
(9, 1, 1, 'uploads/media_6891a60fb6a5f0.79844039.mp4'),
(10, 2, 2, 'https://www.youtube.com/watch?v=SXzUJfqPEaA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `fk_courses_category` (`category_id`),
  ADD KEY `url_id` (`url_id`);

--
-- Indexes for table `course_details`
--
ALTER TABLE `course_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `lession_id` (`lession_id`);

--
-- Indexes for table `enrolments`
--
ALTER TABLE `enrolments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `url_id` (`url_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `Phone` (`Phone`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_course` (`user_email`,`course_id`);

--
-- Indexes for table `videos_images_url`
--
ALTER TABLE `videos_images_url`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lession` (`id_lession`),
  ADD KEY `id_course` (`id_course`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `course_details`
--
ALTER TABLE `course_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `enrolments`
--
ALTER TABLE `enrolments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `videos_images_url`
--
ALTER TABLE `videos_images_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`url_id`) REFERENCES `videos_images_url` (`id`),
  ADD CONSTRAINT `fk_courses_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_details`
--
ALTER TABLE `course_details`
  ADD CONSTRAINT `course_details_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_details_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`),
  ADD CONSTRAINT `course_details_ibfk_3` FOREIGN KEY (`lession_id`) REFERENCES `lessons` (`id`);

--
-- Constraints for table `enrolments`
--
ALTER TABLE `enrolments`
  ADD CONSTRAINT `enrolments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrolments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lessons_ibfk_2` FOREIGN KEY (`url_id`) REFERENCES `videos_images_url` (`id`);

--
-- Constraints for table `videos_images_url`
--
ALTER TABLE `videos_images_url`
  ADD CONSTRAINT `videos_images_url_ibfk_1` FOREIGN KEY (`id_lession`) REFERENCES `lessons` (`id`),
  ADD CONSTRAINT `videos_images_url_ibfk_2` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
