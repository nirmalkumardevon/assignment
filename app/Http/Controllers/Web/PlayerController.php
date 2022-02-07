<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Models\Player;
use App\Models\Team;
use App\Repositories\PlayerRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use function __;
use function redirect;
use function view;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $players = Player::latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.players.index', compact('players'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $teams = Team::pluck('name', 'id');

        return view('app.players.create', compact('teams'));
    }

    /**
     * @param \App\Http\Requests\PlayerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerStoreRequest $request)
    {

        $validated = $request->validated();
        $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

        $player = $this->playerRepository->create($validated);

        return redirect()
            ->route('players.edit', $player)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Player $player
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Player $player)
    {

        return view('app.players.show', compact('player'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Player $player)
    {

        $teams = Team::pluck('name', 'id');

        return view('app.players.edit', compact('player', 'teams'));
    }

    /**
     * @param \App\Http\Requests\PlayerUpdateRequest $request
     * @param \App\Models\Player $player
     * @return \Illuminate\Http\Response
     */
    public function update(PlayerUpdateRequest $request, Player $player)
    {

        $validated = $request->validated();
        $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

        $player = $this->playerRepository->update($validated);

        return redirect()
            ->route('players.edit', $player)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Player $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Player $player)
    {

        $this->playerRepository->delete($player);

        return redirect()
            ->route('players.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
