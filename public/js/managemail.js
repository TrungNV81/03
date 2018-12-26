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
            html+='<label style="padding: 5px">Group: '+data[0][0].group_name+'</label>'
            html+='<br>'
            html+='<label style="padding: 5px">Add new mail</label>'
            html+='<input style="display: inline-block; width: auto" class="form-control" required type="email" id="new-email" value="">'
            html+='<button onclick="addMail('+data[1]+')" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Add</button>'
            html+='<br>'
            if (data[0].length) {
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
                for(var i = 0; i < data[0].length; i++) {
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
                    html+='<button class="btn btn-danger center-block" onclick="delMail('+data[0][i].id+','+data[1]+')"><i class="fa fa-trash-o fa-fw"></i> Delete</button>'
                    html+='</td>'
                    html+='</tr>'
                }
                html+='</tbody>'
                html+='</table>'
                html+='<hr>'
                html+='<input hidden value="'+data[1]+'" id="id_group" name="id_group" />'
                html+='<input hidden value="'+data.length+'" id="arrDataMail" />'
                html+='<button style="float: right" type="submit" class="btn btn-success" onclick="updateMail()">Update</button>'
            }
            $("#data-mail").html("");
            $("#data-mail").html(html);
        }
    }) 
}

function delMail(id_mail, id_group)
{
    $.ajax({
        cache: false,
        url : "./del-mail",
        type : "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data:{
            idMail : id_mail,
            idGroup: id_group
        },
        success : function (result){
            alert("Delete email success!");
            viewMail(result);
        }
    }) 
}

function addMail(id_group)
{
    var new_email = $('#new-email').val();
    if (!validateEmail(new_email)) {
        alert(new_email +' is not valid');
        return
    }
    $.ajax({
        cache: false,
        url : "./add-mail",
        type : "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data:{
            new_email: new_email,
            id_group: id_group
        },
        success : function (result){
            if (result > -1) {
                alert("Add mail success!");
                viewMail(result);
            } else {
                alert("Email address exists!");
            }
        }
    }) 
}