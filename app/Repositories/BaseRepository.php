<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param array $details
     * @return mixed
     */
    public function create(array $details)
    {
        return $this->model->create($details);
    }

    /**
     * @param $id
     * @param array $details
     * @return mixed
     */
    public function update($id, array $details)
    {
        return $this->model->whereId($id)->update($details);
    }
}
