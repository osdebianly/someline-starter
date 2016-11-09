<?php

namespace Someline\Transformers;

use League\Fractal\TransformerAbstract;
use Someline\Models\Foundation\Pay;

/**
 * Class PayTransformer
 * @package namespace App\Transformers;
 */
class PayTransformer extends TransformerAbstract
{

    /**
     * Transform the \GamePay entity
     * @param \Pay $model
     *
     * @return array
     */
    public function transform(Pay $model)
    {
        return [
            'pay_id' => (int)$model->id,
            'number' => $model->number,

            /* place your other model properties here */
            'state' => $model->state == 'init' ? '待支付' : '支付完成',
            'created_at' => (string)$model->created_at,
            //'updated_at' => $model->updated_at
        ];
    }
}
