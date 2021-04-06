
## Aplicação tem como bibliotecas de base:

- Slim: https://www.slimframework.com/docs/v4/
- Phinx: https://phinx.readthedocs.io/en/latest/intro.html

## Comandos Úteis

1. Iniciar o docker

```sh
docker-compose up
```

2. Iniciar entrar no contêiner do php

```sh
docker exec -it tvas-php bash
```

3. Instalar dependências

```sh
# dentro do contêiner do php
composer install
```

4. Acessar o container do banco de dados

```sh
docker exec -it tvas-sql bash -c "mysql -u tvas -p'tvas' tvas"
```

5. Acessar log da aplicação

```sh
docker exec -it tvas-php bash -c "grc -c conf.log tail -f var/logs/app.log"
```

6. Executar um teste específico

```sh
# dentro do contêiner do php
vendor/bin/phpunit --filter <ClasseDeTesteOuMetodoDeTeste>
# exemplo
vendor/bin/phpunit --filter testHealthCheckWillReturn200StatusCode
```

Mais informações em: https://phpunit.readthedocs.io/en/9.5/


7. Executar análise estática

```php
vendor/bin/psalm --show-issues=true
```

8. Executar migrações no banco de dados

```sh
# dentro do contêiner do php
vendor/bin/phinx migrate
```

Mais informações em: https://phinx.readthedocs.io/en/latest/intro.html

## Documentação da API da Transparência

- http://www.transparencia.gov.br/api-de-dados


## Atividades


1. Criar uma conta no portal de dados do governo e pegar seu token (ver link acima)
2. Adicionar o token na aplicação, conforme exemplo abaixo:

```php
<?php

// tests/settings.local.php
// Este arquivo é ignorado pelo git. Sendo assim, deverá ser criado pelo candidato.

return [
    'transparencia.token' => 'meu-token-secreto',
];
```

3. Executar um teste de integração para verificar se a conexão está ok.

```sh
vendor/bin/phpunit --filter testGetSiafiCodesIntegration

# esperado:
# OK (1 test, 1 assertion)
```

4. Criar um service para consulta na transparência para os endpoints:

- **endpoint1**: GET /api-de-dados/auxilio-emergencial-por-municipio
- **endpoint2**: GET /api-de-dados/bpc-por-municipio

5. Criar duas tabelas, uma para cada endpoint. Os campos das tabelas deverão ser criados de acordo com os campos de cada endpoint

6. Criar um rota na aplicação que dado um *codigoIbge* e um valor *mesAno*:

- Consulta nos dois enpoints do item 4 se a consulta já não estiver salva nas tabelas.
- Salva nas duas tabelas do item 5 se a consulta já não estiver salva nas tabelas.
- Retorna os valores combinados das duas consultas

Observação: O código ibge escolhido ficará a critério do candidato (escolha um código que traga resultados).

7. Realizar consultas para os meses de 2020 (janeiro a dezembro) nos dois enpoints e criar uma *seed* usando o phinx.

8. Construir testes:

- Um teste de integração para cada método do service.
- Um teste de integração pra cada repositório criado.
- Um teste funcional para a rota criada.
- Um teste unitário para o model e para o service criado.

## Considerações finais

- O estilo de código deverá seguir as PSR's 1 e 12.
- A injeção de dependências deverá seguir a PSR 11.

Documentação sobre as psr's: https://www.php-fig.org/psr/