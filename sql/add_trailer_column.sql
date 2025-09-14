-- Add trailer_url column to media table
ALTER TABLE `media` ADD COLUMN `trailer_url` VARCHAR(255) DEFAULT NULL AFTER `description`;

-- Update some existing media with sample YouTube trailer URLs
UPDATE `media` SET `trailer_url` = 'dQw4w9WgXcQ' WHERE `title` = 'Inception';
UPDATE `media` SET `trailer_url` = 'EXeTwQWrcwY' WHERE `title` = 'The Dark Knight';
UPDATE `media` SET `trailer_url` = 'zSWdZVtXT7E' WHERE `title` = 'Interstellar';
UPDATE `media` SET `trailer_url` = '5xH0HfJHsaY' WHERE `title` = 'Parasite';
UPDATE `media` SET `trailer_url` = 'b9EkMc79ZSU' WHERE `title` = 'Stranger Things';
UPDATE `media` SET `trailer_url` = 'HhesaQXLuRY' WHERE `title` = 'Breaking Bad';
UPDATE `media` SET `trailer_url` = '6hB3S9bIaco' WHERE `title` = 'The Shawshank Redemption';
UPDATE `media` SET `trailer_url` = 'sY1S34973zA' WHERE `title` = 'The Godfather';

-- For entries without specific trailers, we'll use a generic placeholder
UPDATE `media` SET `trailer_url` = 'dQw4w9WgXcQ' WHERE `trailer_url` IS NULL;