<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use App\Models\PaymentSystem;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches latest exchange rates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currencies = PaymentSystem::active()->get()->pluck('currency');

        $exchanges = [];
        foreach($currencies as $currencyFrom) {
            foreach($currencies as $currencyTo) {
                if(
                    $currencyFrom != $currencyTo &&
                    !in_array($currencyTo, ($exchanges[$currencyFrom] ?? []))
                ) {
                    $exchanges[$currencyFrom][] = $currencyTo;
                }
            }
        }

        $client = new Client();
        foreach($exchanges as $from => $to)
        {
            try {
                $response = $client->request('GET', 'https://min-api.cryptocompare.com/data/price', [
                    'query' => [
                        'fsym' => $from,
                        'tsyms' => implode(',', $to)
                    ]
                ]);
                $content = $response->getBody()->getContents();

                ExchangeRate::firstOrCreate(['from' => $from], ['rate' => $content]);

                $this->info('Exchange rates updated for ' . $from . ': ' . $content);
            } catch (\Exception $exception) {
                $this->info('Failed to update exchange rate from ' . $from . ' to ' . implode(',', $to));
            }

        }

    }
}
