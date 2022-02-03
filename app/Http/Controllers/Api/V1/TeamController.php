<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Request;
use App\Http\Resources\TeamShowResource;
use App\Models\Team;
use App\Http\Resources\TeamResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamStoreRequest;
use App\Repositories\TeamRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TeamUpdateRequest;

class TeamController extends Controller
{
    use UploadFileTrait;

    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|\JsonResponse
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
     * @param \App\Http\Requests\TeamStoreRequest $request
     * @return TeamResource|\JsonResponse
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
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\JsonResponse|null
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
     * @param Request $request
     * @param $id
     * @return TeamResource|\JsonResponse
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
     * @param \App\Models\Team $team
     * @return \JsonResponse
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
