$(function(){

    if (typeof feedback_datatable_url !== "undefined")
        displayDataTableForFeedback();
    
    if(isEmpty(CKEDITOR.instances) == false)
        $('.ckeditor').ckeditor;
});

function displayDataTableForFeedback(){
    let columns = [
        { data: 'id' },
        { data: 'title' },
        { data: 'category_id' },
        { data: 'count' },
    ]
    dataTable('#feedback-table',feedback_datatable_url,columns);
}

function addComment(feedbackId){
    $("#comment-feedback-id").val(feedbackId);
    $("#add-comment-modal").modal('show');
}

function sendVote(vote,feedbackId) {

    let data = {
        'feedback_id' : feedbackId,
        'vote' : vote,
    }
    sendHttpRequest('POST',vote_sumbit_url,data,sendVoteCallback);
}

function sendVoteCallback(httpResponse,inputData){
    $(".vote-btn-"+inputData.feedback_id).addClass('disabled');
    let ele=$("#vote-"+inputData.feedback_id);
    let voteCount = ele.data('count');
    ele.html(voteCount+1);
    toastr.success(httpResponse.message);

}

function saveComment() {

    let data = {
        'feedback_id' : $("#comment-feedback-id").val(),
        'comment' : CKEDITOR.instances.comment.getData(),
    }
    sendHttpRequest('POST',get_comments_url,data,saveCommentCallback);
}

function saveCommentCallback(httpResponse,inputData){
    $("#add-comment-modal").modal('hide');
    toastr.success(httpResponse.message);
}

function getfeedbackData(feedbackId) {
    sendHttpRequest('GET',get_comments_url+'/'+feedbackId,{},getfeedbackDataCallback);
}

function getfeedbackDataCallback(httpResponse,inputData){
    let commentsContainer = $('#display-comments-modal-body'); // Get the container element
           let commentHTML = ''; 
           // Clear the container before appending new content
           commentsContainer.empty();
           // Loop through the data and append HTML for each comment
            if (Array.isArray(httpResponse.data) && httpResponse.data.length > 0) {
                httpResponse.data.forEach(function (comment) {
                    commentHTML += `
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                            <div class="col p-4 d-flex flex-column position-static">
                                <strong class="d-inline-block mb-2 text-primary">${comment.user.name}</strong>
                                <div class="mb-1 text-muted">${comment.created_at}</div>
                                ${comment.comment}
                            </div>
                        </div>`;
                });
            }else {
                // Handle the case where data is not an array (e.g., empty response)
                commentHTML = `No comments found.`;
            }
            commentsContainer.html(commentHTML); // Append the comment HTML to the container
            $("#display-comments-modal").modal('show');
}