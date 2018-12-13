function Update()
{
    $.ajax({
        url : "./update",
        type : "POST",
        dataType:"text",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data : {
            time : $('#time').val(),
            subject: $('#subject').val(),
            receiver : $('#receiver').val(),
            body: $('#body').val(),
            sender: $('#sender').val()
        },
        success : function (result){
            setTimeout(function () { alert(result); }, 250);
        }
    });
}