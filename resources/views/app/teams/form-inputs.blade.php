@php $editing = isset($team) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $team->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.partials.label
            name="logoURI"
            label="Logo Uri"
        ></x-inputs.partials.label
        ><br />

        <input
            type="file"
            name="logoURI"
            id="logoURI"
            class="form-control-file"
        />

        @if($editing && $team->logoURI)
        <div class="mt-2">
            <a href="{{ \Storage::url($team->logoURI) }}" target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('logoURI') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>
</div>
