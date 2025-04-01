ALTER TABLE `auction_bid` ADD `parent_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' AFTER `user_id`;
