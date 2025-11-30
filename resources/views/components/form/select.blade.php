@props([
'label',
'id',
'name',
'selected' => '',
'options' => []
])

<label for="{{$id}}">{{$label}}</label>

<select {{-- {{ $attributes }} --}} id="{{$id}}" name="{{$name}}" {{-- class="form-control" --}} {{
    $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} >
    <option value="">No</option>
    @foreach ($options as $value => $text)
    <option value="{{ $value }}" @if ($value==old($name, $selected)) selected @endif>{{ $text }}</option>
    @endforeach
</select>

{{-- @if ($errors->has('name'))
<p class="text-danger">{{ $errors->first('name') }}</p>
@endif --}}

@error($name)
{{-- <p class="text-danger">{{ $errors->first($name) }}</p> --}}
<p class="ivalid-feedback">{{ $message }}</p>
@enderror