var messageBox = new MessageBox();
$(document).ready(function () {
    //hide error box
    $('#erros_box').hide();
    //Loging
    $('#btnLoging').on('click',function(){
        loging();
    });
});

function loging() {
    var form = $('#logingForm')[0];
    var formData = new FormData(form);
    $.ajax({
        url: '/loging',
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            if (response.status == 200) {
              location.href = '/home';
            } else {
                
                $('#erros_box').hide();
                $('#erros_box').stop(true, true).fadeIn(500).delay(2000).fadeOut(500);
            }


        },
        error: function (xhr) {
           
            messageBox.createMessage("Please re-check email and password", 'warning');
        }
    });
}
