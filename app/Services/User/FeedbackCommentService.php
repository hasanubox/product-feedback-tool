<?php 

namespace App\Services\User;

use App\Models\FeedbackComment;
use App\Http\Requests\FeedbackCommentRequest;
use App\Traits\General;
use App\Jobs\SendEmails​;

class FeedbackCommentService
{
    use General;
    
    public function index($feedback_id){
        
        return FeedbackComment::select('id', 'feedback_id', 'user_id', 'comment','created_at')
                ->with('user') // Eager load the 'user' relationship
                ->where('feedback_id', $feedback_id)
                ->get();
        
    }

    public function store(FeedbackCommentRequest $request){

        $request->validated();
        $request->request->add(['user_id' => auth()->id()]);
        FeedbackComment::create($this->createData($request));
        SendEmails​::dispatch('New comment has been added');
    }
}