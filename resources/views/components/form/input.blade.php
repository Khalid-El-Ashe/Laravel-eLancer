@props([
'label',
'type' => 'text',
'id',
'name',
'value' => ''
])

<label for="{{$id}}">{{$label}}</label>

<input {{-- {{ $attributes }} --}} type="{{ $type {{-- ?? 'text' --}} }}" id="{{$id}}" name="{{$name}}"
    value="{{ old($name, $value) }}" {{-- class="form-control" --}}
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
    >

{{-- @if ($errors->has('name'))
<p class="text-danger">{{ $errors->first('name') }}</p>
@endif --}}

@error($name)
{{-- <p class="text-danger">{{ $errors->first($name) }}</p> --}}
<p class="ivalid-feedback">{{ $message }}</p>
@enderror
