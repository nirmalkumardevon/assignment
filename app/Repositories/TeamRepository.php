<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Expr\Array_;

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
     * @return array
     */
    public function all(): array
    {
        return $this->team->all()->toArray();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function get($id)
    {
        return $this->team->findOrFail($id);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        return $this->team->whereId($id)->delete();
    }

    /**
     * @param array $validated
     * @return JsonResponse
     */
    public function create(array $validated)
    {
        return $this->team->create($validated);
    }

    /**
     * @param $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update($id, array $validated)
    {
        return $this->team->whereId($id)->update($validated);
    }

}
