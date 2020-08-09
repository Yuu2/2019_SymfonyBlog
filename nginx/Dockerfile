FROM nginx:alpine

ARG APP_ENV
ARG APP_VIRTUAL
ARG NGINX_CONF_TEMPLATE
ARG NGINX_CONF_TEMPLATE_VIRTUAL
ARG SSL

ENV APP_ENV ${APP_ENV} 
ENV APP_VIRTUAL ${APP_VIRTUAL}
ENV NGINX_CONF_TEMPLATE ${NGINX_CONF_TEMPLATE}
ENV NGINX_CONF_TEMPLATE_VIRTUAL ${NGINX_CONF_TEMPLATE_VIRTUAL}
ENV SSL ${SSL}

RUN apk update && apk add \
    openssl \
    vim

# SSL
RUN if [ "${APP_ENV}" == "dev"  ]; then \
        mkdir ${SSL} \
        && \
        # 보안키 암호화 및 복호화
        openssl genrsa -out ${SSL}/portfolio-blog.key 2048 \
        # && \
        # openssl rsa ${SSL}/portfolio-blog.pass.key -out ${SSL}/portfolio-blog.key \
        # && \
        # rm -f ${SSL}/portfolio-blog.pass.key \
        # && \
        # 보안키에 대한 권한 설정 
        # chmod 600 ${SSL}/portfolio-blog.key \
        # 인증서 생성
        && \
        openssl req -x509 -nodes -days 365 \
            -subj "/C=KR/ST=Gyeonggi-do/L=KwangMyeong/CN=yuu2dev" \
            -newkey rsa:2048 \
            -keyout ${SSL}/portfolio-blog.key \
            -out ${SSL}/portfolio-blog.crt \
        && \
        openssl dhparam -out ${SSL}/ssl-dhparam.pem 2048 ; \
        fi

EXPOSE 80 443

COPY ./nginx.conf.template ${NGINX_CONF_TEMPLATE_VIRTUAL}

# envsubst가 $를 엉뚱하게 인식해서 우회 설정
ENV S '$'

CMD ["/bin/sh" , "-c" , "envsubst < ${NGINX_CONF_TEMPLATE_VIRTUAL} > /etc/nginx/nginx.conf && exec nginx -g 'daemon off;'"]