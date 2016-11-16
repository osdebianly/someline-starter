<?php

namespace Someline\Presenters;

use Someline\Transformers\PublicationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PublicationPresenter
 *
 * @package namespace App\Presenters;
 */
class PublicationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PublicationTransformer();
    }
}