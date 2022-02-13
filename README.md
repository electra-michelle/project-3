
## Installation

`composer install --optimize-autoloader --no-dev`

`php artisan migrate`

`php artisan db:seed`
`php artisan storage:link`

`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`

#Check payment method status
`php artisan status:check`

## Queue installation
`sudo apt-get install supervisor`
```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/project/artisan queue:work --queue=high,default,low --tries=2
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/project/storage/logs/worker.log
stopwaitsecs=3600
```

`sudo supervisorctl reread`

`sudo supervisorctl update`

`sudo supervisorctl start laravel-worker:*`
