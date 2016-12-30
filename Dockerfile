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
#/etc/php5/apache2/php.ini
RUN apt-get install -y software-properties-common python-software-properties
RUN apt-add-repository ppa:ondrej/apache2
RUN apt-get install -y apache2
RUN apt-add-repository ppa:ondrej/php
RUN apt-get install -y php5
RUN apt-get install -y libapache2-mod-php5
RUN apt-get install -y php5-pgsql php5-gd php5-dev
RUN apt-get install -y postgresql postgresql-contrib


#ENTRYPOINT /etc/init.d/apache2 start && /etc/init.d/postgresql start && /etc/init.d/sshd start && /bin/bash
