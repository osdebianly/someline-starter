<?php

namespace Someline\Jobs;

use Someline\Jobs\Job;
use Someline\Models\Foundation\User;
use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Someline\Models\Order ;

class OrderPaidNotify extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;


    protected $user;
    protected $order;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Order $order
     */
    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     */
    public function handle(Client $client)
    {
        //$client = new \GuzzleHttp\Client();
        $orderServerList = config('game-server.payNotifyServerList');

        foreach ($orderServerList as $notifiyUrl) {
            echo "开始通知服务器:" . $notifiyUrl . '->user_id:' . $this->user->getUserId() . "\n";
            $client->request('POST', $notifiyUrl, ['json' => [
                'user_id' => $this->user->getUserId(),
                'total_wealth' => $this->user->wealth,
            ]]);
        }
    }
}
