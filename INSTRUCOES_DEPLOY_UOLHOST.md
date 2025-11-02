# Instruções de Deploy - Sistema EDUTEC no UOL Host

## Especificações do Ambiente
- **Servidor:** Windows Server
- **Web Server:** Nginx/1.20.1
- **PHP:** 8.0.15
- **MySQL:** 5.6
- **Charset:** utf8mb4_unicode_ci
- **Cliente MySQL:** libmysql - mysqlnd 8.0.15
- **Extensões PHP:** mysqli, mbstring, curl

## Credenciais do Banco de Dados
- **Host:** ited-site.mysql.uhserver.com
- **Banco:** edutec
- **Usuário:** edutec
- **Senha:** it@d3004

## Passo a Passo do Deploy

### 1. Preparação do Banco de Dados

1. Acesse o painel de controle do UOL Host
2. Vá para a seção de bancos de dados MySQL
3. Certifique-se de que o banco `edutec` existe
4. Execute o script SQL `edutec_mysql56.sql` para criar as tabelas:
   ```sql
   -- Importe o arquivo edutec_mysql56.sql através do phpMyAdmin ou ferramenta similar
   ```

### 2. Upload dos Arquivos

1. Conecte-se ao FTP do UOL Host
2. Navegue até a pasta raiz do seu domínio (geralmente `public_html` ou `www`)
3. Faça upload de todos os arquivos do sistema:
   ```
   sistema_edutec/
   ├── conexao.php
   ├── login.php
   ├── logout.php
   ├── auth_check.php
   ├── home.php
   ├── home_joao_pessoa.php
   ├── header.php
   ├── footer.php
   ├── index.php
   ├── config_uolhost.php
   ├── .htaccess
   ├── gerenciar_unidade_equipamento.php
   ├── formacoes.php
   ├── equipamentos.php
   ├── unidades.php
   └── logs/ (criar diretório)
   ```

### 3. Configuração de Permissões

1. Certifique-se de que o diretório `logs/` tem permissão de escrita
2. Se necessário, crie o diretório `uploads/` com permissão de escrita

### 4. Configuração do Nginx (se necessário)

Se você tiver acesso às configurações do Nginx, adicione:

```nginx
server {
    listen 80;
    server_name seu-dominio.com.br;
    root /caminho/para/sistema_edutec;
    index index.php index.html;

    # Configurações PHP
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Proteção de arquivos sensíveis
    location ~ /(config_uolhost|conexao)\.php$ {
        deny all;
    }

    # Proteção de logs
    location ~ /logs/ {
        deny all;
    }
}
```

### 5. Teste da Instalação

1. Acesse `http://seu-dominio.com.br/`
2. Você deve ser redirecionado para `login.php`
3. Teste o cadastro de um novo usuário
4. Teste o login com as credenciais criadas
5. Verifique se o redirecionamento por cidade funciona

### 6. Usuários Padrão

O sistema vem com usuários pré-configurados (senha padrão: `password`):

- **admin** - Administrador (Bayeux)
- **bayeux** - Usuário Bayeux
- **joaopessoa** - Usuário João Pessoa

**IMPORTANTE:** Altere as senhas padrão imediatamente após o primeiro acesso!

### 7. Configurações Adicionais

#### 7.1 Logs de Sistema
- Os logs são salvos em `logs/system_YYYY-MM-DD.log`
- Monitore regularmente para identificar problemas

#### 7.2 Backup
- Configure backup automático do banco de dados
- Faça backup regular dos arquivos do sistema

#### 7.3 Segurança
- Mantenha o PHP e MySQL atualizados
- Use HTTPS sempre que possível
- Monitore tentativas de acesso não autorizado

### 8. Estrutura de Cidades

O sistema suporta as seguintes cidades:
1. **Bayeux** (ID: 1) - Página padrão: `home.php`
2. **João Pessoa** (ID: 2) - Página específica: `home_joao_pessoa.php`
3. **Cabedelo** (ID: 3) - Página: `home_cabedelo.php` (criar se necessário)
4. **Pitimbu** (ID: 4) - Página: `home_pitimbu.php` (criar se necessário)
5. **Conceição** (ID: 5) - Página: `home_conceicao.php` (criar se necessário)

### 9. Personalização por Cidade

Para criar páginas específicas para outras cidades:

1. Copie `home_joao_pessoa.php` como modelo
2. Renomeie para `home_[nome_cidade].php`
3. Ajuste o `$user_city_id` para o ID correto da cidade
4. Personalize o design e conteúdo conforme necessário

### 10. Solução de Problemas

#### Erro de Conexão com Banco
- Verifique as credenciais em `conexao.php`
- Confirme se o banco `edutec` existe
- Teste a conexão através do phpMyAdmin

#### Erro de Charset
- Verifique se o banco está configurado com `utf8mb4_unicode_ci`
- Confirme as configurações de charset no PHP

#### Problemas de Sessão
- Verifique as permissões do diretório de sessões
- Confirme as configurações de sessão no `config_uolhost.php`

#### Erro 500
- Verifique os logs de erro do servidor
- Confirme se todas as extensões PHP necessárias estão instaladas

### 11. Contato e Suporte

Para problemas específicos do UOL Host:
- Acesse o painel de controle do UOL Host
- Entre em contato com o suporte técnico
- Consulte a documentação oficial do UOL Host

### 12. Checklist Final

- [ ] Banco de dados criado e populado
- [ ] Arquivos enviados via FTP
- [ ] Permissões configuradas
- [ ] Teste de login realizado
- [ ] Redirecionamento por cidade funcionando
- [ ] Logs sendo gerados corretamente
- [ ] Senhas padrão alteradas
- [ ] Backup configurado

---

**Data de Criação:** <?php echo date('d/m/Y H:i:s'); ?>
**Versão do Sistema:** 1.0
**Compatibilidade:** UOL Host Windows + PHP 8 + MySQL 5.6

