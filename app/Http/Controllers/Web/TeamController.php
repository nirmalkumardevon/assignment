<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use App\Repositories\TeamRepository;
use App\Traits\UploadFileTrait;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = Team::latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.teams.index', compact('teams'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.teams.create');
    }

    /**
     * @param \App\Http\Requests\TeamStoreRequest $request
     * @return \Illuminate\Http\Response
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Team $team)
    {

        return view('app.teams.show', compact('team'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Team $team)
    {

        return view('app.teams.edit', compact('team'));
    }

    /**
     * @param \App\Http\Requests\TeamUpdateRequest $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamUpdateRequest $request, Team $team)
    {

        $validated = $request->validated();
        $validated['logoURI'] = $this->storeUploadedFile($request, 'logoURI');

        $team = $this->teamRepository->update($validated);

        return redirect()
            ->route('teams.index', $team)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Team $team)
    {
        $this->teamRepository->delete($team->id);

        return redirect()
            ->route('teams.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
