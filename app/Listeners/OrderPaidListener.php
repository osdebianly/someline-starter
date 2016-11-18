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
use Someline\Jobs\PostDateToGameServer;


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
                /**
                 * 仅充值
                 */
                if (empty($order->notify_url) && $order->once_pay == 0) {
                    $user->wealth += $order->price * 100;  //1 元 100 平台积分
                    $user->save();
                }
                $order->save();
            });
        }

        /**
         * 一次性消费
         */
        /**
        $postData['user_id'] = $order->user_id;
        $postData['event'] = 'buy';
        $postData['timestamp'] = time();
        $postData['sign'] = md5($postData['event'] . $postData['timestamp'] . $postData['user_id']);
        $postData['data'] = [
            'note' => $order->note,
            'order_id' => $order->id,
            'order_price' => $order->price
        ];*/
        $isFirstPay = Order::where('user_id', $order->user_id)->count();

        $postData['appid'] = (int)$order->client_id;
        $postData['event'] = [
            "TYPE" => "EVENT_PAY_ORDER_CONFIRM",
            "Data" => [
                "OrderID" => (string)$order->id,
                "UserID" => (string)$order->user_id,
                "AppID" => (string)$order->client_id,
                "CurrencyType" => "CNY",
                "CurrencyAmount" => (string)$order->price,
                "SubmitTime" => (string)$order->update_at,
                "AccountStatus" => (string)$user->status,
                "isFirstPay" => $isFirstPay > 0 ? false : true,
            ]
        ];
        $postData['serverid'] = isset($postInfo['server_id']) ? (int)$postInfo['server_id'] : 1;
        $postData['ts'] = time();
        $postData['sign'] = md5($postData['appid'] . $postData['ts']);

        /**
         * 队列发送通知到服务端
         */
        $notifyUrls = empty($order->notify_url) ? config('game-server.payNotifyServerList') : $order->notify_url;

        dispatch(new PostDateToGameServer($postData, $notifyUrls));


        //dispatch(new OrderPaidNotify($user, $order));


        //发送通知
//        Notifynder::category('user.paid')
//            ->from($order->user_id)
//            ->to($order->user_id)
//            ->url('http://localhost')
//            ->send();
    }
}
