@php $editing = isset($player) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="team_id" label="Team" required>
            @php $selected = old('team_id', ($editing ? $player->team_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Team</option>
            @foreach($teams as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="firstName"
            label="First Name"
            value="{{ old('firstName', ($editing ? $player->firstName : '')) }}"
            maxlength="255"
            placeholder="First Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="lastName"
            label="Last Name"
            value="{{ old('lastName', ($editing ? $player->lastName : '')) }}"
            maxlength="255"
            placeholder="Last Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.partials.label
            name="playerImageURI"
            label="Player Image Uri"
        ></x-inputs.partials.label
        ><br />

        <input
            type="file"
            name="playerImageURI"
            id="playerImageURI"
            class="form-control-file"
        />

        @if($editing && $player->playerImageURI)
        <div class="mt-2">
            <a
                href="{{ \Storage::url($player->playerImageURI) }}"
                target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('playerImageURI')
        @include('components.inputs.partials.error') @enderror
    </x-inputs.group>
</div>
