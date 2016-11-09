<?php

namespace Someline\Presenters;

use Someline\Transformers\PayTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GamePayPresenter
 *
 * @package namespace App\Presenters;
 */
class PayPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PayTransformer();
    }
}
