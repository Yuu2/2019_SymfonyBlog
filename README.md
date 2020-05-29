## Introduce
포트폴리오 소개 및 개발일람등을 기술할 블로그. <br>

![](./screenshot/homepage.png) <br>

## Installation
<small>1. env 파일의 전역변수 값 입력 </small><br>

<small> 2. docker-compose up</small>

## Test Accounts
```
ID: admin@yuu2.dev
PW: admin

ID: user@yuu2.dev
PW: user
```

## Let's encrypt

##### [1] 도커 이미지를 이용한 발급
```
docker run -it --rm --name certbot 
  -v '/프로젝트 경로/certbot/etc/letsencrypt:/etc/letsencrypt' 
  -v '/프로젝트 경로/certbot/var/lib/letsencrypt:/var/lib/letsencrypt'  
  certbot/certbot certonly 
    -d '도메인' 
    --manual 
    --preferred-challenges dns 
    --server https://acme-v02.api.letsencrypt.org/directory
```
##### [2] 네임서버에 TXT 레코드를 입력해야 합니다.
<small> RECORD_NAME : _acme-challenge.도메인</small><br>
<small> VALUE       : certbot을 통한 암호키</small><br>

##### [3] nslookup -q=TXT 도메인
