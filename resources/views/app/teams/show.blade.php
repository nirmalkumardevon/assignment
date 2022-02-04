@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('teams.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.teams.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.teams.inputs.name')</h5>
                    <span>{{ $team->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.teams.inputs.logoURI')</h5>
                    @if($team->logoURI)
                    <a href="{{ \Storage::url($team->logoURI) }}" target="blank"
                        ><i class="icon ion-md-download"></i>&nbsp;Download</a
                    >
                    @else - @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('teams.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                <a href="{{ route('teams.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
