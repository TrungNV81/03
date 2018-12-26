function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function updateMail()
{
    arrMail = '';
    arrStatus = '';
    var data = $('#arrDataMail').val();
    var id_group = $('#id_group').val();
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
        else {
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
            arrStatus:  arrStatus,
            id_group: id_group
        },
        success : function (result){
            alert(result);
        }
    }) 
}

function viewMail(id_group)
{
    var html='';
    $.ajax({
        cache: false,
        url : "./getMailGroup",
        type : "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data:{
            id_group : id_group
        },
        success : function (data){
            console.log(data);
            html+='<form action="{{url("add-mail")}}" method="POST">'
            // html+='{{ csrf_field() }}'
            html+='<label style="padding: 5px">Add new mail</label>'
            html+='<input style="display: inline-block; width: auto" class="form-control" required type="email" name="new-email" value="">'
            html+='<button type="" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Add</button>'
            html+='</form>'
            
            html+='<br>'
            html+='<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-3">'
            html+='<thead>'
            html+='<tr>'
            html+='<th>Email</th>'
            html+='<th>Status</th>'
            html+='<th>Delete</th>'
            html+='</tr>'
            html+='</thead>'
            html+='<tbody>'
            for(var i = 0; i < data.length; i++) {
                html+='<tr class="odd gradeX">'
                html+='<td>'
                html+='<input style="width: 100%" class="form-control" type="email" name="'+data[0][i].id+'" value="'+data[0][i].email+'" id="email'+i+'">'
                html+='</td>'
                html+='<td>'
                if(data[0][i].status == '1')
                {
                    html+='<input class="form-control auto" type="checkbox" name="'+data[0][i].id+'" class="form-check-input" id="status'+i+'" checked>'
                }
                  
                else
                {
                    html+='<input class="form-control auto" type="checkbox" name="'+data[0][i].id+'" class="form-check-input" id="status'+i+'">'
                }              
                html+='</td>'
                html+='<td>'
                html+='<form action="{{ url("del-mail") }}" method="POST">'
                //html+='{{ csrf_field() }}'
                html+='<input hidden name="id-mail" value="'+data[i].id+'">'
                html+='<button class="btn btn-danger center-block"><i class="fa fa-trash-o fa-fw"></i> Delete</button>'
                html+='</form>'
                html+='</td>'
                html+='</tr>'
            }
            html+='</tbody>'
            html+='</table>'
            html+='<hr>'
            html+='<input value="'+data[1]+'" id="id_group" name="id_group" />'
            html+='<input value="'+data.length+'" id="arrDataMail" />'
            html+='<button style="float: right" type="submit" class="btn btn-success" onclick="updateMail()">Update</button>'
            $("#movie-data").html("");
            $("#movie-data").html(html);
        }
    }) 
}