
## Installation

`php artisan migrate`

`php artisan db:seed`

## Queue installation
`sudo apt-get install supervisor`

```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/project/artisan queue:work sqs --sleep=3 --tries=3 --max-time=3600
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
