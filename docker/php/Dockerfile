FROM phpdockerio/php74-fpm:latest

WORKDIR /var/www/

RUN apt-get update -y && apt-get install -y git git-flow vim curl software-properties-common
RUN apt-get update -y && add-apt-repository ppa:ondrej/php

RUN apt-get update && apt-get autoremove && apt-get -y --no-install-recommends install -y php7.4-mysql php7.4-intl