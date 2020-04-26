<h1>Для установки проекта необходимо</h1>

1. Создать виртуальный хост для домена (freelancehunt.local)

`sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/freelancehunt.local.conf`

`<IfModule mod_ssl.c>`

    `<VirtualHost freelancehunt.local:443>`
    
        `DocumentRoot /var/www/freelancehunt`
        
            `ServerAdmin admin@freelancehunt.local`
            
            `ServerName freelancehunt.local`
            
            `SSLEngine on`
            
            `SSLCertificateFile /etc/apache2/ssl/freelancehunt.crt`
            
            `SSLCertificateKeyFile /etc/apache2/ssl/freelancehunt.key`
            
            `<Directory /var/www/freelancehunt/>`
            
                    `Options Indexes FollowSymLinks MultiViews`
                    
                    `AllowOverride All`
                    
                    `Order allow,deny`
                    
                    `Allow from all`
                    
            `</Directory>`
            
            `ErrorLog ${APACHE_LOG_DIR}/freelancehunt-error.log`
            
        `CustomLog ${APACHE_LOG_DIR}/freelancehunt-access.log combined`
        
    `</VirtualHost>`
    
`</IfModule>`


`sudo gedit /etc/apache2/sites-available/freelancehunt.local.conf`

2. Сгенерировать сертификат

`sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/freelancehunt.key -out /etc/apache2/ssl/freelancehunt.crt`

`Country Name (2 letter code) [AU]:UA`

`State or Province Name (full name) [Some-State]:Kyiv`

`Locality Name (eg, city) []:Kyiv City`

`Organization Name (eg, company) [Internet Widgits Pty Ltd]:Freelancehunt, company`

`Organizational Unit Name (eg, section) []:Freelancehunt, company`

`Common Name (e.g. server FQDN or YOUR name) []:freelancehunt.local`

`Email Address []:admin@freelancehunt.local`


`sudo a2ensite freelancehunt.local.conf`

`sudo a2dissite 000-default.conf`

`sudo systemctl restart apache2`

3. Добавить домен в файл hosts

`sudo gedit /etc/hosts`

`127.0.1.1   freelancehunt.local`

4. Создать БД  

Выполнить комманду с дампом БД

`mysql -u (USER) -p (DataBase Name) < Projects.sql`

5. Настроить файл конфигурации (config.php) (поменять подключение к БД) 

`define('IRB_DBSERVER', 'localhost');`

`define('IRB_DBUSER', '');`

`define('IRB_DBPASSWORD', '');`

`define('IRB_DATABASE', '');`

`define('API_TOKEN', '');`


6. Проверка работы 

6.1 Запустив сайт в браузере https://freelancehunt.local увидите таблицу импортированых проектов на момент написания задания
   
    http://i.imgur.com/lQfrbbs.png
    
6.2 Чтобы обновить данные необходимо запустить ссылку https://freelancehunt.local/cron, дождаться окончания работы скрипта

6.3 Чтобы отобразить чарт с распределением проектов по бюджету необходимо запустить ссылку https://freelancehunt.local/chart
    