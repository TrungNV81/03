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
            body: $('#body').val(),
        },
        success : function (result){
            $('#permission_id' + $('#idUser').val()).text($("#permission_id_select option:selected" ).text());
            $('#status' + $('#idUser').val()).text($("#status_id_select option:selected" ).text());
            $('#firstname').prop('disabled', true);
            $('#lastname').prop('disabled', true);
            $('#birthdate').prop('disabled', true);
            $('#Update_InfoUser').prop('disabled', true);
            $("#permission_id_select").prop('disabled', true);
            $("#status_id_select").prop('disabled', true);
            setTimeout(function () { alert(result); }, 250);
        }
    });
}