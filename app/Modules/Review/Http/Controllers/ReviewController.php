<?php

namespace App\Modules\Review\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Review\Models\Review;
use Illuminate\Support\Facades\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::paginate();

        return view('review::index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reviewable_type' => ['required', 'string'],
            'reviewable_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string'],
        ]);

        $data['user_id'] = auth()->id();

        Review::create($data);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
