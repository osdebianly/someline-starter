<?php

namespace Someline\Transformers;

use Someline\Models\Activity;

/**
 * Class UserTransformer
 * @package namespace Someline\Transformers;
 */
class ActivityTransformer extends BaseTransformer
{

    /**
     * Transform the User entity
     * @param User $model
     *
     * @return array
     */
    public function transform(Activity $model)
    {
        return [
            'id' => $model->id,

            /* place your other model properties here */
            'good_reputation' => $model->good_reputation,

            'created_at' => (string)$model->created_at,
            'updated_at' => (string)$model->updated_at
        ];
    }
}
