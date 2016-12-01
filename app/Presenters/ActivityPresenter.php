<?php

namespace Someline\Presenters;

use Someline\Transformers\ActivityTransformer;

/**
 * Class ActivityPresenter
 *
 * @package namespace Someline\Presenters;
 */
class ActivityPresenter extends BasePresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ActivityTransformer();
    }
}
