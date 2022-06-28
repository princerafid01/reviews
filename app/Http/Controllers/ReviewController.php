<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reviews;
use App\Sites;
use App\User;
use Mail;
use App\Mail\EmailNotification;
use Options;
use DataTables;

class ReviewController extends Controller
{

    public function get_datatables()
    {

        if (request()->ajax()) {
            $data = Reviews::with('site', 'user')
                ->whereHas('site', function ($query) {
                    $query->where('url', '!=', '');
                })->wherePublish('yes')->orderByDesc('id')->get();

            return Datatables::of($data)
                ->addColumn('site_url', function (Reviews $review) {
                    $render = "";
                    $render .= $review->site ? $review->site->url : '';
                    $render .= "<br>";
                    if ($review->site) {
                        $render .= '<a href="' . route('reviewsForSite', ['site' => $review->site->url]) . '" target="_blank">View Listing</a>';
                    }
                    return $render;
                })
                ->addColumn('reviewed_by', function (Reviews $review) {
                    $render = ($review->user && $review->user->name) ? $review->user->name : "Admin <br>";
                    $render .=  ($review->user && $review->user->email) ? $review->user->email : "admin@admin.com";
                    return $render;
                })
                ->editColumn('review_title', function (Reviews $review) {
                    $render = str_repeat('<i class="fa fa-star"></i>', $review->rating) . "<br>";
                    $render .=  $review->rating;
                    return $render;
                })
                ->addColumn('action', function (Reviews $review) {
                    $render = '<a href="/admin/reviews/edit/' . $review->id . '">Edit</a>
                    <br>
                    <a href="/admin/reviews/delete/{{ $r->id }}" onclick="return confirm(\'Are you sure?\')">Delete </a>';
                    return $render;
                })
                ->rawColumns(['action'])
                ->escapeColumns('site_url', 'reviewed_by', 'action')
                ->make(true);
        }
    }

    // single item
    public function single(Sites $review)
    {

        // check if business is under review and is not admin
        if (!session()->has('admin') and $review->publish == 'No')
            return view('company-under-review');


        // get reviews for this site
        $reviews = $review->reviews()
            ->with('votes')
            ->withCount('votes')
            ->wherePublish('Yes')
            ->orderByDesc('votes_count')
            ->orderByDesc('id')
            ->paginate(10);

        // get average rating
        $averageRating = @number_format($reviews->avg('rating'), 2) ?? 0.00;

        // set seo title 
        $seo_title =  $review->business_name . ' - ' . $review->url . ' ' .  __('Reviews ');

        // get current user auth
        $alreadyReviewed = false;

        if (!auth()->guest() && auth()->user()->id) {

            $alreadyReviewed = Reviews::where('user_id', auth()->user()->id)
                ->where('review_item_id', $review->id)
                ->exists();
        }

        return view('review-single', compact(
            'reviews',
            'review',
            'averageRating',
            'seo_title',
            'alreadyReviewed'
        ));
    }

    // take review
    public function takeReview(Sites $r, Request $request)
    {

        $this->middleware('auth');

        // validate
        $this->validate($request, [
            'rating' => 'required|integer|between:1,5',
            'review_title' => 'required|min:2',
            'review_content' => 'required|min:5'
        ]);

        // insert review
        $review = new Reviews($request->only(['rating', 'review_title', 'review_content']));
        $review->user_id = auth()->user()->id;

        try {

            // save review
            $id = $r->reviews()->save($review);

            // set sweet alert message
            alert()->success(__('Your review was sent to review and will soon be published if it abides by our TOS'), __('Thank you'));

            // notify admin by email
            $data['message'] = sprintf(
                __('New review to %s
                                  Reviewer: %s
                                  Title: %s
                                  Rating: %s
                                  Review Content: %s'),

                '<strong>' . $r->url . '</strong><br>',
                $review->reviewer_name . '<br>',
                $review->review_title . '<br>',
                $review->rating . '<br>',
                $review->review_content
            );

            $data['intromessage'] = __('New Review awaiting approval');
            $data['url'] = route('reviewsForSite', ['site' => $r->url]);
            $data['buttonText'] = __('See Review');

            Mail::to(Options::get_option('adminEmail'))->send(new EmailNotification($data));


            return back();
        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage());
        }
    }

    // take reply as company
    public function replyAsCompany(Reviews $r, Request $req)
    {

        if (!$req->has('replyTo_' . $r->id)) {
            return back()->with('message', __('Please enter the reply content.'));
        }

        // get review item 
        $reviewItem = $r->site->claimedBy;

        if (auth()->user()->id != $reviewItem) {
            return back()->with('message', __('You do not seem to own this review item id.'));
        }

        // save reply
        $r->company_reply = $req->{"replyTo_" . $r->id};
        $r->save();

        return back()->with('message', __('Your reply was saved.'));
    }
}
