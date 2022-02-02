<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Player;
use App\Repositories\PlayerRepository;
use App\Repositories\TeamRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PlayerCollection;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;

class PlayerController extends Controller
{
    use UploadFileTrait;

    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return PlayerCollection|\JsonResponse
     */
    public function index()
    {
        try {
            $players = $this->playerRepository->all();

            return new PlayerCollection($players);
        } catch (\Throwable $throwable) {
            logError('Error while getting players', 'Api\V1\PlayerController@index', $throwable);
            return simpleMessageResponse('Server Error', INTERNAL_SERVER);
        }

    }

    /**
     * @param \App\Http\Requests\PlayerStoreRequest $request
     * @return PlayerResource|\JsonResponse
     */
    public function store(PlayerStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

            $player = $this->playerRepository->create($validated);

            return new PlayerResource($player);
        } catch (\Throwable $throwable) {
            logError('Error while creating player', 'Api\V1\PlayerController@store', $throwable);
            return simpleMessageResponse('Server Error', INTERNAL_SERVER);
        }
    }

    /**
     * @param $playerId
     * @return PlayerResource|\JsonResponse
     */
    public function show($playerId)
    {
        try {
            $player = $this->playerRepository->get($playerId);
            return new PlayerResource($player);
        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Player not found', NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while getting player details', 'Api\V1\PlayerController@show', $throwable);
            return simpleMessageResponse('Player not found!', INTERNAL_SERVER);
        }
    }

    /**
     * @param \App\Http\Requests\PlayerUpdateRequest $request
     * @param \App\Models\Player $player
     * @return PlayerResource|\JsonResponse
     */
    public function update(PlayerUpdateRequest $request, Player $player)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

            $player = $this->playerRepository->update($validated);

            DB::commit();
            return new PlayerResource($player);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            logError('Error while updating player details', 'Api\V1\PlayerController@update', $throwable);
            return simpleMessageResponse('Server Error', INTERNAL_SERVER);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Player $player
     * @return \JsonResponse
     */
    public function destroy(Request $request, Player $player)
    {
        try {
            if ($player->playerImageURI) {
                Storage::delete($player->playerImageURI);
            }

            $this->playerRepository->delete($player->id);

            return simpleMessageResponse('Player deleted successfully');
        } catch (\Throwable $throwable) {
            DB::rollBack();
            logError('Error while deleting player', 'Api\V1\PlayerController@delete', $throwable);
            return simpleMessageResponse('Server Error', INTERNAL_SERVER);
        }
    }
}
