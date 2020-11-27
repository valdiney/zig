#!/bin/sh
set -e

# Ponto de entrada padrão para o container do PHP
# Utiliza o comando ip route para pegar o Gateway padrão para fazer funcionar o XDebug
# sem ter que configurar o endereço IP manualmente
if [ -z "$DOCKER_HOST_IP" ]; then
    DOCKER_HOST_IP=$(ip route | grep default | grep -oE "[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+")
fi

echo "\nxdebug.remote_host=$DOCKER_HOST_IP\n" >> /usr/local/etc/php/conf.d/xdebug.ini

# Dar permissão de execução pros scripts na pasta bin se existir
# algum (se não existir continua o script normal)
if [[ -f /var/www/html/bin/*.sh ]]; then
    chmod +x /var/www/html/bin/*.sh
    dos2unix /var/www/html/bin/*.sh
fi

if [[ -f /var/www/html/bin/*.sh ]]; then
    chmod +x /var/www/html/bin/*.sh
    dos2unix /var/www/html/bin/*.sh
fi

sh /usr/local/bin/docker-php-entrypoint "$@"
