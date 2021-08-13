$(function(){
    $('#registration').validate({
        rules:{
            username:{
                required:true,
                minlength:8,
                remote:{
                    url:'existinguser.php',
                },
            },
            firstname:"required",
            lastname:"required",
            email:{
                required:true,
                email:true,
            },
            password:{
                required:true,
                minlength:5,
            },
            cpassword:{
                required:true,
                equalTo:'#password',
            },
            gender:"required",
            checkbox:"required",
        },
        messages:{
            username:{
                required:"Username can't be empty",
                minlength:"Minimum 8 characters are required for User name",
                remote:"Username Already exist",
            },
            firstname:"First name Can't be empty",
            lastname:"Last name Can't be empty",
            email:"please enter a valid email address",
            password:{
                required:"password can't be empty",
                minlength:"Password must be greater than 5 characters"
            },
            cpassword:{
                required:"kindly reconfirm the password",
                equalTo:"password do not match"
            },
            gender:"Please Choose your Gender",
            checkbox:"Kindly tick on checkbox to agree with terms & conditions",
        },
        submitHandler:function(form){
            form.submit();
        }
    })

})