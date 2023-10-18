<?php

namespace App\Http\Controllers;

use App\Services\User\FeedbackVoteService;
use App\Http\Requests\FeedbackVoteRequest;

class FeedbackVoteController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(FeedbackVoteService $service)
    {
        $data=$service->index();
        return view('user.feedback.vote',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackVoteRequest $request, FeedbackVoteService $service)
    {
        $service->store($request);
        return response()->json(['message' => 'Vote submitted successfully']);
    }
}
