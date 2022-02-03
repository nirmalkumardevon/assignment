<?php

namespace App\Repositories;

use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{

    public function __construct(Player $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getTeamPlayers($teamId)
    {
        return $this->model->whereTeamId($teamId)->get();
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function create(array $details)
    {
        return $this->model->create($details);
    }

    public function update($teamId, array $details)
    {
        return $this->model->whereId($teamId)->update($details);
    }
}
