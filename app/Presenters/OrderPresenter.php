<?php

namespace Someline\Presenters;

use Someline\Transformers\OrderTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrderPresenter
 *
 * @package namespace Someline\Presenters;
 */
class OrderPresenter extends BasePresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderTransformer();
    }
}
