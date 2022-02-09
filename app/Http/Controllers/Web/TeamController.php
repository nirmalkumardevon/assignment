<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use App\Repositories\TeamRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use function __;
use function redirect;
use function view;

class TeamController extends Controller
{
    use UploadFileTrait;

    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }


    /**
     * @return View
     */
    public function index()
    {
        $teams = Team::latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.teams.index', compact('teams'));
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('app.teams.create');
    }


    /**
     * @param TeamStoreRequest $request
     * @return mixed
     */
    public function store(TeamStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['logoURI'] = $this->storeUploadedFile($request, 'logoURI');

        $team = $this->teamRepository->create($validated);

        return redirect()
            ->route('teams.edit', $team)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param Team $team
     * @return Application|View
     */
    public function show(Team $team)
    {
        return view('app.teams.show', compact('team'));
    }

    /**
     * @param Team $team
     * @return Application|View
     */
    public function edit(Team $team)
    {
        return view('app.teams.edit', compact('team'));
    }

    /**
     * @param TeamUpdateRequest $request
     * @param Team $team
     * @return mixed
     */
    public function update(TeamUpdateRequest $request, Team $team)
    {
        $validated = $request->validated();
        $validated['logoURI'] = $this->storeUploadedFile($request, 'logoURI');

        $team = $this->teamRepository->update($team->id, $validated);

        return redirect()
            ->route('teams.index', $team)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param Team $team
     * @return mixed
     */
    public function destroy(Team $team)
    {
        $this->teamRepository->delete($team->id);

        return redirect()
            ->route('teams.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
