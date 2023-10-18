function dataTable(selector,url,columns){

    $(selector).DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: columns
     });
}

function sendHttpRequest(type,url,data,callback) {
    $.ajax({
        type: type,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        data: data,
        success: function (response) {
            callback(response,data);
        },
        error: function (error) {
            console.error('Error:', error);
        },
    });
}

function isEmpty(obj) {
    return Object.keys(obj).length === 0;
}


