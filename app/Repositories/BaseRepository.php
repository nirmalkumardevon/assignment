<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements TeamRepositoryInterface {
    /**
     * @var Model
     *
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function create(array $details)
    {
        return $this->model->create($details);
    }

    public function update($id, array $details)
    {
        return $this->model->whereId($id)->update($details);
    }
}
