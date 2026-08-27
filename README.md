# Projeto CMS

Um sistema de gerenciamento de conteúdo (CMS) desenvolvido com foco em simplicidade, sem o uso de frameworks pesados e priorizando a abordagem clássica do PHP.

## Tecnologias

- **Backend:** PHP puro com roteamento customizado (`router.php`) e conexão PDO.
- **Banco de Dados:** MariaDB / MySQL.
- **Views (SSR):** Renderização Server-Side (HTML misturado com PHP) para o painel de administração e site público. Formulários processados nativamente via `POST`.
- **Frontend (Restrito):** TypeScript (compilado para JS nativo) consumindo APIs REST, usado estritamente para o painel de métricas (Dashboard).

## Funcionalidades Implementadas

- **Autenticação:** Painel administrativo protegido por login clássico com Sessions.
- **Configurações do Site:** Edição de título, descrição, upload nativo de logos e redes sociais.
- **Gerenciamento de Seções:** Organização dinâmica do conteúdo da página inicial.
- **Mídia:** Sistema para upload de arquivos direto pelo servidor.
- **Analytics:** Rastreio assíncrono de visitas na página inicial com dashboard consolidando Total de Visitas e Visitantes Únicos via API e TypeScript.

## Como rodar o projeto

1. **Banco de Dados:**
   - Crie um banco de dados no seu MySQL/MariaDB (XAMPP).
   - Importe o arquivo `cms_db.sql` para criar a estrutura das tabelas.
   - Importe o arquivo `seed.sql` para inserir os dados iniciais.
   - _O usuário padrão criado pelo seed é `admin@test.com` com a senha `123`._

2. **Compilação do Frontend (Apenas para Analytics):**

   ```bash
   npm install
   npm run build
   ```

   _(O Typescript compilará apenas os arquivos da Dashboard na pasta `public/assets/js/`)._

3. **Servidor:**
   Basta rodar o Apache pelo painel do XAMPP e acessar a pasta do projeto no seu `localhost`, ou usar o servidor embutido do PHP na raiz do projeto.
