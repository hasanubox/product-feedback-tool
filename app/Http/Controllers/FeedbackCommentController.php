<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackCommentRequest;
use App\Services\User\FeedbackCommentService;

class FeedbackCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($feedback_id,FeedbackCommentService $service)
    {
        $comments = $service->index($feedback_id);
        return response()->json(['data' => $comments]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackCommentRequest $request, FeedbackCommentService $service)
    {
        $service->store($request);
        return response()->json(['message' => 'Comment added successfully']);
    }
}
