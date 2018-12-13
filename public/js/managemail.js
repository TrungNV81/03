function Update()
{
    arrMail = '';
    arrStatus = '';
    var data = $('#arrDataMail').val();
    for(var i = 0 ; i < data; i++){
        arrMail = arrMail + $('#email' + i).val() + ',';
        if ($('#status' + i).is(':checked')) {
            arrStatus = arrStatus + 1 + ',';
        }
        else{
            arrStatus = arrStatus + 0 + ',';
        }
    }
    $.ajax({
        cache: false,
        url : "./edit-mail",
        type : "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data:{
            arrMail : arrMail,
            arrStatus:  arrStatus
        },
        success : function (result){
            alert(result);
        }    
    }) 
}