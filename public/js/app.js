$(document).ready(function () {
    new WOW().init();

    // Show Image Before Uploaded
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('#show_image').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }

    // start page-signup

    $('html').on('click', '.show-password', function () {
        if ( $(this).hasClass('show-pass') ) {
            $(this).siblings('#password, #password-confirm').attr('type', 'text');
        } else {
            $(this).siblings('#password, #password-confirm').attr('type', 'password');
        }
        $(this).toggleClass('show-pass fa-eye-slash fa-eye');
        
    });

    // end page-signup

    // Start Page-home

    $('#delete_account').on('click', function() {
        swal({
            title: "حذف حساب",
            text: "هل أنت متأكد من حذف الحساب؟",
            icon: "warning",
            dangerMode: true,
            buttons: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("تم حذف الحساب بنجاح", {
                icon: "success",
              });
              setTimeout(function () {
                window.location = "profile/destroy";
            }, 1000);
            } else {
              
            }
          });
    });

    // End Page-home

    // Start Edit Profile
    $(".page-profile #avatar").on('change', function(){
        $('#show_image').css('visibility', 'visible');
        console.log(this);
        readURL(this);
    });
    // End Edit Profile

});