<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface TeamRepositoryInterface
{
    /**
     * @return array
     */
    public function all();

    /**
     * @param int $teamId
     * @return JsonResponse
     */
    public function get(int $teamId);

    /**
     * @param int $teamId
     * @return JsonResponse
     */
    public function delete(int $teamId);

    /**
     * @param array $teamDetails
     * @return JsonResponse
     */
    public function create(array $teamDetails);

    /**
     * @param int $teamId
     * @param array $teamDetails
     * @return JsonResponse
     */
    public function update(int $teamId, array $teamDetails);
}
