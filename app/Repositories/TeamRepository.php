<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    private $team;

    /**
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->team->all();
    }

    /**
     * @param $id
     * @return Model
     */
    public function get($id)
    {
        return $this->team->findOrFail($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->team->whereId($id)->delete();
    }

    /**
     * @param array $validated
     * @return mixed
     */
    public function create(array $validated)
    {
        return $this->team->create($validated);
    }

    /**
     * @param $id
     * @param array $validated
     * @return mixed
     */
    public function update($id, array $validated)
    {
        return $this->team->whereId($id)->update($validated);
    }

}
