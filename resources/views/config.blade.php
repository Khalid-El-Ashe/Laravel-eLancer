@extends('layouts.dashboard')
@section('content')
<h1 class="mb-3">Settings</h1>

<form action="{{ route('config.store') }}" method="post">
    @csrf

    <x-flash-message />

    <div class="form-group">
        <x-form.input label="App Name" type="text" id="name" name="config[app.name]" value="{{ config('app.name') }}" />
    </div>

    <div class="form-group">
        <x-form.input label="Locale" type="text" id="locale" name="config[app.locale]"
            value="{{ config('app.locale') }}" />
    </div>

    <div class="form-group">
        <x-form.input label="Currency" type="text" id="currency" name="config[app.currency]"
            value="{{ config('app.currency') }}" />
    </div>

    <div class="form-group">
        <x-form.input label="Timezone" type="text" id="timezone" name="config[app.timezone]"
            value="{{ config('app.timezone') }}" />
    </div>

    <div class="form-group" style="margin-top: 10ex">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>


@endsection
