CREATE TABLE IF NOT EXISTS users (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    age tinyint(3) NOT NULL,
    country varchar(255) NOT NULL,
    social_media_url varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    update_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id),
    UNIQUE KEY (email)
);

CREATE TABLE IF NOT EXISTS `users`(
                        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key, AI, non negative numbers',
                        `email` VARCHAR(255) NOT NULL DEFAULT '""',
                        `password` VARCHAR(255) NOT NULL,
                        `age` TINYINT UNSIGNED NOT NULL,
                        `country` VARCHAR(255) NOT NULL,
                        `social_media_url` VARCHAR(255) NOT NULL,
                        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                        `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()
);
ALTER TABLE
    `users` ADD UNIQUE `users_email_unique`(`email`);
CREATE TABLE IF NOT EXISTS `transactions`(
                               `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                               `description` VARCHAR(255) NOT NULL,
                               `amount` DECIMAL(8, 2) NOT NULL,
                               `date` DATETIME NOT NULL,
                               `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                               `update_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                               `user_id` BIGINT UNSIGNED NOT NULL
);
ALTER TABLE
    `transactions` ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);

CREATE TABLE IF NOT EXISTS receipts(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    original_filename varchar(255) NOT NULL,
    storage_filename varchar(255) NOT NULL,
    media_type varchar(255) NOT NULL,
    transaction_id bigint(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(transaction_id) REFERENCES transactions (id) ON DELETE CASCADE
    );