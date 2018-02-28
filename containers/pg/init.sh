#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<-EOSQL
    \connect test-store;
    CREATE SCHEMA IF NOT EXISTS test_schema;
EOSQL