<?php

namespace Someline\Api\Controllers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Omnipay;
use Someline\Events\OrderPaid;
use lyfing\pay\ApplePay;
use Illuminate\Http\Request;

use Someline\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Someline\Http\Requests\OrderCreateRequest;
use Someline\Http\Requests\OrderUpdateRequest;
use Someline\Models\Order;
use Someline\Repositories\Interfaces\OrderRepository;
use Someline\Validators\OrderValidator;


class OrdersController extends BaseController
{

    /**
     * @var OrderRepository
     */
    protected $repository;

    /**
     * @var OrderValidator
     */
    protected $validator;

    public function __construct(OrderRepository $repository, OrderValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        return  $this->repository->all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderCreateRequest $request
     *
     * @return mixed
     * @throws ResourceException
     * @throws ValidatorException
     */
    public function store(OrderCreateRequest $request)
    {

        $sanbox = (int)$request->sanbox;
        $data = $request->only(['title', 'price', 'note', 'pay_type']);
        //生成支付宝
        if (empty($data['pay_type'])) {
            $type = $data['pay_type'] = 'alipay_app';
        } else {
            $type = trim($data['pay_type']);
        }

        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

        $order = $this->repository->create($data);

        if ($type == 'no_pay') {
            $order['data']['notify_url'] = url('api/orders/verify/' . $type);
            return $order ;
        }

        if ($type == 'applepay') {
            $order['data']['verify_url'] = url('api/orders/verify-apple/' . $sanbox);
            return $order;
        }

        $gateway = Omnipay::gateway($type);

        //支付宝支付参数不一样需要分开判断
        $request = null;
        switch ($type) {
            case 'alipay':
            case 'alipay_app':
                $request = $gateway->purchase();
                $request->setBizContent([
                    'out_trade_no' => hashid_encode($order['data']['id']),
                    'total_amount' => $order['data']['price'],
                    'subject' => '游戏充值',
                    'product_code' => 'QUICK_MSECURITY_PAY',
                ]);
                break;
            case 'wechatpay':
            case 'wechatpay_app':
                $request = $gateway->purchase([
                    'body' => '游戏充值',
                    'out_trade_no' => hashid_encode($order['data']['id']),
                    'total_fee' => $order['data']['price'], //=0.01
                    'spbill_create_ip' => smart_get_client_ip(),
                    'fee_type' => 'CNY'
                ]);
                break;
        }

        $response = $request->send();
        $method = config('laravel-omnipay.gateways.' . $type . '.method');
        $reflection = new \ReflectionClass($response);
        if (!$reflection->hasMethod($method)) {
            throw new ResourceException('支付方法未设置请检查 laravel-omnipay.gateways');
        }
        $result = $response->$method();

        $order['data']['pay_data'] = $result;

        //触发未支付订单事件
        //event(new OrderNotPay($user));

        //return $this->response->noContent();
        return $order ;

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->repository->find($id);
        return $order ;
        //$json = json_encode($order) ;
        //return $json ;

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $order = $this->repository->find($id);

        return view('orders.edit', compact('order'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  OrderUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(OrderUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $order = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'Order updated.',
                'data' => $order->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Order deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Order deleted.');
    }

    /**
     * 支付成功后回调验证订单
     * 1, 检查状态(处理多次通知的情况)
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $type = 'alipay_app')
    {

        $gateway = Omnipay::gateway($type);

        //支付宝支付参数不一样需要分开判断
        $request = null;
        switch ($type) {
            case 'alipay':
            case 'alipay_app':
                $request = $gateway->completePurchase();
                $request->setParams($_POST);//Optional
                break;
            case 'wechatpay':
            case 'wechatpay_app':
                $request = $gateway->completePurchase([
                    'request_params' => file_get_contents('php://input')
                ]);
                break;
        }

        try {

            $response = $request->send();
            if ($response->isPaid()) {
        //触发未支付订单事件
        //event(new OrderNotPay($user));
        /**
         * Payment is successful
         */
        //$data = $response->getData() ;

        //TODO 队列发送通知到服务端充了一笔钱,金额为 xx
        $data = $_POST;
        event(new OrderPaid($data));

            } else {
                /**
                 * Payment is not successful
                 */
                die('fail');
            }

        } catch (\Exception $e) {

            die('fail');
        }
        //The response should be 'success' only
        die('success');
    }


    public function verifyApplePay(Request $request, $sanbox = 0)
    {

        $receipt = $request->receipt;
        $orderID = $request->order_id;

        $applePay = new ApplePay($receipt, $sanbox);
        $payData = $applePay->verify();
        //$price = $payData['receipt']['in_app'][0]['product_id'] ; //商品价格

        $data['out_trade_no'] = $orderID;
        if ($payData['status'] == 0) {
            event(new OrderPaid($data));
        }
        // $data['receipt']['in_app'][0]['transaction_id']  苹果订单号
        return ['message' => '支付成功'];
    }

}
