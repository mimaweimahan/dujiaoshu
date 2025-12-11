<?php

namespace App\Admin\Repositories;

use App\Models\Lang as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Lang extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
