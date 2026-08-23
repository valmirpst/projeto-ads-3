# Projeto CMS (Cafeteria)

Um sistema de gerenciamento de conteúdo (CMS) desenvolvido com foco em simplicidade e iteratividade, sem o uso de frameworks pesados no backend.

## Tecnologias

- **Backend:** PHP puro com roteamento customizado (`router.php`) e conexão PDO.
- **Banco de Dados:** MariaDB / MySQL.
- **Frontend:** TypeScript (compilado para JS nativo) consumindo APIs via `fetch`.

## Funcionalidades Implementadas

- **Autenticação:** Painel administrativo protegido por login.
- **Configurações do Site:** Edição de título, descrição e redes sociais.
- **Gerenciamento de Seções:** Organização dinâmica do conteúdo da página inicial.
- **Mídia:** Sistema para upload de arquivos.
- **Analytics:** Rastreio assíncrono de visitas na página inicial com dashboard consolidando Total de Visitas e Visitantes Únicos.

## Como rodar o projeto

1. **Banco de Dados:**
   - Crie um banco de dados no seu MySQL/MariaDB (XAMPP).
   - Importe o arquivo `cms_db.sql` para criar a estrutura das tabelas.
   - Importe o arquivo `seed.sql` para inserir os dados iniciais.
   - _O usuário padrão criado pelo seed é `admin@test.com` com a senha `123`._

2. **Compilação do Frontend:**

   ```bash
   npm install
   npm run build
   ```

   _(Ou `npm run dev` para recompilar automaticamente enquanto coda)._

3. **Servidor:**
   Basta rodar o Apache pelo painel do XAMPP e acessar a pasta do projeto no seu `localhost`, ou usar o servidor embutido do PHP na raiz do projeto.
