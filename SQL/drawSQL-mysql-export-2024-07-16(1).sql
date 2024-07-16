CREATE TABLE `users`(
    `id_user` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `pseudo` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `mail` VARCHAR(255) NOT NULL,
    `avatar` TEXT NULL,
    `admin` BOOLEAN NOT NULL
);
CREATE TABLE `response`(
    `id_response` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `author` BIGINT UNSIGNED NOT NULL,
    `text` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    `post_id` BIGINT UNSIGNED NOT NULL
);
CREATE TABLE `posts`(
    `id_posts` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `souscategorie_id` BIGINT UNSIGNED NOT NULL,
    `titre` VARCHAR(255) NOT NULL,
    `author` BIGINT UNSIGNED NOT NULL,
    `text` BIGINT NOT NULL,
    `date` DATETIME NOT NULL,
    `like` BIGINT NOT NULL
);
CREATE TABLE `sous_categorie`(
    `id_souscategorie` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `categorie_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY(`id_souscategorie`)
);
CREATE TABLE `signalement`(
    `id_signal` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `author` BIGINT UNSIGNED NOT NULL,
    `text` TEXT NULL,
    `signal_post_id` BIGINT UNSIGNED NULL,
    `signal_response_id` BIGINT UNSIGNED NULL,
    `report_status` BOOLEAN NOT NULL
);
CREATE TABLE `catégorie`(
    `id_categorie` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
ALTER TABLE
    `sous_categorie` ADD CONSTRAINT `sous_categorie_categorie_id_foreign` FOREIGN KEY(`categorie_id`) REFERENCES `catégorie`(`id_categorie`);
ALTER TABLE
    `signalement` ADD CONSTRAINT `signalement_signal_response_id_foreign` FOREIGN KEY(`signal_response_id`) REFERENCES `response`(`id_response`);
ALTER TABLE
    `response` ADD CONSTRAINT `response_author_foreign` FOREIGN KEY(`author`) REFERENCES `users`(`id_user`);
ALTER TABLE
    `posts` ADD CONSTRAINT `posts_souscategorie_id_foreign` FOREIGN KEY(`souscategorie_id`) REFERENCES `sous_categorie`(`id_souscategorie`);
ALTER TABLE
    `response` ADD CONSTRAINT `response_post_id_foreign` FOREIGN KEY(`post_id`) REFERENCES `posts`(`id_posts`);
ALTER TABLE
    `signalement` ADD CONSTRAINT `signalement_author_foreign` FOREIGN KEY(`author`) REFERENCES `users`(`id_user`);
ALTER TABLE
    `signalement` ADD CONSTRAINT `signalement_signal_post_id_foreign` FOREIGN KEY(`signal_post_id`) REFERENCES `posts`(`id_posts`);
ALTER TABLE
    `posts` ADD CONSTRAINT `posts_author_foreign` FOREIGN KEY(`author`) REFERENCES `users`(`id_user`);