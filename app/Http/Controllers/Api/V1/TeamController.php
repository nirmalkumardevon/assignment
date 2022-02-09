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
use Illuminate\Http\Response;

class TeamController extends Controller
{
    use UploadFileTrait;

    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @return array|JsonResponse
     */
    public function getTeamsList()
    {
        try {
            return $this->teamRepository->all();
        } catch (\Throwable $throwable) {
            logError('Error while getting teams list', 'Api\V1\TeamController@getTeamsList', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
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

           return $this->teamRepository->create($validated);
        } catch (\Throwable $throwable) {
            logError('Error while creating a team', 'Api\V1\TeamController@store', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getTeamDetails(int $id)
    {
        try {
            return $this->teamRepository->get($id);
        } catch (ModelNotFoundException $e) {
            return simpleMessageResponse('Team not found', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while getting team details', 'Api\V1\TeamController@getTeamDetails', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            logError('Error while updating the team', 'Api\V1\TeamController@update', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return simpleMessageResponse('Team not found', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            logError('Error while deleting a team', 'Api\V1\TeamController@destroy', $throwable);
            return simpleMessageResponse(MESSAGE_INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
