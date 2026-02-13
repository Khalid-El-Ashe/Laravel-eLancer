<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reviews</title>
</head>

<body>
    <h1>{{ __('Reviews List') }}</h1>

    {{-- @include('review::partials.flash') --}}


    <h2>{{ __('Submit your review') }}</h2>
    <form action="{{ route('reviews.store') }}" method="post">
        @csrf
        <div>
            {{ __('Rate this item') }}
            @for ($i = config('review.rating.minimum'); $i <= config('review.rating.maximum'); $i++)
            <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $i }}">
                <label for="rating-{{ $i }}">{{ $i }}</label>
                @endfor
        </div>

        <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
        <button type="submit" name="submit" value="Submit">{{ __('Submit') }}</button>
    </form>
</body>

</html>
