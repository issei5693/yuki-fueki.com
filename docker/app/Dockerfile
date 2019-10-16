FROM amazonlinux:2018.03

RUN yum -y update && \
	yum -y install vim git mysql

#PHP7.1のインストール
RUN	yum -y install php71 && \
	yum -y install php71-mbstring php71-pdo php71-mysqlnd php71-opcache php71-devel php71-xdebug

#apacheのインストール
RUN yum -y install httpd24

COPY httpd.conf /etc/httpd/conf/httpd.conf
COPY php.ini /etc/php.ini

RUN chkconfig httpd on

# Nodeのインストール
RUN curl -sL https://rpm.nodesource.com/setup_6.x | bash - && \
	yum install -y nodejs

EXPOSE 80
EXPOSE 443
CMD ["/usr/sbin/httpd", "-DFOREGROUND"]
