<?php

namespace Someline\Transformers;

use League\Fractal\TransformerAbstract;
use Someline\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace Someline\Transformers;
 */
class OrderTransformer extends BaseTransformer
{

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        
        return [
            'id'         => (int) $model->id,
            'title' => $model->title ,
            'price' => $model->price ,
            /* place your other model properties here */

            'created_at' => (string)$model->created_at,
            'updated_at' => (string)$model->updated_at,
        ];
    }
}
