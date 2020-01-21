FROM mysql:5.7


ADD sql/movie-example-app.sql.gz /docker-entrypoint-initdb.d/
ADD my_custom.cnf /etc/mysql/conf.d/my_custom.cnf

ENTRYPOINT ["docker-entrypoint.sh"]
