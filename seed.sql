INSERT INTO settings (
    site_name, site_description, logo_media_id, favicon_media_id, contact_email, phone, instagram, facebook, linkedin, created_at, updated_at
) VALUES (
    'Dark Cafeteria',
    'A copy of a Cafeteria website made by Caio Aydrian.',
    NULL,
    NULL,
    'admin@test.com',
    '44 99999-9999',
    'https://www.instagram.com/valmirpst_',
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
);

INSERT INTO posts (title, slug, content, status, published_at, created_at) VALUES 
(
    'Os Benefícios do Café Especial', 
    'beneficios-do-cafe-especial', 
    '<p>Você sabia que os cafés especiais passam por uma seleção rigorosa? Eles oferecem notas sensoriais incríveis como chocolate, caramelo e frutas. Além de não precisarem de açúcar, são muito mais saudáveis para o seu organismo por não conterem grãos defeituosos carbonizados na torra. É uma experiência completamente diferente!</p>', 
    'published', 
    DATE_SUB(NOW(), INTERVAL 5 DAY),
    DATE_SUB(NOW(), INTERVAL 5 DAY)
),
(
    'Como Fazer o Filtrado Perfeito (V60)', 
    'como-fazer-filtrado-v60', 
    '<p>O método Hario V60 é o queridinho dos baristas. O segredo está na moagem média e no fluxo constante de água quente (cerca de 92°C). Faça a pré-infusão, molhando todo o pó por 30 segundos, e depois despeje a água em movimentos espirais do centro para a borda. Aproveite o seu café super aromático!</p>', 
    'published', 
    DATE_SUB(NOW(), INTERVAL 2 DAY),
    DATE_SUB(NOW(), INTERVAL 2 DAY)
),
(
    'Nossos Novos Grãos Importados', 
    'novos-graos-importados', 
    '<p>Na próxima semana vamos receber microlotes exclusivos da Etiópia e da Colômbia. Fiquem de olho, a pré-venda vai abrir em breve.</p>', 
    'draft', 
    NULL,
    NOW()
);

INSERT INTO visits (session_id, page_url, created_at) VALUES 
('sess_1234abc', '/', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('sess_1234abc', '/post?slug=beneficios-do-cafe-especial', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('sess_9999xyz', '/', DATE_SUB(NOW(), INTERVAL 3 DAY)),
('sess_8888def', '/', DATE_SUB(NOW(), INTERVAL 4 DAY)),
('sess_8888def', '/post?slug=como-fazer-filtrado-v60', DATE_SUB(NOW(), INTERVAL 4 DAY)),
('sess_7777ghi', '/', NOW());