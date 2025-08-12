O **AcessTrip** é uma plataforma web desenvolvida em **PHP** com arquitetura **MVC** e banco de dados **MySQL**, criada para conectar viajantes a serviços e locais acessíveis.  
O sistema oferece recursos para cadastro de usuários, gerenciamento de serviços, avaliações, favoritos e contratação com integração de pagamento via **Mercado Pago**.

---

## Funcionalidades

- **Autenticação de Usuários**
  - Cadastro com criptografia de senha (`password_hash`).
  - Login seguro e controle de sessão.
  - Painéis distintos para **Administrador**, **Prestador** e **Viajante**.

- **Locais e Serviços**
  - Cadastro e edição de locais e serviços.
  - Visualização em cards e tabelas.
  - Filtros e listagem personalizada para cada tipo de usuário.

- **Favoritos**
  - Adicionar e remover locais/serviços da lista de favoritos.

- **Suporte**
  - Sistema de tickets para contato com suporte.

- **Contratação de Serviços**
  - Integração com **API do Mercado Pago**.
  - Registro automático da contratação após pagamento (via Webhook).
  - Histórico de contratações com Serviço, Valor, Contratante, Status e Data.

- **Dashboard**
  - Interface moderna com sidebar, submenu e cards.
  - Estatísticas e atalhos rápidos para funcionalidades principais.

---

## Tecnologias Utilizadas

- **Back-end:** PHP (MVC)
- **Banco de Dados:** MySQL
- **Front-end:** HTML5, CSS3, JavaScript
- **Bibliotecas/Frameworks:** Bootstrap, jQuery
- **Integrações:**  
  - Mercado Pago API (pagamentos e Webhook)
- **Segurança:**  
  - Criptografia de senhas com `password_hash`
  - Controle de sessão e verificação de privilégios

---

## Como Executar o Projeto

1. **Clone este repositório**
   ```bash
   git clone https://github.com/seuusuario/accesstrip.git
Importe o banco de dados

Arquivo .sql disponível na pasta /database

Configure config/conexao.php com suas credenciais MySQL

Inicie o servidor local

Usando XAMPP, WAMP ou similar

Acesse no navegador
Editar
http://localhost/AcessTrip
