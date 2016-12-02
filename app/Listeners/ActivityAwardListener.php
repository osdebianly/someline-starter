<?php

namespace Someline\Listeners;

use Someline\Events\ActivityAward;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Someline\Models\ActivityLog;

class ActivityAwardListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActivityAward $event
     * @return void
     */
    public function handle(ActivityAward $event)
    {
        $data = $event->data;
        $data['number'] = config('game-server.activity.good_reputation', 0);
        $data['type'] = 'good_reputation';
        $data['note'] = '好评送礼,只限一份';
        \Log::debug('队列通知服务端' . var_export($data, true));

        ActivityLog::create($data);


    }
}
