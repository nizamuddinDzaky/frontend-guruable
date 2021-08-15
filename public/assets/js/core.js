function sweet_alert(icon, title , text, showCancelButton =  false, cancelButtonText ='Tidak', confirmButtonText = 'OK', html = ''){
    return Swal.fire({
        title: title,
        icon: icon,
        html: text,
        reverseButtons: !0,
        showCancelButton : showCancelButton,
        cancelButtonText : cancelButtonText,
        confirmButtonText : confirmButtonText,
        allowOutsideClick: false,
    })
}

function loader(){
    return Swal.fire({
          title: 'Mohon Tunggu',
          width: 600,
          padding: '3em',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
}

function send_data(url, method, data){
    return new Promise((resolve, reject) => {
        $.ajax({
            url:url,
            data:data,
            cache: false,
            contentType: false,
            processData: false,
            type:method,
            dataType: 'html',
            beforeSend: function() {
                // loader()
            },
            complete:function() {
              
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                reject(err.Message)
            },
            success:function(data) {
                let res = JSON.parse(data)
                if(res.success == false){
                    reject(res.message)
                }
                resolve(res)
            }
        })
    });
}

$(document).ready(function(){
    $(document).on('submit', '#form', function (e) {
        e.preventdefault;
        var formData = new FormData(this);
        send_data($(this).attr("action"), $(this).attr("method"), formData).then(data => {
            sweet_alert("success", "Berhasil", data.message).then(function (e) {
                window.location.href = data.data.url;
            }, function (dismiss) {
                return false;
            })
        // }
        })
        .catch(error => {
            sweet_alert("error", "Error", error).then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
        });
        return false
    })
})

$('.select2').select2({
    // theme: 'bootstrap4',
    placeholder : 'Pilih Data'
})