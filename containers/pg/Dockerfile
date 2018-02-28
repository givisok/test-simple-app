FROM postgres:9.6.2-alpine
# Timezone and locale
ENV TIMEZONE Europe/Moscow
ENV TZ Europe/Moscow
ENV LANG ru_RU.utf8
ADD init.sh /docker-entrypoint-initdb.d/
