@extends('master')
@section('title','Signup')

@section('content')
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="/logo.png" style ='max-height: 200px'class='pr-2' >
                     
                    </a>
                </div>
                <div class="login-form">
                    <form>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" id = 'fname' name='fname' class="form-control" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" id = 'lname' name='lname' class="form-control" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" id='email' name='email' class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <label>Phone No.</label>
                            <input type="text" id='phone' name='phone' class="form-control" placeholder="Phone No.">
                        </div>
                        <div hidden class="form-group">
                            <label>Business Category</label>
                            <input type="text" id= 'category' name='category' class="form-control" placeholder="Business Category">
                        </div>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id='password' name='password' class="form-control password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" id='cpassword' class="form-control" placeholder="Confirm Password">
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input id='chkbox' type="checkbox">  I agree to the terms and policy..
                            </label>
                        </div>
                        <button type="button" class="signup btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                       
                        <div class="register-link m-t-15 text-center">
                            <p>Already have account ? <a href="/"> Sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="/js/main.js"></script>
    <script>
        $('.signup').click(function(){
            var fname = $("#fname").val();
            var lname = $("#lname").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var business = $("#category").val();
            var password = $("#password").val();
            var cpassword = $("#cpassword").val(); 
            if(!email.includes('@') || !email.includes('.'))
            {
                alert('Email is of incorrect format!!');
                return;
            }
            else if(password != cpassword)
            {
                alert('Password and confirm Password must be equal!!');
                return;
            }
            else if(password.length < 6)
            {
                
                alert('Password must be atleast 6 digits long!!'); 
                return;
            }
            else if(!$('#chkbox')[0].checked)
            {
                alert('You must agree to the terms and conditions!!'); 
                return;
            }
            else if(!phone.startsWith('+60'))
            {
                alert('Your phone number must start with +60');
                return;
            }
            else if(/([A-Z]|[a-z])/.test(phone))
            {
                alert('Your phone number must contain numbers only!!');
                return;
            }
            else
            {
                
             $.ajax({
                    url:'/createUser',
                    type:'POST',
                    data:{fname:fname,lname:lname,email:email,phone:phone,business:business,password:password},
                    success:function(result)
                    {
                        if(result=='OK')
                        {
                            alert('User succesfully created!!');
                            location.href = '/';
                        }
                        else if(result=='email')
                        {
                            alert('Please use another email this email has already been registered!!');
                        }
                        else
                        {
                            alert('Oops!! An error occurred!!');
                        }
                    },
                    error:function(error)
                    {
                        console.log(error);
                    }
                })
            }
        })
    </script>
@endsection 