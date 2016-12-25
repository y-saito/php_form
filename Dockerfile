FROM ubuntu:16.04

RUN apt-get update -y && \
    apt-get install -y sysv-rc-conf && \
    apt-get install -y vim && \
    apt-get install -y less && \
    apt-get install -y wget && \
    apt-get install -y curl && \
    apt-get install -y rsync && \
    apt-get install -y openssh-client && \
    apt-get install -y tree && \
    apt-get install -y expect && \
    apt-get install -y language-pack-ja && \

    #まだ中途半端
    update-locale LANG=ja_JP.UTF-8 && \
    apt-get install -y ntp && \
    echo "server ntp.nict.jp" >> /etc/ntp.conf \
    echo "NTP=ntp.ring.gr.jp" >> /etc/systemd/timesyncd.conf && \

    apt-get install -y nginx && \
    cd /etc/nginx/conf.d/ && \
    ln -s /tmp/share/nginx_php-fpm.conf nginx_php-fpm.conf 

ADD vimrc /root/.vimrc
EXPOSE 80
CMD ["npm", "start", "--production"]
