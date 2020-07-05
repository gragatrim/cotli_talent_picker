FROM trafex/alpine-nginx-php7
USER root
RUN apk --no-cache add php-bcmath
USER nobody
