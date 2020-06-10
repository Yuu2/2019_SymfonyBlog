FROM nginx:alpine

COPY .htpasswd /etc/nginx/.htpasswd

COPY /ssl /etc/nginx/ssl

RUN apk update \
    && apk add openssl;

# 임시 ssl 인증서 발급
RUN openssl req -x509 -nodes -days 365 \
    -subj "/C=KR/ST=Gyeonggi-do/L=KwangMyeong/CN=yuu2dev" \
    -newkey rsa:2048 \
    -keyout /etc/nginx/ssl/portfolio-blog.key \
    -out /etc/nginx/ssl/portfolio-blog.crt

RUN openssl dhparam -out /etc/nginx/ssl-dhparam.pem 2048;

EXPOSE 80 443

COPY /nginx.conf.template /etc/nginx/nginx.conf.template

# envsubst가 $를 엉뚱하게 인식해서 우회 설정
ENV S '$'

CMD ["/bin/sh" , "-c" , "envsubst < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf && exec nginx -g 'daemon off;'"]