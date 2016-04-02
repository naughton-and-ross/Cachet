<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Console;

use CachetHQ\Cachet\Console\Commands\DemoMetricPointSeederCommand;
use CachetHQ\Cachet\Console\Commands\DemoSeederCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use GuzzleHttp\Client;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DemoMetricPointSeederCommand::class,
        DemoSeederCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            function pingDomain($domain)
            {
                $starttime = microtime(true);
                $file      = @fsockopen($domain, 80, $errno, $errstr, 10);
                $stoptime  = microtime(true);
                $status    = 0;

                if (!$file){
                    $status = -1;
                }
                else{
                    fclose($file);
                    $status = ($stoptime - $starttime) * 1000;
                    $status = floor($status);
                }
                return $status;
            }

            $time = pingDomain('ca.n-r.co');
            $client = new Client();
            $client->post('https://status.n-r.co/api/v1/metrics/1/points', [
               'headers' => [
                   'X-Cachet-Token' => env('CACHET_TOKEN')
               ],
                'form-data' => [
                    'value' => $time,
                ]
            ]);
        })->everyMinute();
    }
}
