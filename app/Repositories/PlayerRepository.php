<?php

namespace App\Repositories;

use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->player->all()->toArray();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function get($id)
    {
        return $this->player->findOrFail($id);
    }

    /**
     * @param $teamId
     * @return JsonResponse
     */
    public function getTeamPlayers($teamId)
    {
        return $this->player->whereTeamId($teamId)->get();
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->player->delete($id);
    }

    /**
     * @param array $details
     * @return JsonResponse
     */
    public function create(array $details)
    {
        return $this->player->create($details);
    }

    /**
     * @param $playerId
     * @param array $details
     * @return JsonResponse
     */
    public function update($playerId, array $details)
    {
        return $this->player->whereId($playerId)->update($details);
    }
}
