<div class="form-group">
    <x-form.input label="Role Name" type="text" id="name" name="name" value="{{ $role->name }}" />
</div>

<div class="form-group">
    @foreach (config('abilities') as $ability => $lable )
    {{-- <div class="form-check form-switch">
        <input class="form-check-input" type="radio" name="abilities[]" value="{{ $ability }}" @if(in_array($ability,
            ($role->abilities ?? []))) checked
        @endif>
        <label class="form-check-label" for="flexSwitchCheckDefault">{{ $lable }}</label>
    </div> --}}
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="abilities[]" value="{{ $ability }}" @if(in_array($ability,
            ($role->abilities ?? []))) checked
        @endif>
        <label class="form-check-label" for="flexCheckDefault">
            {{ $lable }}
        </label>
    </div>
    @endforeach
</div>

<div class="form-group" style="margin-top: 10ex">
    <button type="submit" class="btn btn-primary">Save</button>
</div>