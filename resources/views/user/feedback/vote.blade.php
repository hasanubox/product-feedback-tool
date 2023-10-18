<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feedbacks Vote') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        @forelse($feedbacks as $feedback)
                        <div class="col">
                            <div class="card shadow-sm">
                                <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg> -->
                                @if(!empty($feedback->image))
                                    <img  src="{{asset('uploads/feedback/'.$feedback->image)}}">  
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-body-secondary"><b>Category:</b> {{$feedback->category}}</small>
                                            <br>
                                            <small class="text-body-secondary"><b>Created by:</b> {{$feedback->user_name}}</small>
                                        </div>
                                        <div class="btn-group vote-grp-btn">
                                            <button type="button" onclick="sendVote(1,{{$feedback->id}})" class="btn vote-btn-{{$feedback->id}} btn-sm btn-outline-secondary {{ in_array($feedback->id, $feedbackIds) ? 'disabled' : '' }}">UpVote</button>
                                            <button type="button" onclick="sendVote(0,{{$feedback->id}})" class="btn vote-btn-{{$feedback->id}} btn-sm btn-outline-secondary {{ in_array($feedback->id, $feedbackIds) ? 'disabled' : '' }}">DownVote</button>
                                        </div>
                                    </div>
                                    <p class="card-text"><b>{{$feedback->title}}</b></p>
                                    <p class="card-text">{{\Str::limit($feedback->description, 40)}}</p>
                                    <br />
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-body-secondary">Vote Count : <span data-count="{{$feedback->vote_count}}" id="vote-{{$feedback->id}}">{{$feedback->vote_count}}</span></small>
                                    </div>
                                    <br />
                                    <div class="dropdown d-grid gap-2">
                                        <button class="btn btn-primary primary-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Comment
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onClick="addComment({{$feedback->id}})">Add comment</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onClick="getfeedbackData({{$feedback->id}})">View Comments</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h2>No Record Found</h2>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <!-- Display Comments Modal -->
<div class="modal fade " id="display-comments-modal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="display-comments-modal-body">
                
            </div>
        </div>
    </div>
</div>

<!-- Add Comment Modal -->

<div class="modal fade " id="add-comment-modal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <form action="route('feedback.vote')" method="post" > -->
                <input type="hidden" name="feedback_id" id="comment-feedback-id" />
                <div class="modal-body" id="add-comment-modal-body">
                    <textarea class="form-control ckeditor" name="comment" id="comment" cols="5" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onClick="saveComment();">Add</button>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<script type="text/javascript">
    let vote_sumbit_url = "{{route('feedbacks.vote')}}";
    let get_comments_url = "{{route('feedbacks.comment')}}";
</script>
</x-app-layout>
