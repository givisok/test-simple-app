#!/bin/sh

# выпиливаем тот хост что там есть
sed '/xdebug.remote_host/d' '/usr/local/etc/php/php.ini' > '/tmp/tmp.php.ini'
cat '/tmp/tmp.php.ini' > '/usr/local/etc/php/php.ini'
# запиливаем айпишник нашего хоста
echo 'xdebug.remote_host='`/sbin/ip route|awk '/default/ { print $3 }'` >> '/usr/local/etc/php/php.ini'

# в бой!
'phpunit'
