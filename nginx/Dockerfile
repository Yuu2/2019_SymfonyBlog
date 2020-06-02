FROM nginx:alpine

COPY .htpasswd /etc/nginx/.htpasswd

COPY /ssl /etc/nginx/ssl

RUN apk update \
    && apk add openssl;

RUN openssl req -x509 -nodes -days 365 \
    -subj "/C=KR/ST=Gyeonggi-do/L=KwangMyeong/CN=Yuu2dev" \
    -newkey rsa:2048 \
    -keyout /etc/nginx/ssl/portfolio-blog.key \
    -out /etc/nginx/ssl/portfolio-blog.crt

RUN openssl dhparam -out /etc/nginx/ssl-dhparam.pem 2048;

RUN apk add --no-cache certbot

EXPOSE 80 443

RUN nginx