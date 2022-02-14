<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if(($item['route'] ?? null) == 'admin.telegram' &&  (!config('telegram.bots.notifications.chat_id') || !config('telegram.bots.notifications.token'))) {
            $item['restricted'] = true;
        }
        return $item;
    }
}
