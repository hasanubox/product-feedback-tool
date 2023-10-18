<?php 

namespace App\Services\User;

use App\Models\FeedbackVote;
use App\Models\Feedback;
use App\Http\Requests\FeedbackVoteRequest;
use App\Traits\General;
use App\Jobs\SendEmails​;

class FeedbackVoteService
{
    use General;

    public function index(){
        $feedbackIds = FeedbackVote::where('user_id', auth()->id())->pluck('feedback_id')->toArray();
        $feedbacks = Feedback::select([
            'feedbacks.id',
            'feedbacks.title',
            'categories.name as category',
            'users.name as user_name',
            'feedbacks.description',
            'feedbacks.image'
        ])
        ->selectSub(function ($query) {
            $query->selectRaw('COUNT(id)')
                ->from('feedback_votes as fv')
                ->whereColumn('fv.feedback_id', 'feedbacks.id');
        }, 'vote_count')
        ->join('categories', 'categories.id', '=', 'feedbacks.category_id')
        ->join('users', 'users.id', '=', 'feedbacks.created_by')
        ->orderByDesc('vote_count')
        ->get();
        $data = ['feedbacks' => $feedbacks,'feedbackIds' => $feedbackIds];
        return $data;
    }

    public function store(FeedbackVoteRequest $request){
        
        $request->validated();
        $request->request->add(['user_id' => auth()->id()]);
        FeedbackVote::create($this->createData($request));
        SendEmails​::dispatch('Vote has been increased');
    }

}