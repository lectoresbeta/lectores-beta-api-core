ARG MYSQL_VERSION

FROM mysql:${MYSQL_VERSION}

ARG BASE_DIRECTORY

ADD ${BASE_DIRECTORY}/mysql/scripts/privileges.sql /docker-entrypoint-initdb.d/privileges.sql
ADD ${BASE_DIRECTORY}/mysql/scripts/db-creation.sql /docker-entrypoint-initdb.d/db-creation.sql

CMD ["mysqld"]
