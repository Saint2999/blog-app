FROM nginx:1.25

ENV TZ=Europe/Moscow
ENV LANG ru_RU.utf8
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY nginx.conf /etc/nginx/conf.d/default.conf