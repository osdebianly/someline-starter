<?php

namespace Someline\Listeners;

use DB ;
use Someline\Events\OrderPaid;
use Someline\Jobs\OrderPaidNotify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Notifynder;
use Someline\Models\Order ;
use Someline\Models\Foundation\User;

class OrderPaidListener
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
     * @param  OrderPaid $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        $data = $event->data;
        /**
         * 解密订单ID ,这里防止用户遍历,伪造微信通知
         */
        $orderId = hashid_decode($data['out_trade_no']);
        $order = Order::find($orderId);
        $user = User::find($order->user_id);

        if ($order->state != config("order.complete")) {
            /**
             * 事务处理金币和状态更新
             */
            DB::beginTransaction(function () use ($order,$user){
                $order->state = config("order.complete");
                $user->wealth += $order->price * 100;  //1 元 100 平台积分
                $user->save();
                $order->save();
            });

            
        }

        /**
         * 队列发送通知到服务端
         */


        dispatch(new OrderPaidNotify($user, $order));


        //发送通知
//        Notifynder::category('user.paid')
//            ->from($order->user_id)
//            ->to($order->user_id)
//            ->url('http://localhost')
//            ->send();
    }
}
