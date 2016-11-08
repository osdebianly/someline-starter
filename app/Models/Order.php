<?php

namespace Someline\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['title', 'price', 'note', 'pay_type'];


    public function onCreating()
    {
        parent::onCreating();

        // auto set client id
        if ($this->autoUserId && empty($this->client_id)) {
            $this->client_id = auth_client_id();
        }
        
    }

    /**
     * 设置备注
     *
     * @param  string $value
     * @return string
     */
    public function setNoteAttribute($value)
    {
        $this->attributes['note'] = strtoupper($value);
    }


}
