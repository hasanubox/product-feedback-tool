<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Http\Request;
use App\Services\User\FeedbackService;
use Throwable;
use Log;

class FeedbackController extends Controller
{
    /**
     * Display a view of the resource.
     */
    public function index()
    {
        
        return view('user.feedback.index');
    }

    /**
     * Display a listing of the resource.
    */

    public function datatable(Request $request,FeedbackService $service)
    {
        $service->datatable($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('user.feedback.create',['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackRequest $request,FeedbackService $service)
    {
        try{
            $service->store($request);
            return redirect()->route('feedbacks.create')->with('message', 'Feedback has been created!');
        }catch(Throwable $caught){
           \Log::error($caught->getMessage().' on line # '.$caught->getLine());
        }
    }
}
