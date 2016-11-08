<?php

namespace Someline\Repositories\Eloquent;

use Someline\Presenters\OrderPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Someline\Repositories\Interfaces\OrderRepository;
use Someline\Models\Order;
use Someline\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace Someline\Repositories\Eloquent;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OrderValidator::class;
    }

    public function presenter()
    {
        return OrderPresenter::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
