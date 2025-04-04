-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 04:30 PM
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
-- Database: `mrmallik`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `project_id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `urlname` varchar(255) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `status` char(5) DEFAULT NULL,
  `github` varchar(100) NOT NULL COMMENT 'GitHub link',
  `online` varchar(100) NOT NULL COMMENT 'Online project link',
  `user_guide` varchar(100) NOT NULL COMMENT 'online link to user guide',
  `seo_title` varchar(255) NOT NULL,
  `seo_keyword` varchar(255) NOT NULL,
  `seo_desc` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `banner_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`project_id`, `type`, `title`, `urlname`, `overview`, `image`, `published_date`, `skills`, `status`, `github`, `online`, `user_guide`, `seo_title`, `seo_keyword`, `seo_desc`, `short_description`, `banner_image`) VALUES
(1, 'project', 'Personal Portfolio', 'personal-portfolio', 'Created a personal portfolio website to showcase my skills, projects, and professional journey. The project involved designing a visually compelling and responsive website using modern web technologies. Key achievements included implementing dynamic content sections, integrating a blog, and optimizing performance for various devices. This portfolio not only highlights my technical capabilities but also provides a platform for continuous updates and engagement with potential employers.', 'image.png', '2024-08-05', '21, 19, 7', 'A', 'https://github.com/mr-mallik/mr-mallik', 'https://mrmallik.com', '', 'Personal Portfolio - Showcase Your Skills', 'personal portfolio, web development', 'A modern personal portfolio to highlight skills and projects.', 'Designed and developed a personal portfolio website to effectively showcase skills and projects. The site features a responsive design, dynamic content sections, and performance optimizations to engage potential employers and showcase professional experti', 'banner.png'),
(2, 'project', 'Crowther Audit Program', 'crowther-audit-program', 'Developed an advanced auditing system in collaboration with the University of Huddersfield and Crowther Accountants. This project involved transitioning from a manual Excel-based audit process to an automated AI-driven system. The solution included automated processing of audit reports, integration of AI algorithms to enhance data accuracy, and a user-friendly interface for efficient navigation. Major achievements include a significant reduction in manual effort and processing time, leading to enhanced efficiency and accuracy in audit reporting. Key challenges included ensuring the system\'s adaptability to various audit scenarios and data types.', 'image.png', '2024-08-01', '1, 5, 20, 8, 13', 'A', 'https://github.com/mr-mallik/crowther', 'https://crowther.pythonanywhere.com', 'https://crowther.pythonanywhere.com/user-guide', 'Crowther Audit Program - Advanced Auditing System', 'audit program, AI integration', 'An automated auditing system that enhances accuracy and efficiency.', 'Developed an advanced auditing system in partnership with the University of Huddersfield and Crowther Accountants. This AI-powered solution replaced manual Excel processes, cutting down audit time and boosting accuracy and efficiency.', 'banner.png'),
(3, 'project', 'Automated Test Management and Asset Scheduling System (ATMAS)', 'atmas', 'Contributed to the ATMAS project, a cutting-edge web-based solution for advanced manufacturing. The platform integrates asset tracking, scheduling mechanisms, and secure communication features to streamline operations. Key achievements include the implementation of intuitive scheduling tools, effective asset management, and enhanced user experience. The project faced challenges in balancing complex scheduling needs with user-friendly design, ultimately delivering a system that optimizes productivity and resource allocation while maintaining data integrity.', 'image.jpeg', '2023-09-01', '8, 19, 14, 1', 'A', '', '', '', 'ATMAS - Asset Scheduling and Management System', 'asset management, test scheduling', 'A platform to optimize manufacturing processes and asset management.', 'Developed the ATMAS platform to address complex scheduling and asset management challenges in advanced manufacturing. The solution integrates asset tracking and scheduling tools to optimize productivity and ensure data integrity, revolutionizing operation', 'banner.png'),
(4, 'project', 'Business Management Suite for Ramjan Interiors', 'business-management-suite-ramjan-interiors', 'Designed a tailored software solution for Ramjan Interiors, focusing on seamless quotation generation, bill of materials creation, and GST tracking. This custom-developed system includes features for efficient income tax filing and insightful business reporting. Achievements include streamlining various business processes and providing valuable insights for growth. Challenges involved ensuring the system\'s adaptability to the specific needs of the business and integrating complex reporting functionalities.', 'image.png', '2023-03-01', '3, 14, 8, 19', 'A', '', '', '', 'Business Management Suite - Optimize Your Business Operations', 'business management, GST tracking', 'A comprehensive suite for efficient business operations and management.', 'Developed a custom software suite for Ramjan Interiors, streamlining quotation and invoice management, and simplifying GST tracking. The system enhances business insights and operational efficiency, supporting the company’s growth and success.', 'banner.png'),
(5, 'project', 'Dashboard Screen Builder', 'dashboard-screen-builder', 'Created an internal Business Intelligence tool for Trellissoft, Inc. The Dashboard Screen Builder features dynamic chart color changes, flexible database connections, and customizable templates. This tool has transformed data visualization within the company, enabling users to generate insightful dashboards with ease. Key achievements include enhancing data analysis capabilities and improving decision-making processes. Challenges included developing a flexible system that could accommodate various data visualization needs and user preferences.', 'image.png', '2022-05-01', '19, 14, 8, 3', 'A', '', '', '', 'Dashboard Screen Builder - Advanced Data Visualization', 'BI tool, data visualization', 'A tool for creating insightful dashboards and improving data visualization.', 'Developed a Business Intelligence tool to revolutionize data visualization at Trellissoft, Inc. The Dashboard Screen Builder features advanced customization options for charts and templates, empowering users to create detailed and insightful dashboards.', 'banner.png'),
(6, 'project', 'Amanora The Beauty Lounge', 'amanora-beauty-lounge', 'Led the development of a sophisticated booking application and backend system for Amanora The Beauty Lounge. The project involved crafting an engaging front-end interface and integrating APIs for seamless functionality. The resulting Progressive Web App is available on major app stores, providing a high-quality booking experience for users. Achievements include a user-friendly design and effective backend integration, with challenges centered around creating a cross-platform application that meets high performance and usability standards.', 'image.png', '2021-10-01', '6, 3, 19', 'A', '', '', '', 'Amanora Beauty Lounge - Booking Application and Backend', 'beauty lounge, booking app', 'A comprehensive booking app and backend system for beauty services.', 'Spearheaded the development of a high-quality booking app and backend system for Amanora The Beauty Lounge, delivering a seamless cross-platform experience for users and ensuring optimal functionality through API integration.', 'banner.png'),
(7, 'project', 'Life Pharma', 'life-pharma', 'Led the development of an e-commerce platform for pharmaceuticals, focusing on essential features like customer logins, order placement, and cart functionality. The project provided a seamless online shopping experience for pharmaceutical products and showcased strong proficiency in web development. Achievements include the implementation of crucial e-commerce functionalities and a user-friendly interface. Challenges involved ensuring security and smooth user interactions within the online shopping environment.', 'image.png', '2019-03-01', '3, 14, 8, 19', 'A', '', '', '', 'Life Pharma - E-commerce Platform for Pharmaceuticals', 'e-commerce, pharmaceuticals', 'An e-commerce site offering a seamless shopping experience for pharmaceuticals.', 'Created a comprehensive e-commerce platform for pharmaceutical products, featuring customer logins, order placement, and cart functionality. The platform delivers a seamless online shopping experience, highlighting web development expertise.', 'banner.png'),
(10, 'blog', 'Academic Rep', NULL, 'Huddersfield Students\'​ Union', 'academic-rep.png', '2023-09-01', NULL, NULL, '', '', '', '', '', '', 'As an Academic Representative, I acted as a crucial link between students and faculty, effectively communicating and advocating for student concerns. I championed adjustments to timetables and deadline extensions by clearly presenting student issues to pr', NULL),
(11, 'blog', 'Student Coordinator', NULL, 'St. Xaviers College Mapusa Goa', 'techlipse.jpeg', '2019-02-01', NULL, NULL, '', '', '', '', '', '', 'As the Student Coordinator for Techlipse 2019, I took charge of key responsibilities to ensure the event\'s success, including securing sponsorships, inviting colleges, and designing the event’s theme. I meticulously coordinated T-shirt printing and played', NULL),
(12, 'blog', 'Peer Commendation', NULL, 'Exceptional Achievement in Computing', 'peer-award.jpg', '2024-07-10', NULL, NULL, '', '', '', '', '', '', 'Receiving the Peer Commendation for Exceptional Achievement in Computing highlights my strong technical skills and problem-solving capabilities. This recognition underscores my collaborative approach and effective communication with peers, reflecting my c', NULL),
(13, 'blog', 'Master in Computing', NULL, 'Distinction', 'master-in-computing.jpg', '2024-07-13', NULL, NULL, '', '', '', '', '', '', 'Graduating with Distinction in my Master’s in Computing underscores my outstanding academic performance and deep understanding of advanced computing concepts. This accomplishment showcases my dedication, analytical prowess, and ability to excel in rigorou', NULL),
(14, 'blog', 'Bachelor in Computer Applications', NULL, 'Distinction', NULL, '2019-04-01', NULL, NULL, '', '', '', '', '', '', 'Earning a Distinction in my Bachelor in Computer Applications signifies exceptional academic performance and a solid grasp of foundational computing principles. This accomplishment demonstrates my dedication to learning, strong problem-solving abilities, ', NULL),
(15, 'blog', 'Centre for Precision Technology Group', NULL, 'Placement', 'placement.jpeg', '2024-01-01', NULL, NULL, '', '', '', '', '', '', 'During my placement with the Centre for Precision Technology Group at the University of Huddersfield, I developed the Automated Test Management & Scheduling System (ATMAS), now a critical tool within the group. This experience highlights my technical expe', NULL),
(16, 'blog', 'Accelerated Knowledge Transfer Project', NULL, 'University of Huddersfield and Crowther Accountants', NULL, '2024-06-01', NULL, NULL, '', '', '', '', '', '', 'In the Accelerated Knowledge Transfer project, I developed automated solutions that significantly boosted team efficiency and optimized processes. My role involved gathering requirements, discussing progress, and integrating feedback, showcasing my strong', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_det`
--

CREATE TABLE `blog_det` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_det`
--

INSERT INTO `blog_det` (`id`, `project_id`, `image`, `description`, `video_link`, `title`) VALUES
(1, 2, NULL, 'The Crowther Audit Program was a collaborative initiative between the University of Huddersfield and Crowther Accountants, aimed at automating the traditionally manual auditing processes that relied on Excel spreadsheets. By leveraging intelligent automation techniques and integrating the ChatGPT API, the project aimed to streamline the extraction and analysis of data from complex Excel files. This solution not only automated data validation and discrepancy detection but also significantly reduced the time required to complete audits, thereby improving overall efficiency and accuracy.', NULL, 'Overview'),
(2, 2, NULL, 'One of the main challenges was effectively integrating the ChatGPT API to interpret and extract relevant data from unstructured and complex Excel sheets. Ensuring that the automation correctly identified key data points and anomalies without human intervention required careful planning and testing. Additionally, maintaining data security and compliance with financial regulations was critical, given the sensitive nature of the information being handled. Designing an intuitive user interface that could be easily adopted by accountants was also a priority.', NULL, 'Challenges'),
(3, 2, NULL, 'The project implemented a modular architecture, utilizing Python and Django for backend processing and MySQL for data storage. By employing the ChatGPT API, the system was able to intelligently parse and interpret data from Excel files, automating the extraction of relevant information. The API integration allowed the system to handle complex data scenarios without the need for machine learning models, simplifying development and maintenance. The user interface was designed in collaboration with accountants to ensure it met their needs for ease of use and functionality, providing a smooth transition from traditional manual methods to an automated system.', NULL, 'Solutions and Implementation'),
(4, 2, NULL, 'The Crowther Audit Program successfully reduced audit processing time by up to 40%, automating manual data extraction and validation. This allowed accountants to focus on more strategic and analytical tasks, enhancing productivity and decision-making. The program\'s use of intelligent automation and the ChatGPT API minimized human error, thereby increasing the accuracy of financial audits. The project demonstrated the value of integrating modern automation techniques into traditional accounting practices, setting a precedent for future innovations in the field.', NULL, 'Achievements and Impact'),
(5, 2, NULL, 'The Crowther Audit Program has the potential for further development, such as enhancing the capabilities of the ChatGPT integration to handle more complex data scenarios and expanding its functionality to support other accounting tasks. There is also an opportunity to integrate the program with existing accounting software systems, providing a more comprehensive solution. Additionally, expanding the user interface to support multiple languages could facilitate broader adoption in international markets.', NULL, 'Future Scope'),
(6, 1, NULL, 'The Personal Portfolio project was a comprehensive web development initiative to create a professional online presence, showcasing skills, projects, and achievements. Built using Next.js and Tailwind CSS, the portfolio emphasizes responsive design and fast load times. The project features server-side rendering (SSR) for improved SEO and performance. Deployed using Vercel, the portfolio utilizes a MySQL database to manage all content dynamically, ensuring that updates can be made seamlessly without modifying the codebase.', NULL, 'Overview'),
(7, 1, NULL, 'One of the primary challenges was ensuring the portfolio site remained highly performant while managing dynamic content. Implementing server-side rendering with Next.js was crucial to improve SEO and provide a better user experience. Integrating MySQL for dynamic content management required careful planning to ensure data security and efficient data retrieval. Achieving a balance between a modern, attractive design and a user-friendly interface involved optimizing the use of Tailwind CSS to maintain consistency and visual appeal.', NULL, 'Challenges'),
(8, 1, NULL, 'The portfolio was developed using Next.js, leveraging its built-in features for server-side rendering and static site generation to enhance performance and SEO. Tailwind CSS was utilized for creating a sleek, responsive design, facilitating rapid development and customization of UI components. A MySQL database was integrated to manage the website content dynamically, enabling easy updates without changing the code. Vercel was chosen for deployment due to its seamless integration with Next.js and support for serverless functions, which ensure scalability and fast load times.', NULL, 'Solutions and Implementation'),
(9, 1, NULL, 'The Personal Portfolio project successfully established a professional online presence, effectively showcasing a range of web development skills, from frontend design to backend database management. The use of modern web technologies ensured a high-performance, scalable, and visually appealing platform. While the current version does not include a blog, the entire content is controlled via the database, making it easy to manage and update. This approach makes the portfolio a valuable tool for job applications and professional networking.', NULL, 'Achievements and Impact'),
(10, 1, NULL, 'Future enhancements include integrating Medium tiles to showcase blog posts directly from a Medium account, allowing for easy content sharing and engagement. Additionally, other interactive features using React.js could be added to improve user engagement. Regular updates to the project and skill sections will keep the portfolio current and reflective of ongoing professional growth and learning.', NULL, 'Future Scope'),
(11, 3, NULL, 'The Automated Test Management and Asset Scheduling System (ATMAS) was developed to streamline and optimize scheduling and asset management within advanced manufacturing environments. This web-based solution integrates asset tracking, scheduling mechanisms, and efficient communication to provide a cohesive and secure digital ecosystem. By automating the management of testing and resource allocation, ATMAS minimizes human error, reduces downtime, and enhances overall productivity. The system was designed to be highly scalable, accommodating the evolving needs of manufacturing operations. Currently, ATMAS is deployed and actively used at the University of Huddersfield within the Centre for Precision Technology (CPT) group.', NULL, 'Overview'),
(12, 3, NULL, 'Developing ATMAS presented several challenges, including ensuring data integrity and security across the system while maintaining ease of use. A key challenge was integrating various components such as asset tracking and scheduling into a seamless workflow. Additionally, achieving real-time data processing and synchronization required robust database management and effective handling of concurrent operations. Balancing the user interface to make it intuitive yet powerful was also critical to cater to both technical and non-technical users.', NULL, 'Challenges'),
(13, 3, NULL, 'To address these challenges, ATMAS was built using a Model-View-Controller (MVC) architecture to separate the concerns of data handling, user interface, and business logic. MySQL was chosen for its robust data management capabilities, ensuring reliable storage and retrieval of asset and scheduling data. JavaScript and HTML were employed to create a responsive and user-friendly front end, while AJAX was utilized for real-time data updates, providing a seamless user experience. Agile development methodologies were followed, allowing for iterative improvements based on user feedback and testing.', NULL, 'Solutions and Implementation'),
(14, 3, NULL, 'ATMAS has significantly improved the efficiency of scheduling and asset management processes at the University of Huddersfield\'s Centre for Precision Technology (CPT). By automating tasks that were previously manual, the system has reduced scheduling conflicts and minimized the time required for asset allocation. The integration of intuitive scheduling features has empowered users to plan and manage resources more effectively, leading to higher productivity and operational efficiency. The ability to track assets in real-time has provided better oversight and control, reducing the likelihood of mismanagement and loss.', NULL, 'Achievements and Impact'),
(15, 3, NULL, 'The development of ATMAS is considered complete, with no immediate plans for future enhancements. The system is fully operational and continues to support the University of Huddersfield\'s Centre for Precision Technology (CPT) group in managing their testing and asset scheduling needs. The successful deployment and adoption of ATMAS underscore its effectiveness and reliability as a critical tool within the research environment.', NULL, 'Project Completion'),
(16, 4, NULL, 'The Business Management Suite for Ramjan Interiors was developed as a comprehensive, all-in-one solution designed to streamline and automate various business processes. This suite aimed to enhance operational efficiency by integrating project management, inventory tracking, client management, and invoicing into a single, user-friendly platform. By centralizing these functionalities, the suite provides real-time insights and data-driven decision-making capabilities, allowing Ramjan Interiors to manage their projects more effectively and maintain control over their resources and client interactions. The system was custom-built to cater to the specific needs of the interior design industry, focusing on scalability and ease of use.', NULL, 'Overview'),
(17, 4, NULL, 'Developing the Business Management Suite presented several challenges, primarily due to the need for extensive customization to meet the unique requirements of Ramjan Interiors. Ensuring seamless integration of multiple modules (project management, inventory tracking, client management, and invoicing) into a cohesive system was a significant technical challenge. Another critical issue was managing the complexity of real-time data synchronization across different components, especially in a multi-user environment. Ensuring data security and protecting sensitive client information was also a top priority, which required robust security measures.', NULL, 'Challenges'),
(18, 4, NULL, 'To tackle these challenges, the suite was designed using a modular architecture, allowing each component (project management, inventory, client management, and invoicing) to function independently while still being part of a unified system. MySQL was used as the database to manage complex data relationships efficiently. The backend was built using PHP and Laravel, providing a robust and scalable framework for the application. The front end was developed using React JS, ensuring a responsive and intuitive user interface. Tailwind CSS was used to create a modern and aesthetically pleasing design. The application utilized REST APIs for efficient communication between the front end and back end, enabling real-time data updates.', NULL, 'Solutions and Implementation'),
(19, 4, NULL, 'The deployment of the Business Management Suite has significantly improved Ramjan Interiors\' operational efficiency. The integration of project management, inventory tracking, client management, and invoicing into a single platform has reduced the time and effort required to manage these processes separately. This has resulted in better resource allocation, reduced project turnaround time, and improved client satisfaction. The suite has provided Ramjan Interiors with real-time insights into their business operations, enabling them to make informed decisions and respond quickly to changes. The adoption of this suite has also led to a reduction in manual errors, enhancing the accuracy of inventory management and invoicing.', NULL, 'Achievements and Impact'),
(20, 4, NULL, 'The Business Management Suite is fully deployed and operational, and it continues to support Ramjan Interiors in managing their business processes efficiently. While the current implementation has met all the immediate needs of the business, there is potential for future enhancements. These could include advanced analytics capabilities, integration with third-party tools (such as accounting software), and the addition of more features to support growing business needs. The system\'s modular design makes it easy to add new functionalities as required, ensuring that it can evolve alongside the business.', NULL, 'Project Status and Future Scope'),
(27, 7, NULL, 'The LifePharma project was a final year bachelor’s project focused on developing an e-commerce platform for pharmaceutical sales. This project provided hands-on experience in web development, including customer login systems, order management, and shopping cart functionalities. The platform was designed to simulate a real-world e-commerce environment, allowing users to browse products, place orders, and manage their shopping experience. This project was a key component in honing web development skills and understanding the intricacies of building functional online systems.', NULL, 'Overview'),
(28, 7, NULL, '<ol>\n<li>Customer Login: Implemented secure login features for user account management.</li>\n<li>Order Management: Enabled order placement and tracking for a simulated online shopping experience.</li>\n<li>Shopping Cart: Created a functional shopping cart to handle product selection and purchasing.</li>\n<li>Wishlist Functionality: Incorporated a wishlist feature for users to save products for future reference.</li>\n<li>Session Management: Managed user sessions to simulate a personalized shopping experience.</li>\n</ol>', NULL, 'Key Features'),
(29, 7, NULL, 'Developing the LifePharma e-commerce platform presented several challenges. Ensuring the security of user data and creating a user-friendly interface were key concerns. Implementing session management and secure login systems were crucial for addressing these issues. The project required integrating various functionalities to simulate a realistic e-commerce experience, providing valuable insights into web development and project management.', NULL, 'Challenges & Solutions'),
(30, 7, NULL, 'While the LifePharma project was not deployed or hosted, it played a significant role in the development of web development skills. The project allowed for practical application of web development concepts and techniques, providing a solid foundation for future projects. The experience gained from this project contributed to a deeper understanding of building functional web systems and prepared me for more advanced development tasks.', NULL, 'Impact');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `first_name`, `last_name`, `phone`, `email`, `designation`, `about_me`, `password`) VALUES
(5, 'Gulger', 'Mallik', '+447767924720', 'gulgermallik@gmail.com', 'Software Engineer', 'As a seasoned web and software engineer, I specialize in PHP, MySQL, HTML, CSS, JavaScript, and React.js. I excel in creating custom CMS, e-commerce platforms, and online systems while managing projects efficiently and mentoring teams. My commitment to innovative solutions and creative problem-solving drives impactful results for clients and organizations.', '$2y$10$rqtFFgvxfQdscsJ3navibee2m8k7e32tXPlN48r2XlR/T3U.3dQLS');

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE `resume` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'Type or section the variable belongs to',
  `title` text DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `other` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `status` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`id`, `type`, `title`, `subtitle`, `content`, `other`, `skills`, `logo`, `link`, `start`, `end`, `status`) VALUES
(1, 'edu', 'MSc  Computing', 'University of Huddersfield, England UK', 'Grade Distinction', NULL, NULL, NULL, NULL, NULL, '2024-07-11', 'A'),
(2, 'edu', 'Bachelor of Computer Applications', 'St. Xaviers\' College, Goa, India', 'Grade: Distinction', NULL, NULL, NULL, NULL, NULL, '2019-04-01', 'A'),
(3, 'hobby', 'Fitness', NULL, NULL, NULL, NULL, 'FaShoePrints', NULL, NULL, NULL, 'A'),
(4, 'hobby', 'Cooking', NULL, NULL, NULL, NULL, 'FaUtensils', NULL, NULL, NULL, 'A'),
(5, 'hobby', 'Travel', NULL, NULL, NULL, NULL, 'FaPlaneDeparture', NULL, NULL, NULL, 'A'),
(6, 'hobby', 'Coding', NULL, NULL, NULL, NULL, 'FaLaptop', NULL, NULL, NULL, 'A'),
(7, 'work', 'Research Technician (AKT Associate)', 'University of Huddersfield, England, UK', NULL, NULL, '1, 5, 8, 16, 20', NULL, NULL, '2024-04-15', '2024-08-14', 'A'),
(8, 'work', 'Research & Development Software Engineer', 'University of Huddersfield, England, UK', NULL, NULL, '3, 8, 11, 12, 13, 17', NULL, NULL, '2023-10-23', '2024-04-10', 'A'),
(9, 'work', 'Software Engineer', 'Shop & Bakery Equipment Ltd, England, UK', NULL, NULL, '3, 8, 14, 15, 16', NULL, NULL, '2022-12-22', '2024-03-01', 'A'),
(10, 'work', 'Software Engineer', 'Trellissoft, Inc. Goa, India', NULL, NULL, '3, 4, 9, 12, 18', NULL, NULL, '2022-03-07', '2022-08-31', 'A'),
(11, 'work', 'Software Engineer', 'Team Inertia Technologies, Goa, India', NULL, NULL, '6, 3, 19, 8, 15, 12', NULL, NULL, '2019-05-27', '2022-03-05', 'A'),
(12, 'cert', 'Sustainable Software Architecture', 'LinkedIn', NULL, NULL, NULL, 'https://img.icons8.com/nolan/96/backend-development.png', NULL, NULL, '2024-04-01', 'A'),
(13, 'cert', 'Writing a Tech Resume', 'LinkedIn', NULL, NULL, NULL, 'https://img.icons8.com/plasticine/100/resume.png', NULL, NULL, '2024-04-01', 'A'),
(14, 'cert', 'React JS Training', 'LinkedIn', NULL, NULL, NULL, 'https://img.icons8.com/color/96/000000/react-native.png', NULL, NULL, '2024-03-01', 'A'),
(15, 'cert', 'Change Management Skills', 'Live And Learn Consultancy', NULL, NULL, NULL, 'https://img.icons8.com/arcade/64/change.png', NULL, NULL, '2023-10-01', 'A'),
(16, 'cert', 'Master in Laravel', 'Udemy', NULL, NULL, NULL, 'https://img.icons8.com/fluency/96/000000/laravel.png', NULL, NULL, '2023-10-01', 'A'),
(17, 'cert', 'Complete Java', 'Udemy', NULL, NULL, NULL, 'https://img.icons8.com/color/96/000000/java-coffee-cup-logo.png', NULL, NULL, '2023-05-01', 'A'),
(18, 'cert', 'Oracle Java Certification 1: Data Types', 'LinkedIn', NULL, NULL, NULL, 'https://img.icons8.com/color/96/000000/java-coffee-cup-logo.png', NULL, NULL, '2022-12-01', 'A'),
(19, 'cert', 'Oracle Java Certification 2: Operators and Decision Statements', 'LinkedIn', NULL, NULL, NULL, 'https://img.icons8.com/color/96/000000/java-coffee-cup-logo.png', NULL, NULL, '2022-12-01', 'A'),
(20, 'cert', 'Oracle Java Certification 3: Methods and Inheritance', 'LinkedIn', NULL, NULL, NULL, 'https://img.icons8.com/color/96/000000/java-coffee-cup-logo.png', NULL, NULL, '2022-12-01', 'A'),
(21, 'cert', 'Python Programming', 'Udemy', NULL, NULL, NULL, 'https://img.icons8.com/color/96/000000/python.png', NULL, NULL, '2022-12-01', 'A'),
(22, 'other', 'Academic Rep', 'Huddersfield Students\'​ Union', 'As an Academic Representative, I acted as a crucial link between students and faculty, effectively communicating and advocating for student concerns. I championed adjustments to timetables and deadline extensions by clearly presenting student issues to professors. My proactive engagement and open discussions ensured that student difficulties were promptly addressed, demonstrating my leadership in problem-solving and collaboration.', NULL, NULL, 'academic-rep.png', NULL, '2022-09-23', '2023-09-01', 'A'),
(23, 'other', 'Student Coordinator', 'St. Xaviers College Mapusa Goa', 'As the Student Coordinator for Techlipse 2019, I took charge of key responsibilities to ensure the event\'s success, including securing sponsorships, inviting colleges, and designing the event’s theme. I meticulously coordinated T-shirt printing and played a vital role in approving games and delegating tasks. My leadership and organizational skills were pivotal in delivering a well-executed and memorable event for all participants.', NULL, NULL, 'techlipse.jpeg', NULL, NULL, '2019-02-01', 'A'),
(24, 'other', 'Peer Commendation', 'Exceptional Achievement in Computing', 'Receiving the Peer Commendation for Exceptional Achievement in Computing highlights my strong technical skills and problem-solving capabilities. This recognition underscores my collaborative approach and effective communication with peers, reflecting my commitment to excellence and support in driving collective success.', NULL, NULL, 'peer-award.jpg', NULL, NULL, '2024-07-10', 'A'),
(25, 'other', 'Master in Computing', 'Distinction', 'Graduating with Distinction in my Master’s in Computing underscores my outstanding academic performance and deep understanding of advanced computing concepts. This accomplishment showcases my dedication, analytical prowess, and ability to excel in rigorous coursework, reflecting a high level of intellectual capability and commitment to academic excellence.', NULL, NULL, 'master-in-computing.jpg', NULL, NULL, '2024-07-13', 'A'),
(26, 'other', 'Bachelor in Computer Applications', 'Distinction', 'Earning a Distinction in my Bachelor in Computer Applications signifies exceptional academic performance and a solid grasp of foundational computing principles. This accomplishment demonstrates my dedication to learning, strong problem-solving abilities, and readiness to tackle complex challenges with competence and confidence.', NULL, NULL, NULL, NULL, NULL, '2019-04-01', 'A'),
(27, 'other', 'Centre for Precision Technology Group', 'Placement', 'During my placement with the Centre for Precision Technology Group at the University of Huddersfield, I developed the Automated Test Management & Scheduling System (ATMAS), now a critical tool within the group. This experience highlights my technical expertise, project management skills, and ability to deliver impactful solutions, underscoring my collaborative approach and effective communication.', NULL, NULL, 'placement.jpeg', NULL, NULL, '2024-01-01', 'A'),
(28, 'other', 'Accelerated Knowledge Transfer Project', 'University of Huddersfield and Crowther Accountants', 'In the Accelerated Knowledge Transfer project, I developed automated solutions that significantly boosted team efficiency and optimized processes. My role involved gathering requirements, discussing progress, and integrating feedback, showcasing my strong interpersonal skills, adaptability, and ability to work closely with clients and stakeholders to achieve successful outcomes.', NULL, NULL, NULL, NULL, NULL, '2024-06-01', 'A'),
(29, 'work', 'Research Assistant in Applied Artificial Intelligence', 'University of Huddersfield, England, UK', NULL, NULL, '1,13,11', NULL, NULL, '2024-10-09', NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `subtitle`, `image`, `description`, `link`) VALUES
(1, 'Websites', NULL, 'https://cdn.pixabay.com/photo/2016/06/28/05/10/laptop-1483974_960_720.jpg', 'Get a stunning website that showcases your brand and drives conversions. Responsive design, SEO-optimized, and user-friendly.', NULL),
(2, 'Mobile Apps', NULL, 'https://cdn.pixabay.com/photo/2015/10/21/08/22/media-998990_960_720.jpg', 'Connect with your customers on-the-go with a custom mobile app. Cross-platform development, intuitive UI, and powerful features.', NULL),
(3, 'Software', NULL, 'https://cdn.pixabay.com/photo/2016/06/03/13/57/digital-marketing-1433427_960_720.jpg', 'Transform your business with a scalable and secure web application. Streamline workflows, automate processes, and boost productivity.', NULL),
(4, 'Custom Solutions', NULL, 'https://cdn.pixabay.com/photo/2016/08/21/18/35/office-1610479_960_720.jpg', 'Tailored solutions for unique business challenges. Drive real results with a solution that meets your exact requirements.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `type` char(5) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_pill` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `type`, `title`, `icon`, `icon_pill`, `featured`, `rank`) VALUES
(1, 'tech', 'Python', 'https://img.icons8.com/color/96/000000/python.png', 'https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white', 1, 1),
(2, 'tech', 'Java', 'https://img.icons8.com/color/96/000000/java-coffee-cup-logo.png', 'https://img.shields.io/badge/Java-007396?style=for-the-badge&logo=java&logoColor=white', 1, 2),
(3, 'tech', 'PHP', 'https://img.icons8.com/color/96/000000/php.png', 'https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white', 1, 3),
(4, 'frame', 'Laravel', 'https://img.icons8.com/fluency/96/000000/laravel.png', 'https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white', 1, 1),
(5, 'frame', 'Django', 'https://img.icons8.com/color/96/000000/django.png', 'https://img.shields.io/badge/Django-092E20?style=for-the-badge&logo=django&logoColor=white', 1, 2),
(6, 'frame', 'React JS', 'https://img.icons8.com/color/96/000000/react-native.png', 'https://img.shields.io/badge/React-61DAFB?style=for-the-badge&logo=react&logoColor=black', 1, 3),
(7, 'frame', 'Next JS', 'https://img.icons8.com/fluency/96/000000/nextjs.png', 'https://img.shields.io/badge/Next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white', 1, 4),
(8, 'db', 'MySQL', 'https://img.icons8.com/fluency/96/000000/mysql-logo.png', 'https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white', 1, 1),
(9, 'db', 'PostgreSQL', 'https://img.icons8.com/color/96/000000/postgreesql.png', 'https://img.shields.io/badge/PostgreSQL-336791?style=for-the-badge&logo=postgresql&logoColor=white', 1, 2),
(10, 'db', 'MongoDB', 'https://img.icons8.com/color/96/000000/mongodb.png', 'https://img.shields.io/badge/MongoDB-47A248?style=for-the-badge&logo=mongodb&logoColor=white', 1, 3),
(11, 'gen', 'Git', 'https://img.icons8.com/color/96/000000/git.png', 'https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white', 1, 1),
(12, 'gen', 'Rest API', 'https://img.icons8.com/external-flaticons-flat-flat-icons/96/000000/external-api-web-development-flaticons-flat-flat-icons.png', 'https://img.shields.io/badge/REST-02569B?style=for-the-badge&logo=rest&logoColor=white', 1, 2),
(13, 'gen', 'ML/AI', 'https://img.icons8.com/external-bright-fill-juicy-fish/84/external-algorithm-data-science-bright-fill-bright-fill-juicy-fish-2.png', 'https://img.shields.io/badge/Machine_Learning-FF6F00?style=for-the-badge&logo=tensorflow&logoColor=white', 1, 3),
(14, 'gen', 'HTML/CSS', 'https://img.icons8.com/color/96/000000/html-5.png', 'https://img.shields.io/badge/HTML/CSS-E34F26?style=for-the-badge&logo=html5&logoColor=white', 1, 4),
(15, 'gen', 'AJAX', 'https://img.icons8.com/stickers/100/web-application-firewall.png', 'https://img.shields.io/badge/AJAX-0055A2?style=for-the-badge&logo=javascript&logoColor=white', 1, 5),
(16, 'soft', 'Probelm Solving', 'https://img.icons8.com/isometric/100/rubiks-cube.png', 'https://img.shields.io/badge/Problem_Solving-007EC6?style=for-the-badge&logo=codeforces&logoColor=white', 0, 1),
(17, 'soft', 'Change Management', 'https://img.icons8.com/arcade/64/change.png', 'https://img.shields.io/badge/Change_Management-1D4ED8?style=for-the-badge&logo=change&logoColor=white', 0, 2),
(18, 'soft', 'Critical Thinking', 'https://img.icons8.com/stickers/100/critical-thinking.png', 'https://img.shields.io/badge/Critical_Thinking-FF4500?style=for-the-badge&logo=thinkpad&logoColor=white', 0, 3),
(19, 'tech', 'JavaScript', 'https://img.icons8.com/fluency/48/javascript.png', 'https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black', 0, 4),
(20, 'gen', 'GPT API', 'https://img.icons8.com/fluency/96/chatgpt--v2.png', 'https://img.shields.io/badge/ChatGPT_API-412991?style=for-the-badge&logo=openai&logoColor=white', 1, 6),
(21, 'frame', 'Tailwind CSS', 'https://img.icons8.com/color/96/tailwind_css.png', 'https://img.shields.io/badge/Tailwind%20CSS-%20-38b2ac?logo=tailwindcss', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `title`, `icon`, `link`, `rank`) VALUES
(1, 'GitHub', 'FaGithub', 'https://github.com/mr-mallik', 1),
(2, 'LinkedIn', 'FaLinkedin', 'https://linkedin.com/in/mrmallik', 2),
(3, 'Email', 'FaEnvelope', 'mailto:gulgermallik@gmail.com', 3),
(4, 'Instagram', 'FaInstagram', 'https://instagram.com/its_mrmallik', 4),
(5, 'Medium', 'FaMediumM', 'https://mrmallik.medium.com', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`project_id`),
  ADD UNIQUE KEY `urlname` (`urlname`);

--
-- Indexes for table `blog_det`
--
ALTER TABLE `blog_det`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resume`
--
ALTER TABLE `resume`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `blog_det`
--
ALTER TABLE `blog_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resume`
--
ALTER TABLE `resume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_det`
--
ALTER TABLE `blog_det`
  ADD CONSTRAINT `blog_det_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `blog` (`project_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
