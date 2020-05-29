FROM nginx:alpine

COPY .htpasswd /etc/nginx/.htpasswd

RUN mkdir /etc/nginx/ssl;

RUN apk update \
    && apk add openssl;

RUN openssl req -x509 -nodes -days 365 \
    -subj "/C=KR/ST=Gyeonggi-do/L=KwangMyeong/CN=Yuu2" \
    -newkey rsa:2048 -keyout /etc/nginx/ssl/portfolio-blog.key \
    -out /etc/nginx/ssl/portfolio-blog.crt;

RUN openssl dhparam -out /etc/nginx/ssl/portfolio-blog-dhparam.pem 2048;

RUN ls -al /etc/nginx/ssl;

RUN apk add --no-cache certbot

COPY nginx-entrypoint.sh /usr/local/bin/nginx-entrypoint.sh
RUN  chmod +x            /usr/local/bin/nginx-entrypoint.sh

EXPOSE 80
EXPOSE 443

RUN nginx

ENTRYPOINT [ "sh", "/usr/local/bin/nginx-entrypoint.sh" ]