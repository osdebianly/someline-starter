<?php

namespace Someline\Repositories\Eloquent;

use Prettus\Repository\Criteria\RequestCriteria;
use Someline\Repositories\Interfaces\PayRepository;
use Someline\Models\Foundation\Pay;
use Someline\Validators\PayValidator;
use Someline\Presenters\PayPresenter;


/**
 * Class GamePayRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PayRepositoryEloquent extends BaseRepository implements PayRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pay::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return PayValidator::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return PayPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
