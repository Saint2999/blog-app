FROM php:8.1-fpm

ENV TZ=Europe/Moscow
ENV LANG ru_RU.utf8
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
  && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  zlib1g-dev \
  libpq-dev \
  libzip-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql zip bcmath gd

EXPOSE 9000