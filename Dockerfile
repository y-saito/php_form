FROM python

# env
ENV PhpIniFile /etc/php5/apache2/php.ini
ENV PhpIniDir /etc/php5/apache2/conf.d
ENV Apache2ConfDir /etc/apache2
ENV PostfixConfDir /etc/postfix
ENV HostsFile /etc/hosts

# base
RUN apt-get update -y
RUN apt-get install -y apt-utils
RUN apt-get install -y vim
RUN apt-get install -y nkf
RUN apt-get install -y less
RUN apt-get install -y tree
RUN apt-get install -y telnet
RUN apt-get install -y rsyslog
RUN apt-get install -y net-tools

# mecab
RUN apt-get install -y mecab
RUN apt-get install -y mecab-ipadic
RUN apt-get install -y mecab-ipadic-utf8
RUN apt-get install -y libmecab-dev
RUN pip install mecab-python3

# apache2
RUN apt-get install -y software-properties-common python-software-properties
RUN apt-add-repository ppa:ondrej/apache2
RUN apt-get install -y apache2
ADD ./apache2.conf ${Apache2ConfDir}/apache2.conf

# php
RUN apt-add-repository ppa:ondrej/php
RUN apt-get install -y php5
RUN apt-get install -y libapache2-mod-php5
RUN apt-get install -y php5-pgsql php5-gd php5-dev
ADD ./php.ini ${PhpIniFile}

# postgresql
RUN apt-get install -y postgresql postgresql-contrib

# postfix
RUN echo postfix postfix/main_mailer_type string "'Internet Site'" | debconf-set-selections && \
  echo postfix postfix/mynetworks string "127.0.0.0/8" | debconf-set-selections && \
  echo postfix postfix/mailname string php-form.local | debconf-set-selections && \
  apt-get -y install postfix
ADD ./postfix-main.cf ${PostfixConfDir}/main.cf

# application-config
RUN cd /var/www/html &&\
    ln -s /tmp/share/app/ php_form &&\
    cd /etc/apache2/mods-enabled/ &&\
    ln -s ../mods-available/rewrite.load

# develop mode
RUN apt-get install -y php5-xdebug
ADD ./xdebug-conf.ini ${PhpIniDir}/30-xdebug-conf.ini

EXPOSE 80

ENTRYPOINT  /bin/sed -ie "s/ ###HOST_IP###/`/sbin/ip route|awk '/default/ { print $3 }'`/" ${PhpIniDir}/30-xdebug-conf.ini &&\
            /etc/init.d/apache2 start &&\
            /etc/init.d/postgresql start &&\
            /etc/init.d/rsyslog start &&\
            /etc/init.d/postfix start &&\
            /bin/bash
