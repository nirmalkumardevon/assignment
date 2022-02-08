<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use App\Repositories\TeamRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    use UploadFileTrait;

    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @return Collection
     */
    public function index()
    {
        try {
            return $this->teamRepository->all();

        } catch (\Throwable $throwable) {
            logError('Error while getting team list', 'Api\V1\TeamController@index', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }

    /**
     * @param TeamStoreRequest $request
     * @return JsonResponse
     */
    public function store(TeamStoreRequest $request)
    {
        try {
            $validated = $request->all();
            $validated['logoURI'] = $this->storeUploadedFile($request, 'logoURI');

           return $team = $this->teamRepository->create($validated);

        } catch (\Throwable $throwable) {
            logError('Error while creating a team', 'Api\V1\TeamController@store', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            return $this->teamRepository->get($id);

        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Team not found', NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while showing team', 'Api\V1\TeamController@show', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }


    /**
     * @param TeamUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(TeamUpdateRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $validated['logoURI'] = $this->storeUploadedFile($request, 'logoURI');

            return $this->teamRepository->update($id, $validated);
        } catch (\Throwable $throwable) {
            logError('Error while updating team', 'Api\V1\TeamController@update', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
            }
    }


    /**
     * @param Team $team
     */
    public function destroy(Team $team)
    {
        try {
            $this->teamRepository->get($team->id);
            $this->teamRepository->delete($team->id);

            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Team not found', NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while creating team', 'Api\V1\TeamController@store', $throwable);
            return simpleMessageResponse(INTERNAL_SERVER_ERROR, INTERNAL_SERVER);
        }
    }
}
