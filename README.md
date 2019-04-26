
# College

**The project developed using framework Yii 2 Advanced Project Template.**

## DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

## REQUIREMENTS
------------

* PHP 7
* PostgreSQL 9.6

## INSTALLATION
------------

* Clone project <br/>
    `git clone git@git.vpn:username/college.git`
* Move to project folder <br/>
    `cd ./college`
* Install composer requirements <br/>
    `composer install`
* Install project <br/>
    `php ./init --env=Development --overwrite=All`
* Create database
* Setup database configurations in `common/config/main-local.php`
    ```
    'db' => [
         'class' => 'yii\db\Connection',
         'dsn' => 'pgsql:host=localhost;dbname=college',
         'username' => 'postgres',
         'password' => 'postgres',
         'charset' => 'utf8',
    ],
    ```

* Run migrations <br/>
    `php ./yii migrate --interactive=0`
* Setup local parameters in `common/config/params-local.php`
    ```
    return [
        'pds_access_token' => 'access_token',
        'pds_url' => 'http://api.pds.loc/',
        'session_timeout' => 3600 * 24 * 7,
        'bilimal_notifications_access_token' => 'change_real_access_token'
    ];
    ```
* Setup nginx to run frontend
    ```
    server {
        charset utf-8;
        client_max_body_size 128M;
    
        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
    
        server_name mysite.test;
        root        /path/to/frontend/web;
        index       index.php;
    
        access_log  /path/to/basic/log/access.log;
        error_log   /path/to/basic/log/error.log;
    
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
    
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;
    
        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }
    
        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
    
        location ~* /\. {
            deny all;
        }
    }
    ```

## Environment for the test - Beta server

**Address:** 

    host: https://beta.citorleu.kz

**PDS service:**

    https://pds.citorleu.kz/

**Server:**

    ssh:  tickets.vpn
    user: admin

**PostgreSQL:**

    host internal: preview -> useful for code
    host external: 192.168.2.220
    database:      db_beta_college
    username:      betabilimal
    password:      B1t3fahrenvu

**Logs:**

    access_log: /var/log/nginx/beta.fs-access.log
    error_log:  /var/log/nginx/beta.fs-error.log

## Environment for the production

**Address:** 

    host: https://college.bilimal.kz
    host api: https://college.bilimal.kz/api/
    administration interface:  http://admin.college.vpn/

**NOTICE:**

* /api/ route is required to route requests.
* /api/ route is not transmitted to the code.
* If your internal routes match, you must write /api/api/, then the code will get the route one time.

**Code:**

    branch: production - only merge requests

**PDS service:**

    https://pds.cit-orleu.kz/

**NOTICE:**

* Used certificate from pki.gov.kz.
* It is necessary to disable certificate authentication in code.

**Prepare environment:**

    php ./init --env=Production --overwrite=All

**Server:**

    Jails: asu

**PostgreSQL:**

    host:          pg3.vpn
    database:      db_college_general
    username:      bilimal
    password:      p97356y20734f

**NOTICE:**

* All database servers use replicas for work.
* All write operations go to the masters.
* All read operations go to secondary replica members.
* The code must implement a check on the availability of secondary replica members.

Replica addresses:

    standby.<MASTER.HOST>

Example:

    standby.pg3.vpn

**Cache:**

    General cache:       redis.vpn
    Authorization cache: session.vpn




------------
