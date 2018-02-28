#/bin/sh
SCRIPT_DIR=$(dirname $(readlink -f $0))
source "$SCRIPT_DIR/inc/pass.sh"
source "$SCRIPT_DIR/inc/backup-file.sh"
echo "start dumping"
docker exec -i $(docker-compose ps | grep _pg_ | cut -d" " -f 1) bin/bash -c "export PGPASSWORD="$PASS" && pg_dump -U postgres -h localhost -c postgres" | gzip > $BACKUP_FILE
echo "finished dumping"