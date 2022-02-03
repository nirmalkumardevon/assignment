<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    /**
     * @param Team $model
     */
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
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
        return $this->model->whereId($id)->delete();
    }

    /**
     * @param array $validated
     * @return mixed
     */
    public function create(array $validated)
    {
        return $this->model->create($validated);
    }

    /**
     * @param $id
     * @param array $validated
     * @return mixed
     */
    public function update($id, array $validated)
    {
        return $this->model->whereId($id)->update($validated);
    }

}
