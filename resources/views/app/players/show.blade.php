@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('players.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.players.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.players.inputs.team_id')</h5>
                    <span>{{ optional($player->team)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.players.inputs.firstName')</h5>
                    <span>{{ $player->firstName ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.players.inputs.lastName')</h5>
                    <span>{{ $player->lastName ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.players.inputs.playerImageURI')</h5>
                    @if($player->playerImageURI)
                    <a
                        href="{{ \Storage::url($player->playerImageURI) }}"
                        target="blank"
                        ><i class="icon ion-md-download"></i>&nbsp;Download</a
                    >
                    @else - @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('players.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Player::class)
                <a href="{{ route('players.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
