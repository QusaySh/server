$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    new WOW().init();
    // Copy Text
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).data('url')).select();
        document.execCommand("copy");
        $temp.remove();
      }

      $('.copy-url').on('click', function () {
            copyToClipboard($(this));
            swal("تم نسخ الرابط الخاص بك");
      });

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

    $('body').on('click', '.delete-message', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
            title: "حذف رسالة",
            text: "هل أنت متأكد من حذف الرسالة",
            icon: "warning",
            dangerMode: true,
            buttons: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                window.location = url;
            } else {
              
            }
          });
    });

    // عند الضغط على رد
    var show_count_reply = ""; // لوضع عنصر ظهور عدد الردرود
    $('body').on('click', '.get-reply', function () {
        show_count_reply = $(this).siblings('.show-reply').children('.count-reply');

        var message_id = $(this).data('mid');
        $('.reply-message').data('mid', $(this).data('mid'));
        $('#reply_model .spinner-border').show();
        $('#reply_model form').hide();
        $.ajax({
          type:'GET',
          url:'/send_message/get_reply/' + message_id,
          beforeSend: function () {
              
          },
          success:function(data) {
              $('#reply_model .text-message').text(data.get_reply.message);
              $('#reply_model .spinner-border').hide();
              $('#reply_model form').show();
              $('#reply_model textarea').val('').removeClass('is-invalid');
          }
      });
    });

    $('.reply-message').on('click', function () {
        var mid = $(this).data('mid'),
            _token = $("#reply_model input[name='_token']").val(),
            message = $('#reply_model textarea').val();

        $.ajax({
          type:'POST',
          url:'send_message/reply_message',
          data:{_token: _token, message: message, mid: mid},
          beforeSend: function () {
              
          },
          success:function(data) {
            show_count_reply.text(data.count_reply); // عرض عدد الردود 
            if ( $.isEmptyObject(data.error) ) {
              swal("نجاح", "تم إرسال الرد بنجاح", "success");
              $('#reply_model textarea').removeClass('is-invalid');
            }
          },

          error: function (response) {
            $('#reply_model textarea').addClass('is-invalid').next('.invalid-feedback').text(response.responseJSON.errors.message);
          }
      });

    });

    $('body').on('click', '.show-reply', function () {
      show_count_reply = $(this).children('.count-reply'); // تحديد العنصر المراد وضع النص فيه
      console.log(show_count_reply);
      var message_id = $(this).data('mid');
      $.ajax({
        type:'GET',
        url:'/send_message/show_reply/' + message_id,
        beforeSend: function () {
          $('#show_reply_model .loading-reply-1').show();
          $('#show_reply_model .modal-body .body-reply').text('');            
        },
        success:function(data) {
            $('#show_reply_model .modal-body .body-reply').html(data.show_reply);
            $('#show_reply_model .loading-reply-1').hide();
        }
    });
  });

    $('body').on('click', '.delete-reply', function () {
      var reply_id = $(this).data('rid'),
          message_id = $(this).data('mid'),
          btn = $(this);

      $.ajax({
        type:'GET',
        url:'/send_message/delete_reply/' + reply_id + "/" + message_id,
        beforeSend: function () {
          btn.children('i').toggleClass('fa-close fa-spinner fa-spin').parent().toggleClass('text-danger text-info');
        },
        success:function(data) {
          show_count_reply.text(data.count_reply); // عرض عدد الردود 
          btn.parents('.list-group').fadeOut();
          btn.children('i').toggleClass('fa-close fa-spinner fa-spin').parent().toggleClass('text-danger text-info');
        }
    });
  });

  $('body').on('click', '.show-favorite', function () {
    $.ajax({
      type:'GET',
      url:'/send_message/show_favorite',
      beforeSend: function () {
        // btn.children('i').toggleClass('fa-close fa-spinner fa-spin').parent().toggleClass('text-danger text-info');
      },
      success:function(data) {
        $('#pills-favorite').html(data.favorite);
        $('#pills-favorite .spinner').fadeOut('fast');
        // btn.children('i').toggleClass('fa-close fa-spinner fa-spin').parent().toggleClass('text-danger text-info');
      }
    });
  });

    // End Page-home

    // Start Edit Profile
    $(".page-profile #avatar").on('change', function(){
        $('#show_image').css('visibility', 'visible');
        readURL(this);
    });
    // End Edit Profile

});