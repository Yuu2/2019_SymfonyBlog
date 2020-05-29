FROM nginx:alpine

COPY .htpasswd /etc/nginx/.htpasswd

RUN apk update \
    && apk add openssl;

RUN openssl dhparam -out /etc/nginx/ssl-dhparam.pem 2048;

RUN apk add --no-cache certbot

EXPOSE 80 443

RUN nginx