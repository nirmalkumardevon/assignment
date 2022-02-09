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
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    use UploadFileTrait;

    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @return array|JsonResponse
     */
    public function getPlayersList()
    {
        try {
            return $this->playerRepository->all();
        } catch (\Throwable $throwable) {
            logError('Error while getting players', 'Api\V1\PlayerController@index', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $playerId
     * @return JsonResponse
     */
    public function getPlayerDetails($playerId)
    {
        try {
            return $this->playerRepository->get($playerId);
        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Player not found', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while getting player details', 'Api\V1\PlayerController@getPlayerDetails', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param PlayerUpdateRequest $request
     * @param Player $player
     * @return JsonResponse
     */
    public function updatePlayer(PlayerUpdateRequest $request, Player $player)
    {
        try {
            $validated = $request->validated();
            $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

            return $this->playerRepository->update($player->id, $validated);
        } catch (\Throwable $throwable) {
            logError('Error while updating player details', 'Api\V1\PlayerController@update', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @param Player $player
     * @return JsonResponse
     */
    public function deletePlayer(Player $player)
    {
        try {
            $this->playerRepository->get($player->id);
            $this->playerRepository->delete($player->id);

            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Player not found', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while deleting player', 'Api\V1\PlayerController@destroy', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
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
        } catch (\Throwable $throwable) {
            logError('Error while getting team players list', 'Api\V1\PlayerController@listTeamPlayers', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
