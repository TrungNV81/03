function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function updateMail()
{
    arrMail = '';
    arrStatus = '';
    var data = $('#arrDataMail').val();
    for (var i = 0 ; i < data; i++) {
        var email = $('#email' + i).val()
        if (!validateEmail(email)) {
            alert(email +' is not valid');
            return
        }
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