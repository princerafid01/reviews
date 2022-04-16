<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reviews;
use App\Vote;

class VoteController extends Controller
{
    // take vote
    public function __invoke(Reviews $review, Request $r)
    {
    	// get ip 
    	$ip = $r->ip();

    	// check if not already voted for this review
    	$alreadyVoted = Vote::where( 'ip', $ip )->where('review_id', $review->id)->exists();

    	if( $alreadyVoted )
    		return response()->json( [ 'error' => __( 'Already voted for this review' ) ] );

    	// otherwise let's record this vote
    	$vote = new Vote;
    	$vote->ip = $ip;
    	$vote->review_id = $review->id;
    	$vote->vote = 'Up';
    	$vote->save();

    	return response()->json([ 'upvotes' => $review->votes()->count() ]);

    }
}
