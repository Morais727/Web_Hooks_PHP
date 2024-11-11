## Documentação do Projeto: Webhooks para Gestão de Boletins de Sementes

---

### 1. Introdução ao Projeto

Este projeto consiste em dois webhooks desenvolvidos em PHP, que permitem receber e consultar informações sobre boletins de sementes. O sistema facilita a integração de dados de boletins com outras aplicações, armazenando informações de boletins de sementes em um banco de dados e permitindo consultas sobre certificados de sementes.

### 2. Descrição dos Webhooks

O projeto inclui dois webhooks principais:

- **Receber Boletim** (`receber_boletim.php`): Este webhook recebe os dados de um boletim de sementes, valida as informações e as armazena em uma tabela de banco de dados MySQL. Quando os dados são recebidos com sucesso, ele retorna um número de protocolo; em caso de erro, ele retorna uma mensagem de erro.

- **Consultar Certificado** (`consultar_certificado.php`): Este webhook permite consultar, pelo número do boletim, o certificado associado. Ele retorna o número do certificado e o arquivo em formato Base64, ou uma mensagem de erro caso o boletim não seja encontrado.

### 3. Tecnologias Utilizadas

As tecnologias empregadas neste projeto são:

- **PHP**: Linguagem de programação usada para desenvolver os webhooks, processar requisições e interagir com o banco de dados.
- **MySQL**: Banco de dados onde os dados dos boletins e certificados são armazenados.
- **JSON**: Formato de dados utilizado para a comunicação entre os webhooks e outros sistemas.
- **HTTP/HTTPS**: Protocolo de comunicação dos webhooks.
- **Autenticação com Tokens e Cabeçalhos HTTP**: Técnica de segurança que garante que apenas sistemas autorizados enviem e consultem dados.

### 4. Configuração do Ambiente

**Requisitos**:
- Servidor com PHP (recomendado PHP 7.4 ou superior)
- Banco de dados MySQL
- Editor de código (Visual Studio Code, PHPStorm, etc.)

**Passos de Configuração**:
1. **Configurar o Banco de Dados**: Crie as tabelas `boletins` e `certificados` conforme descrito na seção 7.
2. **Salvar os Arquivos PHP**: Coloque os arquivos `receber_boletim.php` e `consultar_certificado.php` em um diretório acessível do servidor web.
3. **Arquivo de Configuração do Banco de Dados**: Crie um arquivo `config.php` para armazenar as credenciais de conexão ao MySQL.

### 5. Exemplo de Fluxo

- **Receber Boletim**: Outro sistema envia os dados do boletim para o webhook `receber_boletim.php`. O webhook valida e armazena as informações, retornando um protocolo de sucesso ou mensagem de erro.
- **Consultar Certificado**: Outro sistema envia o número do boletim para o webhook `consultar_certificado.php`, que responde com os dados do certificado e o arquivo em Base64, ou com uma mensagem de erro se o boletim não for encontrado.

### 6. Instruções de Uso e Testes

1. **Testar Requisições**: Utilize uma ferramenta como **Postman** para testar as requisições HTTP.
2. **Cabeçalhos de Autenticação**: Para ambos os webhooks, inclua os cabeçalhos `Token`, `CNPJ`, e `Senha` para autenticação.
3. **Requisição de Exemplo**:
   - Método: `POST`
   - URL: `https://seudominio.com/webhooks/receber_boletim.php`
   - Corpo da Requisição (JSON):
     ```json
     {
       "numero_boletim": "0556/2024",
       "produtor": "Semente Forte Ltda.",
       "especie": "SOJA",
       "cultivar": "18216IPRO",
       "safra": "2023/2024",
       "categoria": "Básica",
       "peso_lote": 10000.00
     }
     ```

### 7. Estrutura do Banco de Dados

**Tabela `boletins`**:
- `id`: Identificador único.
- `numero_boletim`: Número do boletim.
- `produtor`: Nome do produtor.
- `especie`: Espécie de semente.
- `cultivar`: Cultivar da semente.
- `safra`: Ano da safra.
- `categoria`: Categoria da semente.
- `peso_lote`: Peso do lote em kg.
- `data_amostragem`: Data da amostragem.
- `cidade_ubs`: Cidade da UBS.

**Tabela `certificados`**:
- `id`: Identificador único.
- `numero_boletim`: Número do boletim (relacionado a `boletins.numero_boletim`).
- `numero_certificado`: Número do certificado.
- `arquivo_base64`: Arquivo em formato Base64.
