CREATE TABLE `blog` (
 `blog_id` int(11) NOT NULL AUTO_INCREMENT,
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
 `short_description` text NOT NULL,
 `banner_image` varchar(100) DEFAULT NULL,
 PRIMARY KEY (`blog_id`),
 UNIQUE KEY `urlname` (`urlname`)
);

CREATE TABLE `blog_det` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `blog_id` int(11) DEFAULT NULL,
 `image` varchar(255) DEFAULT NULL,
 `description` text DEFAULT NULL,
 `video_link` varchar(255) DEFAULT NULL,
 `title` varchar(100) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `blog_id` (`blog_id`),
 CONSTRAINT `blog_det_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`)
);
