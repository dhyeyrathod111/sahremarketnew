$( document ).ready(function() {
    console.log( "ready!" );
});



$("#persnal_details_form").validate({
    rules: {    
        
    },
    errorElement: 'p',
    submitHandler: function(form) {
        var form = $('#persnal_details_form')[0]; 
        var form_data = new FormData(form);
        $.ajax({
            type: "POST",
            url: $(form).attr('action'),
            data: form_data,
            contentType: false,cache: false,processData:false, 
            success: response => {
                if (response.status == true) {
                    load_persnalinformation_table(response.member_id);
                    next_form($('#fildset_2'),$('#fildset_3'));
                } else {
                    notify_error(response.message);
                }
            },
            error: response => {
                console.log(response);notify_error();
            }
        });
    }
});



$("#otpform").validate({
    rules: {
        contact_no:{
            required: true,
            phoneUS:true,
        },
        otp:{
            required: true,
        }
    },
    errorElement: 'p',
    submitHandler: function(form) {
        var form = $('#otpform')[0]; 
        var form_data = new FormData(form);
        $.ajax({
            type: "POST",
            url: $(form).attr('action'),
            data: form_data,
            contentType: false,cache: false,processData:false, 
            success: response => {
                if (response.status == true) {
                    next_form($('#fildset_1'),$('#fildset_2'))
                } else {
                    notify_error(response.message);
                }
            },
            error: response => {
                console.log(response);notify_error();
            }
        });
    }
});


function next_form(current_fs , next_fs) {
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    next_fs.show();
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            opacity = 1 - now;
            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            next_fs.css({'opacity': opacity});
        },
        duration: 600
    });
}

function previous_form(current_fs,previous_fs) {
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    previous_fs.show();
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            previous_fs.css({'opacity': opacity});
        },
        duration: 600
    });
}


$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 600
});
});
