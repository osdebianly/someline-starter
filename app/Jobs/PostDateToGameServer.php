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
    public $notifyUrls;

    /**
     * Create a new job instance.
     *
     * @param mixed $data
     * @param mixed $notifyUrls
     */
    public function __construct($data, $notifyUrls)
    {
        $this->data = $data;
        $this->notifyUrls = $notifyUrls;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Client $client)
    {
        $notifyUrls = is_array($this->notifyUrls) ? $this->notifyUrls : [$this->notifyUrls];
        foreach ($notifyUrls as $notifiyUrl) {
            \Log::info(date('y-m-d H:i:s') . "开始通知服务器:" . $notifiyUrl . '内容' . print_r($this->data, true) . "\n");
            //$client->request('POST', $notifiyUrl, ['json' => $this->data]);
        }
    }
}
