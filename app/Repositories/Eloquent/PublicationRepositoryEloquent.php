<?php

namespace Someline\Repositories\Eloquent;

//use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Someline\Presenters\PublicationPresenter;
use Someline\Repositories\Interfaces\PublicationRepository;
use Someline\Models\Publication;
use Someline\Validators\PublicationValidator;

/**
 * Class PublicationRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PublicationRepositoryEloquent extends BaseRepository implements PublicationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Publication::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return PublicationValidator::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return PublicationPresenter::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
