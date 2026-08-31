DROP TRIGGER IF EXISTS trg_sections_positive_position;

DROP VIEW IF EXISTS vw_sections_analytics;

DROP TABLE IF EXISTS visits;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS sections;
DROP TABLE IF EXISTS media;
DROP TABLE IF EXISTS posts;

CREATE TABLE visits (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    page_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE media (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(150) NOT NULL,
    site_description TEXT,
    logo_media_id INT UNSIGNED,
    favicon_media_id INT UNSIGNED,
    contact_email VARCHAR(255),
    phone VARCHAR(30),
    instagram VARCHAR(255),
    facebook VARCHAR(255),
    linkedin VARCHAR(255),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (logo_media_id) REFERENCES media(id) ON DELETE SET NULL,
    FOREIGN KEY (favicon_media_id) REFERENCES media(id) ON DELETE SET NULL
);

CREATE TABLE sections (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    position INT UNSIGNED NOT NULL,
    enabled BOOLEAN NOT NULL DEFAULT TRUE,
    config JSON NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_section_position (position)
);

CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    cover_image VARCHAR(255) NULL,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password) VALUES
('Admin', 'admin@test.com', '$2y$10$9yqIX9ZiuocYyHSZI9Xa..5VnHW.8juGkaCjY1OUz55xwhV0jObGy'); /* senha: 123 */

CREATE OR REPLACE VIEW vw_sections_analytics AS
WITH cleaned_sections AS (
    SELECT
        id,
        LOWER(TRIM(type)) AS section_type,
        position,
        enabled,
        NULLIF(TRIM(JSON_UNQUOTE(JSON_EXTRACT(config, '$.title'))), '') AS title,
        NULLIF(TRIM(JSON_UNQUOTE(JSON_EXTRACT(config, '$.subtitle'))), '') AS subtitle,
        NULLIF(TRIM(JSON_UNQUOTE(JSON_EXTRACT(config, '$.backgroundImage'))), '') AS background_image,
        created_at,
        updated_at
    FROM sections
)
SELECT
    id,
    section_type,
    position,
    CASE
        WHEN enabled = TRUE THEN 'enabled'
        ELSE 'disabled'
    END AS status,
    title,
    subtitle,
    background_image,
    created_at,
    updated_at
FROM cleaned_sections;

DELIMITER //

CREATE TRIGGER trg_sections_positive_position
BEFORE UPDATE ON sections
FOR EACH ROW
BEGIN
    IF NEW.position < 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'A posição da seção deve ser maior ou igual a 1.';
    END IF;
END//

DELIMITER ;
