FROM python

RUN apt-get update -y
RUN apt-get install -y apt-utils
RUN apt-get install -y vim
RUN apt-get install -y nkf
RUN apt-get install -y less
RUN apt-get install -y tree

RUN apt-get install -y mecab
RUN apt-get install -y mecab-ipadic
RUN apt-get install -y mecab-ipadic-utf8
RUN apt-get install -y libmecab-dev

RUN pip install mecab-python3

#php.iniのパスは以下になります。
ENV PhpIniDir /etc/php5/apache2/conf.d
#apache2.confのパスは以下になります。
ENV Apache2ConfDir /etc/apache2/apache2.conf

RUN apt-get install -y software-properties-common python-software-properties
RUN apt-add-repository ppa:ondrej/apache2
RUN apt-get install -y apache2
ADD ./apache2.conf ${Apache2ConfDir}/apache2.conf

RUN apt-add-repository ppa:ondrej/php
RUN apt-get install -y php5
RUN apt-get install -y libapache2-mod-php5
RUN apt-get install -y php5-pgsql php5-gd php5-dev
RUN apt-get install -y postgresql postgresql-contrib


EXPOSE 80

ENTRYPOINT  /bin/sed -ie "s/ ###HOST_IP###/`/sbin/ip route|awk '/default/ { print $3 }'`/" ${PhpIniDir}/30-xdebug-conf.ini &&\
            /etc/init.d/apache2 start &&\
            /etc/init.d/postgresql start &&\
            /bin/bash
