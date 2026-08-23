INSERT INTO settings (
    site_name, site_description, logo_media_id, favicon_media_id, contact_email, phone, instagram, facebook, linkedin, created_at, updated_at
) VALUES (
    'Dark Cafeteria',
    'A copy of a Cafeteria website made by Caio Aydrian.',
    NULL,
    NULL,
    'admin@test.com',
    '1234567890',
    NULL,
    NULL,
    NULL,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);


INSERT INTO sections (type, position, enabled, config) VALUES 
(
    'hero', 
    1,
    1,
    '{
        "title": "Made with passion, served with the soul!",
        "subtitle": "A well-made coffee it\'s like art. Just like a life well-lived.",
        "backgroundImage": "uploads/cafeteria_caio_hero.jpeg",
        "textColor": "#ffffff"
    }'
    /* "buttonText": "Saiba Mais",
    "buttonLink": "#sobre",
    "buttonColor": "#0d6efd",
    "buttonTextColor": "#ffffff" */
)