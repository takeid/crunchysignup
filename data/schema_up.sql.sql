ALTER TABLE `user` ADD `created_at` DATETIME  NOT NULL;
ALTER TABLE `user` ADD `updated_at` DATETIME  NOT NULL;
ALTER TABLE `user` ADD `token` VARCHAR(32)  NULL  DEFAULT NULL;
ALTER TABLE `user` ADD `token_created_at` DATETIME  NULL;



