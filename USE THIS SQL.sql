-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 03:53 AM
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
-- Database: `kanban`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `file_path` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` int(10) UNSIGNED NOT NULL,
  `boardId` int(11) NOT NULL,
  `totalTaskFilter` int(11) NOT NULL,
  `tasksDoneFilter` int(11) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bugtrack`
--

CREATE TABLE `bugtrack` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `severity` varchar(191) NOT NULL DEFAULT 'medium',
  `status` varchar(191) NOT NULL DEFAULT 'open',
  `flow` varchar(191) DEFAULT NULL,
  `expected_results` text DEFAULT NULL,
  `actual_results` text DEFAULT NULL,
  `attachment` varchar(191) DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `reported_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `burndownchart`
--

CREATE TABLE `burndownchart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `story_points` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `due_date` date DEFAULT NULL,
  `status` enum('Not Started','In Progress','Completed') NOT NULL DEFAULT 'Not Started',
  `user_name` varchar(191) NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `proj_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id`, `title`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(2, 'tasksevent', '2024-06-20 13:54:00', '2024-06-20 13:54:00', '2024-06-18 21:54:47', '2024-06-18 21:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `charts`
--

CREATE TABLE `charts` (
  `id` int(10) UNSIGNED NOT NULL,
  `boardId` int(11) NOT NULL,
  `sprintname` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `storyPointsTotal` double(5,1) NOT NULL,
  `tasksTotal` double(5,1) NOT NULL,
  `tasksDone` double(5,1) NOT NULL,
  `storyPointsDone` double(5,1) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `sprintDay` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coding_standards`
--

CREATE TABLE `coding_standards` (
  `codestand_id` bigint(20) UNSIGNED NOT NULL,
  `codestand_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `forum_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'comment 1', '2024-06-18 22:12:53', '2024-06-18 22:12:53');

-- --------------------------------------------------------

--
-- Table structure for table `defect_features`
--

CREATE TABLE `defect_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `category` varchar(191) NOT NULL,
  `content` longtext NOT NULL,
  `image_urls` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`id`, `title`, `category`, `content`, `image_urls`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'forumnew', 'Category 2', 'forumcontent', NULL, 1, 4, '2024-06-13 07:39:43', '2024-06-13 07:39:43'),
(2, 'forum1', 'Category 1', 'content', NULL, 1, 4, '2024-06-13 07:40:03', '2024-06-13 07:40:03'),
(3, 'forum2', 'Category 3', 'content23', 'https://buffer.com/library/content/images/size/w1200/2023/10/free-images.jpg', 1, 4, '2024-06-13 07:42:13', '2024-06-18 22:04:47'),
(4, 'forumtitle', 'Category 2', 'forum is interesting', 'https://buffer.com/library/content/images/size/w1200/2023/10/free-images.jpg', 1, 4, '2024-06-18 22:12:16', '2024-06-18 22:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `forum_favorites`
--

CREATE TABLE `forum_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mappings`
--

CREATE TABLE `mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ustory_id` int(11) NOT NULL,
  `type_NFR` int(11) NOT NULL,
  `id_NFR` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2016_12_06_110937_create_charts_table', 1),
(8, '2017_03_30_173152_create_boards_table', 1),
(9, '2019_03_16_084930_create_roles_table', 1),
(10, '2019_03_27_154105_create_projects_table', 1),
(11, '2019_05_05_171853_create_priorities_table', 1),
(12, '2019_05_05_174636_create_security_features_table', 1),
(13, '2019_05_07_143235_create_performance_features_table', 1),
(14, '2019_05_09_031717_create_product_features_table', 1),
(15, '2019_05_26_195719_create_defect_features_table', 1),
(16, '2019_06_29_163059_create_mappings_table', 1),
(17, '2019_08_19_000000_create_failed_jobs_table', 1),
(18, '2020_05_27_040214_create_tasks_table', 1),
(19, '2020_05_27_042541_create_statuses_table', 1),
(20, '2020_08_09_024542_create_teams_table', 1),
(21, '2020_08_18_123517_create_users_table', 1),
(27, '2020_08_20_012325_create_attachments_table', 2),
(28, '2020_08_23_090144_create_team_mappings_table', 2),
(29, '2020_09_12_015732_create_sprint_table', 2),
(30, '2020_09_14_083251_create_user_stories_table', 2),
(31, '2020_09_17_133209_create_coding_standards_table', 2),
(32, '2023_12_10_144643_tambahan', 3),
(33, '2023_09_08_031714_create_comments_table', 4),
(34, '2023_09_12_004537_create_forums_table', 4),
(35, '2023_11_26_085500_create_burndownchart_table', 4),
(36, '2023_12_10_143945_create_forum_favorites_table', 4),
(37, '2023_12_13_094806_remove_hours_from_tasks_table', 4),
(38, '2023_12_13_100711_add_ideal_hours_per_day_to_sprint_table', 4),
(39, '2023_12_16_073958_add_actual_hours_per_day_to_sprint', 4),
(40, '2024_01_01_070140_add_hours_spent_to_sprint_table', 5),
(41, '2023_12_12_143947_create_permission_table', 6),
(42, '2024_01_08_144450_add_proj_name_to_teams_table', 7),
(43, '2024_01_09_053634_add_user_name_to_user_stories', 7),
(44, '2024_01_09_060749_drop_user_name_from_tasks', 7),
(45, '2024_01_09_060837_add_user_names_to_tasks', 7),
(46, '2024_01_09_063232_remove_user_name_column_from_user_stories_table', 8),
(47, '2024_01_09_065208_add_user_names_to_user_stories', 8),
(48, '2024_01_10_063354_add_team_names_to_teams_table', 9),
(49, '2024_01_11_143732_add_completion_date_to_tasks_table', 10),
(50, '2024_01_24_090533_add_new_task_update_to_tasks_table', 11),
(51, '2024_04_15_142912_create_calendar_table', 12),
(52, '2024_04_21_171637_create_bugtrack_table', 12),
(53, '2024_06_13_122955_add_project_id_to_bugtrack_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance_features`
--

CREATE TABLE `performance_features` (
  `perfeature_id` bigint(20) UNSIGNED NOT NULL,
  `perfeature_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `performance_features`
--

INSERT INTO `performance_features` (`perfeature_id`, `perfeature_name`, `created_at`, `updated_at`) VALUES
(1, 'TestAddPerf', '2024-01-03 20:28:35', '2024-01-03 20:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `prio_id` bigint(20) UNSIGNED NOT NULL,
  `prio_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_features`
--

CREATE TABLE `product_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profeature_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_name` varchar(191) NOT NULL,
  `proj_name` varchar(191) NOT NULL,
  `proj_desc` varchar(191) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `team_name`, `proj_name`, `proj_desc`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(2, 'Testers', 'Lets', '123', '2023-01-08', '2024-04-05', NULL, '2023-12-12 08:17:08'),
(3, 'a', 'Project Demo', 'Project Demo Testing Creation Kanban', '2024-01-03', '2024-08-29', '2024-01-02 17:30:51', '2024-01-02 17:30:51'),
(4, 'Testers', 'adasdas', 'adasdas', '2024-01-08', '2024-08-20', '2024-01-08 07:13:29', '2024-01-08 07:13:29'),
(6, 'Testers', 'TestProj', 'test', '2024-01-16', '2024-12-19', '2024-01-16 03:50:22', '2024-01-16 03:50:22'),
(7, 'Testers', 'newProjDebug', 'adasdas', '2024-01-16', '2024-07-17', '2024-01-16 04:20:24', '2024-01-16 04:20:24'),
(8, 'Testers', 'Test123', 'Jeevan', '2024-06-14', '2024-06-29', '2024-06-13 04:28:54', '2024-06-13 04:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'Developer', '2023-09-07 20:06:00', '2023-09-07 20:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `security_features`
--

CREATE TABLE `security_features` (
  `secfeature_id` bigint(20) UNSIGNED NOT NULL,
  `secfeature_name` varchar(191) NOT NULL,
  `secfeature_desc` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_features`
--

INSERT INTO `security_features` (`secfeature_id`, `secfeature_name`, `secfeature_desc`, `created_at`, `updated_at`) VALUES
(1, 'TestAddSec', 'Security Description Test', '2024-01-03 20:28:57', '2024-01-03 20:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `sprint`
--

CREATE TABLE `sprint` (
  `sprint_id` bigint(20) UNSIGNED NOT NULL,
  `sprint_name` varchar(191) NOT NULL,
  `sprint_desc` varchar(191) NOT NULL,
  `start_sprint` date NOT NULL,
  `end_sprint` date NOT NULL,
  `proj_name` varchar(191) NOT NULL,
  `users_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `idealHoursPerDay` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`idealHoursPerDay`)),
  `actualHoursPerDay` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`actualHoursPerDay`)),
  `hoursSpent` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hoursSpent`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sprint`
--

INSERT INTO `sprint` (`sprint_id`, `sprint_name`, `sprint_desc`, `start_sprint`, `end_sprint`, `proj_name`, `users_name`, `created_at`, `updated_at`, `idealHoursPerDay`, `actualHoursPerDay`, `hoursSpent`) VALUES
(1, 'Sprint 1', 'Sprint to create manage sprint progress', '2023-12-03', '2023-12-09', 'Lets', 'ammar-', '2023-12-12 08:17:20', '2023-12-25 01:50:05', '[168,168,140,112,84,56,28,0]', NULL, NULL),
(2, 'Sprint 2', 'SprintDesc2', '2023-05-08', '2023-12-20', 'Lets', 'ammar-', '2023-12-19 17:54:27', '2024-01-02 17:31:33', '[288,288,286.72566371681415,285.4513274336283,284.17699115044246,282.9026548672566,281.62831858407077,280.3539823008849,279.0796460176991,277.80530973451323,276.5309734513274,275.25663716814154,273.9823008849557,272.70796460176985,271.433628318584,270.15929203539815,268.8849557522123,267.61061946902646,266.3362831858406,265.06194690265477,263.7876106194689,262.5132743362831,261.23893805309723,259.9646017699114,258.69026548672554,257.4159292035397,256.14159292035384,254.867256637168,253.59292035398215,252.3185840707963,251.04424778761046,249.7699115044246,248.49557522123877,247.22123893805292,245.94690265486707,244.67256637168123,243.39823008849538,242.12389380530954,240.8495575221237,239.57522123893784,238.300884955752,237.02654867256615,235.7522123893803,234.47787610619446,233.2035398230086,231.92920353982277,230.65486725663692,229.38053097345107,228.10619469026523,226.83185840707938,225.55752212389353,224.2831858407077,223.00884955752184,221.734513274336,220.46017699115015,219.1858407079643,217.91150442477846,216.6371681415926,215.36283185840676,214.08849557522092,212.81415929203507,211.53982300884923,210.26548672566338,208.99115044247753,207.7168141592917,206.44247787610584,205.16814159292,203.89380530973415,202.6194690265483,201.34513274336246,200.0707964601766,198.79646017699076,197.52212389380492,196.24778761061907,194.97345132743322,193.69911504424738,192.42477876106153,191.15044247787569,189.87610619468984,188.601769911504,187.32743362831815,186.0530973451323,184.77876106194645,183.5044247787606,182.23008849557476,180.95575221238892,179.68141592920307,178.40707964601722,177.13274336283138,175.85840707964553,174.58407079645968,173.30973451327384,172.035398230088,170.76106194690215,169.4867256637163,168.21238938053045,166.9380530973446,165.66371681415876,164.38938053097291,163.11504424778707,161.84070796460122,160.56637168141538,159.29203539822953,158.01769911504368,156.74336283185784,155.469026548672,154.19469026548614,152.9203539823003,151.64601769911445,150.3716814159286,149.09734513274276,147.8230088495569,146.54867256637107,145.27433628318522,143.99999999999937,142.72566371681353,141.45132743362768,140.17699115044184,138.902654867256,137.62831858407014,136.3539823008843,135.07964601769845,133.8053097345126,132.53097345132676,131.2566371681409,129.98230088495507,128.70796460176922,127.43362831858337,126.15929203539753,124.88495575221168,123.61061946902583,122.33628318583999,121.06194690265414,119.7876106194683,118.51327433628245,117.2389380530966,115.96460176991076,114.69026548672491,113.41592920353906,112.14159292035322,110.86725663716737,109.59292035398153,108.31858407079568,107.04424778760983,105.76991150442399,104.49557522123814,103.2212389380523,101.94690265486645,100.6725663716806,99.39823008849476,98.12389380530891,96.84955752212306,95.57522123893722,94.30088495575137,93.02654867256553,91.75221238937968,90.47787610619383,89.20353982300799,87.92920353982214,86.6548672566363,85.38053097345045,84.1061946902646,82.83185840707876,81.55752212389291,80.28318584070706,79.00884955752122,77.73451327433537,76.46017699114952,75.18584070796368,73.91150442477783,72.63716814159199,71.36283185840614,70.08849557522029,68.81415929203445,67.5398230088486,66.26548672566275,64.99115044247691,63.71681415929107,62.44247787610523,61.16814159291939,59.89380530973355,58.61946902654771,57.34513274336187,56.070796460176034,54.796460176990195,53.522123893804356,52.247787610618516,50.97345132743268,49.69911504424684,48.424778761061,47.15044247787516,45.87610619468932,44.60176991150348,43.32743362831764,42.0530973451318,40.778761061945964,39.504424778760125,38.230088495574286,36.95575221238845,35.68141592920261,34.40707964601677,33.13274336283093,31.85840707964509,30.58407079645925,29.309734513273412,28.035398230087573,26.761061946901734,25.486725663715895,24.212389380530055,22.938053097344216,21.663716814158377,20.389380530972538,19.1150442477867,17.84070796460086,16.56637168141502,15.29203539822918,14.017699115043339,12.743362831857498,11.469026548671657,10.194690265485816,8.920353982299975,7.646017699114134,6.371681415928293,5.097345132742452,3.8230088495566115,2.5486725663707706,1.2743362831849299,0]', NULL, NULL),
(3, 'asdasd', 'Sprint to create manage sprint progress', '2023-12-03', '2023-12-17', 'Lets', '4', '2023-12-24 06:56:01', '2023-12-25 02:14:35', '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]', NULL, NULL),
(4, 'Test Sprint 3', 'Test make username include', '2023-12-03', '2023-12-26', 'Lets', 'Ammar', '2023-12-24 06:58:43', '2023-12-25 02:42:38', '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]', '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]', NULL),
(5, 'Test Sprint 4', 'Test make username not name', '2023-12-01', '2023-12-22', 'Lets', 'ammar-', '2023-12-24 06:59:50', '2023-12-25 01:50:23', '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]', NULL, NULL),
(6, 'Test for validation editing', 'Test for current date before sprint date', '2024-01-03', '2024-01-23', 'Lets', 'ammar-', '2024-01-02 01:01:30', '2024-01-16 16:53:38', '[192,192,178.28571428571428,164.57142857142856,150.85714285714283,137.1428571428571,123.4285714285714,109.7142857142857,95.99999999999999,82.28571428571428,68.57142857142857,54.857142857142854,41.14285714285714,27.428571428571423,13.71428571428571,0]', '[192,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]', '[0,192,192,192,192,192,192,192,192,192,192,192,192,192,192,192]'),
(7, 'Tasuhrfhqeryhqr', 'qW234HG', '2023-02-07', '2023-11-01', 'Lets', 'ammar-', '2024-01-08 06:54:25', '2024-01-09 03:36:12', '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]', NULL, NULL),
(8, 'test', 'Sprint to create manage sprint progress', '2024-01-09', '2024-01-31', 'Lets', 'ammar-', '2024-01-08 21:29:53', '2024-01-23 05:52:41', '[168,160.69565217391303,153.39130434782606,146.0869565217391,138.78260869565213,131.47826086956516,124.17391304347821,116.86956521739125,109.5652173913043,102.26086956521735,94.9565217391304,87.65217391304344,80.34782608695649,73.04347826086953,65.73913043478258,58.43478260869563,51.130434782608674,43.82608695652172,36.52173913043477,29.21739130434781,21.913043478260853,14.608695652173896,7.30434782608694,0]', '[168,168,168,168,24,24,24,24,0,0,168,168,168,168,168,168]', '[0,0,0,0,144,144,144,144,0,0,0,0,0,0,0,0]'),
(10, 'ss', 'ss', '2024-01-11', '2024-01-25', 'adasdas', 'ammar-', '2024-01-09 18:49:29', '2024-01-09 18:49:29', NULL, NULL, NULL),
(11, 'ddqwdqwdqwedqw', 'qdqdqw', '2024-01-16', '2024-02-13', 'TestProj', 'ammar-', '2024-01-16 03:50:41', '2024-01-16 03:53:45', '[96,92.6896551724138,89.37931034482759,86.06896551724138,82.75862068965517,79.44827586206897,76.13793103448276,72.82758620689656,69.51724137931035,66.20689655172414,62.896551724137936,59.58620689655173,56.27586206896552,52.96551724137932,49.65517241379311,46.344827586206904,43.0344827586207,39.72413793103449,36.413793103448285,33.10344827586208,29.793103448275872,26.482758620689665,23.17241379310346,19.862068965517253,16.551724137931046,13.24137931034484,9.931034482758633,6.620689655172427,3.31034482758622,1.3322676295501878e-14]', NULL, NULL),
(12, 'sprintDebug', 'adasd', '2024-01-16', '2024-02-07', 'newProjDebug', 'ammar-', '2024-01-16 04:20:47', '2024-01-29 22:54:34', '[648,619.8260869565217,591.6521739130435,563.4782608695652,535.304347826087,507.13043478260875,478.9565217391305,450.78260869565224,422.608695652174,394.43478260869574,366.2608695652175,338.08695652173924,309.913043478261,281.73913043478274,253.5652173913045,225.39130434782624,197.21739130434798,169.04347826086973,140.86956521739148,112.69565217391322,84.52173913043495,56.34782608695669,28.173913043478425,1.6342482922482304e-13]', '[648,0,24,24,24,24,24,24,24,24,24,24,24,24,24,24]', '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]'),
(13, 'final presentation', 'good', '2024-01-14', '2024-01-28', 'Lets', 'ammar-', '2024-01-16 16:42:57', '2024-01-23 06:04:43', '[72,67.2,62.400000000000006,57.60000000000001,52.80000000000001,48.000000000000014,43.20000000000002,38.40000000000002,33.60000000000002,28.800000000000022,24.00000000000002,19.20000000000002,14.40000000000002,9.60000000000002,4.800000000000019,1.9539925233402755e-14]', '[72,72,72,72,48,48,48,48,48,48,48]', '[0,0,0,0,24,24,24,24,24,24,24]'),
(14, 'wqddqqdqw', 'cwdfqwfdw', '2024-01-22', '2024-02-05', 'Lets', 'ammar-', '2024-01-29 22:52:21', '2024-01-31 01:29:19', '[240,224,208,192,176,160,144,128,112,96,80,64,48,32,16,0]', '[240,240,240,240,240,240,240,240,240,120,120]', '[0,0,0,0,0,0,0,0,0,120,120]');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT 0,
  `project_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `title`, `slug`, `order`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'To-do', 'to-do', 1, 1, NULL, NULL),
(2, 'backlog', 'backlog', 1, 2, NULL, NULL),
(4, 'doing', 'doing', 3, 2, NULL, NULL),
(9, 'test code', 'test code', 4, 2, NULL, NULL),
(11, 'done', 'done', 5, 2, NULL, NULL),
(14, 'Backlog', 'backlog', 1, 3, NULL, NULL),
(15, 'Up Next', 'up-next', 2, 3, NULL, NULL),
(16, 'In Progress', 'in-progress', 3, 3, NULL, NULL),
(17, 'Done', 'done', 4, 3, NULL, NULL),
(18, 'Backlog', 'backlog', 1, 4, NULL, NULL),
(19, 'Up Next', 'up-next', 2, 4, NULL, NULL),
(20, 'In Progress', 'in-progress', 3, 4, NULL, NULL),
(21, 'Done', 'done', 4, 4, NULL, NULL),
(22, 'Backlog', 'backlog', 1, 5, NULL, NULL),
(23, 'Up Next', 'up-next', 2, 5, NULL, NULL),
(24, 'In Progress', 'in-progress', 3, 5, NULL, NULL),
(25, 'Done', 'done', 4, 5, NULL, NULL),
(40, 'Backlog', 'backlog', 1, 6, NULL, NULL),
(41, 'Up Next', 'up-next', 2, 6, NULL, NULL),
(42, 'In Progress', 'in-progress', 3, 6, NULL, NULL),
(43, 'Done', 'done', 4, 6, NULL, NULL),
(45, 'test', 'test', 6, 6, NULL, NULL),
(46, 'Backlog', 'backlog', 1, 7, NULL, NULL),
(47, 'Up Next', 'up-next', 2, 7, NULL, NULL),
(48, 'In Progress', 'in-progress', 3, 7, NULL, NULL),
(49, 'Done', 'done', 4, 7, NULL, NULL),
(50, 'push to production', 'push-to-production', 7, 2, NULL, NULL),
(53, 'Backlog', 'backlog', 1, 8, NULL, NULL),
(54, 'Up Next', 'up-next', 2, 8, NULL, NULL),
(55, 'In Progress', 'in-progress', 3, 8, NULL, NULL),
(56, 'Done', 'done', 4, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `order` smallint(6) NOT NULL DEFAULT 0,
  `status_id` varchar(191) NOT NULL,
  `userstory_id` int(10) UNSIGNED NOT NULL,
  `sprint_id` int(10) UNSIGNED NOT NULL,
  `proj_id` int(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_names` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`user_names`)),
  `newTask_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `order`, `status_id`, `userstory_id`, `sprint_id`, `proj_id`, `start_date`, `end_date`, `completion_date`, `created_at`, `updated_at`, `user_names`, `newTask_update`) VALUES
(22, 'TestData', 'adadkasopd', 1, '50', 1, 1, 2, '2023-12-04', '2023-12-08', NULL, '2023-12-26 02:08:50', '2024-01-16 16:36:35', NULL, NULL),
(28, 'task1 uodate', 'test update from kanban', 1, '11', 4, 6, 2, '2024-01-04', '2024-01-12', '2024-01-11', '2024-01-02 17:33:53', '2024-01-11 06:40:28', NULL, NULL),
(30, 'newTaskAddUI', 'Task Description', 1, '2', 1, 1, 2, '2023-12-05', '2023-12-07', NULL, '2024-01-08 02:28:12', '2024-01-16 04:45:07', NULL, NULL),
(31, 'testTaskUpdate', 'addqwqqwerq', 1, '11', 1, 1, 2, '2023-12-04', '2023-12-08', NULL, '2024-01-09 03:35:22', '2024-03-25 20:58:28', 'null', NULL),
(40, 'testAddopakd', 'apoifj', 1, '4', 1, 1, 2, '2023-12-04', '2023-12-07', NULL, '2024-01-13 23:57:59', '2024-01-16 23:51:54', '[\"periyaa\",\"Ammar\"]', NULL),
(41, 'testAddNew', 'yaaaa', 2, '11', 3, 1, 2, '2023-12-05', '2023-12-07', NULL, '2024-01-14 00:01:24', '2024-03-25 20:58:28', '[\"periyaa\",\"Ammar\"]', NULL),
(44, 'adada', 'addsad', 2, '9', 5, 1, 2, '2023-12-04', '2023-12-07', NULL, '2024-01-14 00:34:28', '2024-03-25 20:58:28', '[\"ammar-\"]', '2024-01-30'),
(46, 'adadal', 'adasd', 1, '9', 5, 1, 2, '2023-12-05', '2023-12-08', NULL, '2024-01-14 00:37:59', '2024-01-16 23:51:54', 'null', NULL),
(48, 'ccassa', 'dasdas', 1, '43', 10, 11, 6, '2024-01-16', '2024-01-20', NULL, '2024-01-16 03:55:10', '2024-01-16 04:16:41', '[\"ammar-\"]', NULL),
(51, 'adadas', 'adasdasdas', 2, '4', 5, 1, 2, '2023-12-03', '2023-12-07', NULL, '2024-01-16 07:45:04', '2024-03-25 20:45:57', '[\"ammar-\"]', NULL),
(52, 'satu', '1', 0, '47', 11, 12, 7, '2024-01-16', '2024-01-17', NULL, '2024-01-16 16:35:26', '2024-01-16 16:35:26', '[\"ammar-\"]', NULL),
(53, 'task 1', '1', 1, '11', 12, 13, 2, '2024-01-15', '2024-01-16', NULL, '2024-01-16 16:44:41', '2024-01-29 22:38:29', 'null', '2024-01-30'),
(54, 'task 2', '2', 1, '4', 12, 13, 2, '2024-01-17', '2024-01-18', NULL, '2024-01-16 16:45:06', '2024-01-29 22:38:34', 'null', '2024-01-30'),
(55, 'task 3', '3', 2, '11', 12, 13, 2, '2024-01-18', '2024-01-19', NULL, '2024-01-16 16:45:31', '2024-01-29 22:41:44', 'null', '2024-01-30'),
(58, 'TaskTest3', 'asdsad', 1, '4', 13, 14, 2, '2024-01-28', '2024-02-02', NULL, '2024-01-29 22:53:59', '2024-02-01 23:49:27', 'null', '2024-02-02'),
(59, 'TaskTest10', 'eqeeqw', 1, '11', 13, 14, 2, '2024-01-28', '2024-02-02', NULL, '2024-01-29 22:54:13', '2024-02-01 23:49:22', '[\"ammar-\"]', '2024-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `teammappings`
--

CREATE TABLE `teammappings` (
  `teammapping_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) NOT NULL,
  `role_name` varchar(191) NOT NULL,
  `team_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teammappings`
--

INSERT INTO `teammappings` (`teammapping_id`, `username`, `role_name`, `team_name`, `created_at`, `updated_at`) VALUES
(7, 'ammar-', 'Project Manager', 'Testers', '2024-01-09 22:25:31', '2024-01-09 22:25:31'),
(8, 'ammar-', 'Project Manager', 'g4ew[ioj', '2024-01-17 19:38:12', '2024-01-17 19:38:12'),
(9, 'jeevan', 'Developer', 'Testers', '2024-06-13 04:29:09', '2024-06-13 04:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(10) UNSIGNED NOT NULL,
  `team_name` varchar(191) NOT NULL,
  `proj_name` varchar(191) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `team_names` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`team_names`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `proj_name`, `created_at`, `updated_at`, `team_names`) VALUES
(3, 'Testers', '', '2024-01-09 22:25:31', '2024-01-09 22:25:31', NULL),
(4, 'g4ew[ioj', '', '2024-01-17 19:38:12', '2024-01-17 19:38:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `country` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `country`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'jeevan', 'jeevan', 'Malaysia', 'aumjeevan24@gmail.com', NULL, '$2y$10$JRPDtIDLnuMCs7jb6h8WL.xbBz/YxctPX6fQznFcJGvDLteLjHYhy', 'xFmPPTQfJIsRefbD2k8xDSBLhgAcV1tRhK23T3H3ZFHRxoSexc0dUC2bSQhr', '2023-09-07 20:02:56', '2023-09-07 20:02:56'),
(3, 'periyaa', 'periyaa1', 'Afghanistan', 'periyaa@gmail.com', NULL, '$2y$10$Pl7aHWuNzGtr430UBDvAu.rqe3xDCrulTDWUUoluc7nG.GLS9o4Cu', NULL, '2023-11-05 22:14:09', '2023-11-05 22:14:09'),
(4, 'Ammar', 'ammar-', 'Malaysia', 'ammar-@graduate.utm.my', NULL, '$2y$10$mFZFJ7SPGl1DADnzxu8uiuU4CMwnrUZDX7yslyVRmRiCd0BSJKxGW', 'F1bHKh46emrNjo1S4emgD4a9Ti3hMbxVtWZV2hU4yhA4NVtTUO2OcwwwLVnL', '2023-12-12 08:16:33', '2023-12-12 08:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_stories`
--

CREATE TABLE `user_stories` (
  `u_id` bigint(20) UNSIGNED NOT NULL,
  `user_story` varchar(191) NOT NULL,
  `means` varchar(191) NOT NULL,
  `prio_story` varchar(191) NOT NULL,
  `status_id` varchar(191) NOT NULL,
  `sprint_id` varchar(191) NOT NULL,
  `proj_id` varchar(191) NOT NULL,
  `perfeature_id` varchar(191) NOT NULL,
  `secfeature_id` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_names` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`user_names`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_stories`
--

INSERT INTO `user_stories` (`u_id`, `user_story`, `means`, `prio_story`, `status_id`, `sprint_id`, `proj_id`, `perfeature_id`, `secfeature_id`, `created_at`, `updated_at`, `user_names`) VALUES
(1, 'As a Developer, I am able to dev so that I can dev', 'dev', '0', '2', '1', '2', 'null', 'null', '2023-12-12 08:18:37', '2023-12-12 08:18:37', NULL),
(2, 'As a Developer, I am able to 1231 so that I can adadd', '1231', '0', '2', '2', '2', 'null', 'null', '2023-12-19 17:54:58', '2023-12-19 17:54:58', NULL),
(3, 'userStory test', 'devee', '0', '9', '1', '2', 'null', 'null', '2024-01-02 07:51:08', '2024-01-02 07:51:08', NULL),
(4, 'As a Developer, I am able to 8itfvl', '8itfvl', '0', '2', '6', '2', 'null', 'null', '2024-01-02 17:32:47', '2024-01-02 17:32:47', NULL),
(5, 'As a Developer, I am able to dassadasdas so that I can adadsd', 'dassadasdas', '0', '4', '1', '2', 'null', 'null', '2024-01-08 07:18:22', '2024-01-08 07:18:22', NULL),
(6, 'As a Developer, I am able to sadsad so that I can sad', 'sadsad', '0', '4', '8', '2', 'null', '[\"TestAddSec\"]', '2024-01-09 06:43:40', '2024-01-09 06:43:40', '[\"Shushma\",\"ammar-\",\"periyaa1\"]'),
(7, 'As a Developer, I am able to dassda so that I can adasd', 'dassda', '0', '2', '4', '2', 'null', '[\"TestAddSec\"]', '2024-01-09 18:23:21', '2024-01-09 18:23:21', '[\"Shushma\",\"periyaa1\"]'),
(8, 'As a Developer, I am able to dedev', 'dedev', '0', '4', '4', '2', '[\"TestAddPerf\"]', 'null', '2024-01-09 18:24:24', '2024-01-09 18:24:24', '[\"jeevan\",\"ammar-\"]'),
(9, 'As a Developer, I am able to makan so that I can burger', 'makan', '0', '4', '8', '2', '[\"TestAddPerf\"]', '[\"TestAddSec\"]', '2024-01-09 18:32:42', '2024-01-09 18:32:42', 'null'),
(10, 'As a Project Manager, I am able to dev', 'dev', '0', '41', '11', '6', 'null', 'null', '2024-01-16 03:50:53', '2024-01-16 03:50:53', '[\"ammar-\"]'),
(11, 'As a Project Manager, I am able to devd', 'devd', '0', '47', '12', '7', 'null', '[\"TestAddSec\"]', '2024-01-16 04:21:24', '2024-01-16 04:21:24', '[\"ammar-\"]'),
(12, 'As a Project Manager, I am able to us1 so that I can 1', 'us1', '0', '4', '13', '2', '[\"TestAddPerf\"]', '[\"TestAddSec\"]', '2024-01-16 16:43:29', '2024-01-16 16:43:29', '[\"ammar-\"]'),
(13, 'As a Project Manager, I am able to adasdq so that I can asda', 'adasdq', '0', '2', '14', '2', 'null', '[\"TestAddSec\"]', '2024-01-29 22:53:14', '2024-01-29 22:53:14', '[\"ammar-\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `boards_slug_unique` (`slug`);

--
-- Indexes for table `bugtrack`
--
ALTER TABLE `bugtrack`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bugtrack_project_id_foreign` (`project_id`);

--
-- Indexes for table `burndownchart`
--
ALTER TABLE `burndownchart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `burndownchart_task_id_foreign` (`task_id`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charts`
--
ALTER TABLE `charts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charts_sprintname_index` (`sprintname`),
  ADD KEY `charts_slug_index` (`slug`);

--
-- Indexes for table `coding_standards`
--
ALTER TABLE `coding_standards`
  ADD PRIMARY KEY (`codestand_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `defect_features`
--
ALTER TABLE `defect_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forums_user_id_foreign` (`user_id`);

--
-- Indexes for table `forum_favorites`
--
ALTER TABLE `forum_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forum_favorites_user_id_forum_id_unique` (`user_id`,`forum_id`),
  ADD KEY `forum_favorites_forum_id_foreign` (`forum_id`);

--
-- Indexes for table `mappings`
--
ALTER TABLE `mappings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `performance_features`
--
ALTER TABLE `performance_features`
  ADD PRIMARY KEY (`perfeature_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`prio_id`);

--
-- Indexes for table `product_features`
--
ALTER TABLE `product_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `security_features`
--
ALTER TABLE `security_features`
  ADD PRIMARY KEY (`secfeature_id`);

--
-- Indexes for table `sprint`
--
ALTER TABLE `sprint`
  ADD PRIMARY KEY (`sprint_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teammappings`
--
ALTER TABLE `teammappings`
  ADD PRIMARY KEY (`teammapping_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_stories`
--
ALTER TABLE `user_stories`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bugtrack`
--
ALTER TABLE `bugtrack`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `burndownchart`
--
ALTER TABLE `burndownchart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `charts`
--
ALTER TABLE `charts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coding_standards`
--
ALTER TABLE `coding_standards`
  MODIFY `codestand_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `defect_features`
--
ALTER TABLE `defect_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `forum_favorites`
--
ALTER TABLE `forum_favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mappings`
--
ALTER TABLE `mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance_features`
--
ALTER TABLE `performance_features`
  MODIFY `perfeature_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `prio_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_features`
--
ALTER TABLE `product_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `security_features`
--
ALTER TABLE `security_features`
  MODIFY `secfeature_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sprint`
--
ALTER TABLE `sprint`
  MODIFY `sprint_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `teammappings`
--
ALTER TABLE `teammappings`
  MODIFY `teammapping_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_stories`
--
ALTER TABLE `user_stories`
  MODIFY `u_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bugtrack`
--
ALTER TABLE `bugtrack`
  ADD CONSTRAINT `bugtrack_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `burndownchart`
--
ALTER TABLE `burndownchart`
  ADD CONSTRAINT `burndownchart_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `forum_favorites`
--
ALTER TABLE `forum_favorites`
  ADD CONSTRAINT `forum_favorites_forum_id_foreign` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
