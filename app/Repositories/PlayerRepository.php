<?php

namespace App\Repositories;

use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{

    public function __construct(Player $model)
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
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $teamId
     * @return mixed
     */
    public function getTeamPlayers($teamId)
    {
        return $this->model->whereTeamId($teamId)->get();
    }

    /**
     * @param $id
     * @return bool|int|null
     */
    public function delete($id)
    {
        return $this->model->delete($id);
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
     * @param $teamId
     * @param array $details
     * @return mixed
     */
    public function update($teamId, array $details)
    {
        return $this->model->whereId($teamId)->update($details);
    }
}
