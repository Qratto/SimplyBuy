# Инструкция по запуску

В проекте используется Laravel, MySQL.

Если при запуске проекта через Docker возникают какие либо ошибки, советую посмотреть Запуск без Docker

## Запуск используя Docker

Зайдите в папку deploy и выполните команды:

```bash
docker-compose build
docker-compose up
```

После чего вы можете работать с проектом при помощи Postman - вставив в качестве `{{host}}` значение `http://localhost:8080` 

## Запуск без Docker 

Инструкция работоспособна только для Windows

Для запуска приложения без докера, необходимы: PHP 8.2 и Xampp.

1. Для начала установите [PHP](https://www.php.net/downloads.php), [XAMPP](https://www.apachefriends.org/)

2. Откройте папку xampp (которую вы установили) перейдите в папку htdocs и переместите туда папку с проектом project и переименуйте его в project.loc

3.Вернитесь в корневую папку xampp и перейдите по пути \xampp\apache\conf\extra откройте файл httpd-vhosts.conf, в конце файла напишите: <br/>
```
<VirtualHost *:80> 
    ##ServerAdmin webmaster@dummy-host2.example.com 
    DocumentRoot "D:/xampp/htdocs/project.loc/public" 
    ServerName project.loc 
    ##ErrorLog "logs/dummy-host2.example.com-error.log" 
    ##CustomLog "logs/dummy-host2.example.com-access.log" common 
</VirtualHost> 
```
4. Запустите Xampp Control Panel, на против Apache перейдите в config и далее откройте PHP(php.ini) <br/>
В данном файле найдите следующие строки и раскоментируйте их убирая ; перед строкой (данные строки идут не по порядку, поэтому в файле каждую из них ищите отдельно)
```
extension=curl
extension=fileinfo
extension=gettext
extension=mbstring
extension=mysqli
extension=pdo_mysql
extension=pdo_sqlite
extension=zip
```
5. Перейдите в папку C:\Windows\System32\drivers\etc (Диск C является системным), откройте файл hosts и в конце файла необходимо добавить строку
```
127.0.0.1 project.loc
```
6. Перейдите в Xampp Control Panel (Если закрыли запустите заново), и запустите Apache и MySQL нажимая на Start. Перейдите в браузере по адресу
```
http://project.loc/
```
Если ошибок не возникло, значит всё работает. Если же возникла ошибка 404 not found, то выполните шаги по запуску еще раз начиная со второго пункта   
# Примечания
В Postman в качестве хоста необходимо использовать 
```
http://project.loc/api/
```

