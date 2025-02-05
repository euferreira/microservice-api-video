## Problemas de permissão?
- Execute o container do docker com o comando abaixo:
- `docker-compose up -d --build`
- Logo em seguida, entre no container com o comando abaixo:
- `docker exec -it --user=root microservice-videos-app bash`
- Ao entrar no container, volte um diretório com `cd ../` e execute o comando abaixo:
- `chmod 777 storage -R`;
- Caso o problema persista para outras pastas, execute o comando acima para a pasta em questão.