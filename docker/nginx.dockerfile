FROM nginx

ADD docker/nginx/vconf.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/laravel