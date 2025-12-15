<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RatingController extends Controller
{
    public function store(Request $request, $userId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:1000',
        ]);

        // Prevent self-review
        if (Auth::id() == $userId) {
            return back()->withErrors('You cannot review yourself.');
        }

        // Optional: prevent duplicate reviews
        $alreadyReviewed = Rating::where('reviewer_id', Auth::id())
            ->where('reviewed_user_id', $userId)
            ->exists();

        if ($alreadyReviewed) {
            return back()->withErrors('You already reviewed this user.');
        }

        Rating::create([
            'reviewer_id'       => Auth::id(),
            'reviewed_user_id' => $userId,
            'rating'            => $request->rating,
            'message'           => $request->message,
        ]);

       return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:1000',
        ]);

        $review = Rating::findOrFail($id);

        if ($review->reviewer_id != Auth::id()) {
            abort(403);
        }

        $review->update([
            'rating'  => $request->rating,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Review updated successfully!');
    }

}
