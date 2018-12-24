function Update() {
    var validFlg = true;
    var time = $("#time").val();
    if (time == "" || checkValue(time) == 0) {
        showError($("#time"));
        validFlg = false;
    } else {
        hiddenError($("#time"));
    }
    var subject = $("#subject").val();
    var body = $("#body").val();

    var checkSubject = subject.includes("$drawing_name");
    var checkBody = body.includes("$drawing_name");
    if(!checkSubject){
        alert('Subject email required string "$drawing_name"')
        return false;
    }
    if(!checkBody){
        alert('Body email required string "$drawing_name"')
        return false;
    }
    //if (validFlg == true) {
	if (true) {
        // var convertTime = convertTo_UTF8(time);
        // if (convertTime < 10) {
        //    showError($("#time"));
        // } else {
        //    hiddenError($("#time"));
            $.ajax({
                url: "./updateTemplate",
                type: "POST",
                dataType: "text",
                beforeSend: function(xhr) {
                    var token = $('meta[name="csrf_token"]').attr("content");
                    if (token) {
                        return xhr.setRequestHeader("X-CSRF-TOKEN", token);
                    }
                },
                data: {
                    // time: convertTime,
                    subject: $("#subject").val(),
                    receiver: $("#receiver").val(),
                    body: $("#body").val(),
                    sender: $("#sender").val()
                },
                success: function(result) {
                    setTimeout(function() {
                        alert(result);
                    }, 250);
                }
            });
       // }
    }
}

function showError(ele) {
    $(ele.parent()).addClass("has-error");
    $("#showError").attr("hidden", false);
}

function hiddenError(ele) {
    $("#showError").attr("hidden", true);
    $(ele.parent()).removeClass("has-error");
}

function checkValue(value) {
    var regx = /^[\d[０-９]{0,}$/.test(value);
    if (regx == true) {
        return 1;
    } else {
        return 0;
    }
}

function convertTo_UTF8(value_shift_jis) {
    var intValue = "";
    for (var i = 0; i < value_shift_jis.length; i++) {
        if (/^[０-９]$/.test(value_shift_jis[i])) {
            var charCode = value_shift_jis[i].charCodeAt() - 65248;
            intValue += String.fromCharCode(charCode);
        } else {
            intValue += value_shift_jis[i];
        }
    }
    return intValue;
}
