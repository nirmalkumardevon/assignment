<?php

namespace App\Interfaces;


use Illuminate\Http\JsonResponse;

interface PlayerRepositoryInterface
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param int $playerId
     * @return JsonResponse
     */
    public function get(int $playerId);

    /**
     * @param int $teamId
     * @return JsonResponse
     */
    public function getTeamPlayers(int $teamId);

    /**
     * @param int $playerId
     * @return bool
     */
    public function delete(int $playerId);

    /**
     * @param array $playerDetails
     * @return JsonResponse
     */
    public function create(array $playerDetails);

    /**
     * @param $playerId
     * @param array $playerDetails
     * @return JsonResponse
     */
    public function update($playerId, array $playerDetails);
}
