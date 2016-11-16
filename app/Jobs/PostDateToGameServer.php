<?php

namespace Someline\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;


class PostDateToGameServer implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Client $client)
    {
        $serverList = config('game-server.payNotifyServerList');

        foreach ($serverList as $notifiyUrl) {
            \Log::info(date('y-m-d H:i:s') . "开始通知服务器:" . $notifiyUrl . '内容' . print_r($this->data, true) . "\n");
            $client->request('POST', $notifiyUrl, ['json' => $this->data]);
        }
    }
}
