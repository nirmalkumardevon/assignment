<?php

namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

interface PlayerRepositoryInterface
{
    public function all();
    public function get($teamId);
    public function getTeamPlayers($teamId);
    public function delete($teamId);
    public function create(array $teamDetails);
    public function update($orderId, array $teamDetails);
}
