<?php

namespace Someline\Transformers;

use League\Fractal\TransformerAbstract;
use Someline\Models\Publication;

/**
 * Class PublicationTransformer
 * @package namespace App\Transformers;
 */
class PublicationTransformer extends TransformerAbstract
{

    /**
     * Transform the \Publication entity
     * @param \Publication $model
     *
     * @return array
     */
    public function transform(Publication $model)
    {
        return [
            'id' => (int)$model->id,
            'min_version' => version_to_int($model->min_version),
            'max_version' => version_to_int($model->max_version),
            'uuids' => json_decode($model->uuids ?: '[]', true),
            'publication_message' => trim($model->publication_message),
            'online_config' => json_decode($model->online_config),
            'server_list' => json_decode($model->server_list),
            'hot_upgrade' => json_decode($model->hot_upgrade),
            'created_at' => (string)$model->created_at,
            'updated_at' => (string)$model->updated_at,
        ];
    }
}
