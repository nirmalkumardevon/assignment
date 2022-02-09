<?php

namespace App\Repositories;

use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->player->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->player->findOrFail($id);
    }

    /**
     * @param $teamId
     * @return mixed
     */
    public function getTeamPlayers($teamId)
    {
        return $this->player->whereTeamId($teamId)->get();
    }

    /**
     * @param $id
     * @return bool|int|null
     */
    public function delete($id)
    {
        return $this->player->delete($id);
    }

    /**
     * @param array $details
     * @return mixed
     */
    public function create(array $details)
    {
        return $this->player->create($details);
    }

    /**
     * @param $teamId
     * @param array $details
     * @return mixed
     */
    public function update($teamId, array $details)
    {
        return $this->player->whereId($teamId)->update($details);
    }
}
