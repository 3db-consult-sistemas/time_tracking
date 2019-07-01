CREATE TABLE `projects` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
	`status` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '4',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO time_tracking.projects (name, status) VALUES
('Vacaciones', '2'),
('Baja', '2'),
('Formación - En puesto', '1'),
('Formación - Curso', '1'),
('Formación - Desarrollos', '1'),
('Comité', '4'),
('Igualdad', '4'),
('Gerencia', '4'),
('Sistemas', '4');


CREATE TABLE `project_user` (
	`project_id` int(10) unsigned NOT NULL,
	`user_id` int(10) unsigned NOT NULL,
	UNIQUE KEY `project_user_project_id_user_id_unique` (`project_id`,`user_id`),
	KEY `project_user_user_id_foreign` (`user_id`),
	CONSTRAINT `project_user_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
	CONSTRAINT `project_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE records ADD COLUMN project_id int(10) unsigned DEFAULT NULL;
ALTER TABLE records ADD CONSTRAINT records_project_id_foreign FOREIGN KEY (project_id) REFERENCES projects(id);
