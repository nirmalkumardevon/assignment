<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @return Model
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
