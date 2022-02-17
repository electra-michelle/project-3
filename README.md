
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


##Notification bot setup
1. Create new bot with BotFather and disable bots privacy mode
2. Fill `.env` config with `TELEGRAM_BOT_NOTIFICATIONS_TOKEN=` newly generated token
3. Fill `.env` config with `TELEGRAM_BOT_NOTIFICATIONS_WEBHOOK_URL=https://{domain}/api/telegram/setup`
4. run `php artisan telegram:webhook notifications --setup`
5. Add bot to group
6. Type something that starts with `'/'`
7. Find in logs chat id (starts with minus)
8. Delete webhook `php artisan telegram:webhook notifications --remove`

##Broadcast setup
1. `npm install -g laravel-echo-server`
2. `laravel-echo-server init`
3. `laravel-echo-server start`
4. 
```
[program:laravel-echo]
directory=/path/to/project/
process_name=%(program_name)s_%(process_num)02d
command=laravel-echo-server start
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/project/storage/logs/echo.log
```
5.`sudo supervisorctl reread`, `sudo supervisorctl update`, `sudo supervisorctl start laravel-echo:*`

## Adding paymentSystems
1. view `deposit/details.blade.php`
2. Confirm deposit Api/Command 
3. Confirm deposit Account/DepositController 
4. Payout command (cron)
5. Payouts in Admin\PayoutController (for custom payouts)
6. StatusCheck command
7. Services/PaymentSystemService.php
8. Seeder for PaymentSystem + PlanLimit
