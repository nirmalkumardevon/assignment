<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Models\Player;
use App\Models\Team;
use App\Repositories\PlayerRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
     * @return View
     */
    public function index()
    {

        $players = Player::latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.players.index', compact('players'));
    }

    /**
     * @return Application|View
     */
    public function create()
    {
        $teams = Team::pluck('name', 'id');
        return view('app.players.create', compact('teams'));
    }


    /**
     * @param PlayerStoreRequest $request
     * @return mixed
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
     * @param Player $player
     * @return Application|View
     */
    public function show(Player $player)
    {
        return view('app.players.show', compact('player'));
    }


    /**
     * @param Player $player
     * @return Application|View
     */
    public function edit(Player $player)
    {
        $teams = Team::pluck('name', 'id');
        return view('app.players.edit', compact('player', 'teams'));
    }


    /**
     * @param PlayerUpdateRequest $request
     * @param Player $player
     * @return mixed
     */
    public function update(PlayerUpdateRequest $request, Player $player)
    {
        $validated = $request->validated();
        $validated['playerImageURI'] = $this->storeUploadedFile($request, 'playerImageURI');

        $player = $this->playerRepository->update($player->id, $validated);

        return redirect()
            ->route('players.edit', $player)
            ->withSuccess(__('crud.common.saved'));
    }


    /**
     * @param $playerId
     * @return mixed
     */
    public function destroy($playerId)
    {

        $this->playerRepository->delete($playerId);

        return redirect()
            ->route('players.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
