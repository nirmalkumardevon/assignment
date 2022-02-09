<?php

namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

interface PlayerRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $teamId
     * @return mixed
     */
    public function get($teamId);

    /**
     * @param $teamId
     * @return mixed
     */
    public function getTeamPlayers($teamId);

    /**
     * @param $teamId
     * @return mixed
     */
    public function delete($teamId);

    /**
     * @param array $teamDetails
     * @return mixed
     */
    public function create(array $teamDetails);

    /**
     * @param $orderId
     * @param array $teamDetails
     * @return mixed
     */
    public function update($orderId, array $teamDetails);
}
