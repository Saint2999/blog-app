FROM httpd:2.4

ENV TZ=Europe/Moscow
ENV LANG ru_RU.utf8
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY apache.conf /usr/local/apache2/conf/httpd.conf