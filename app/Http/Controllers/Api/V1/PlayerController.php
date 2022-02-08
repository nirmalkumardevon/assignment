<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Models\Player;
use App\Repositories\PlayerRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    use UploadFileTrait;

    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }


    /**
     * @return Collection
     */
    public function index()
    {
        try {
            return $this->playerRepository->all();

        } catch (\Throwable $throwable) {
            logError('Error while getting players', 'Api\V1\PlayerController@index', $throwable);
            return simpleMessageResponse('Server Error', INTERNAL_SERVER);
        }

    }

    /**
     * @param PlayerStoreRequest $request
     * @return JsonResponse
     */
    public function store(PlayerStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

            return $this->playerRepository->create($validated);
        } catch (\Throwable $throwable) {
            logError('Error while creating player', 'Api\V1\PlayerController@store', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }


    /**
     * @param $playerId
     * @return JsonResponse
     */
    public function show($playerId)
    {
        try {
            return $this->playerRepository->get($playerId);

        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Player not found', NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while getting player details', 'Api\V1\PlayerController@show', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }


    /**
     * @param PlayerUpdateRequest $request
     * @param Player $player
     * @return JsonResponse
     */
    public function update(PlayerUpdateRequest $request, Player $player)
    {
        try {
            $validated = $request->validated();
            $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

            return $this->playerRepository->update($validated);

        } catch (\Throwable $throwable) {
            logError('Error while updating player details', 'Api\V1\PlayerController@update', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }

    /**
     * @param Request $request
     * @param Player $player
     */
    public function destroy(Request $request, Player $player)
    {
        try {
            $this->playerRepository->get($player->id);
            $this->playerRepository->delete($player->id);

            return response()->noContent();
        } catch (\Throwable $throwable) {
            logError('Error while deleting player', 'Api\V1\PlayerController@delete', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }


    /**
     * @param $teamId
     * @return JsonResponse
     */
    public function listTeamPlayers($teamId)
    {
        try {
            return $this->playerRepository->getTeamPlayers($teamId);
        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Player not found', NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while getting player details', 'Api\V1\PlayerController@show', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }
}
