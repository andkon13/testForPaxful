structure:

    classes                    Base classes
        App.php              Appliation
        autoloader.php    autoloader
        config.php           config for app, Db and DI
    controllers                Controllrrs
    interfaces                 Interfases
    models                     Models classes
    repository                 Repositoryes for transport Entity to Db
    vendor                      composer pakage
    views                        Views
    www                         http document root
        app.php                endponit for http requests
        vendor              link to ../vendor for access to *.js and *.css bootstrap|jquery
        

requirements:
php >= 7.0, mysql >=5.6

        
installation:

git clone git@github.com:andkon13/testForPaxful.git
cd testForPaxful
composer install
(ln -s vendor ./www/vendor)
configure db in classes/config.php (i known this need relocation)


nginx config
server {
    listen 0.0.0.0:80; ## listen for ipv4
    server_name test.dev;
    root        {path_to_project}/www;
    index       app.php;

    location / {
        try_files $uri $uri/ /app.php?$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
        #fastcgi_pass   127.0.0.1:9000;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        try_files $uri =404;
    }

    location ~* ^.+\.(jpg|jpeg|gif|png|ico|css|pdf|ppt|txt|bmp|rtf|js|woff|ttf|odf)$ {
                root {path_to_project}/www;
                access_log      off;
                log_not_found   off;
                expires         12h;
                add_header Pragma public;
                add_header Cache-Control "public, must-revalidate";
    }

    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
