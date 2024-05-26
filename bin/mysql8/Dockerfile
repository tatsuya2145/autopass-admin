FROM mysql:latest
RUN echo "[mysqld]" >> /etc/mysql/my.cnf
RUN echo "mysql-native-password=ON" >> /etc/mysql/my.cnf
RUN echo "authentication_policy=mysql_native_password,," >> /etc/mysql/my.cnf