@extends('master')
@section('title','Access Link')
@section('content')
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    
                        <img class="align-content" src="logo.png" style ='max-height: 200px'class='pr-2' >
                    
                </div>
                <?php if(!isset($_GET['linkRedirect'])) { ?>
                
                <div class="login-form">
                    <form action="\openURL" method = 'POST'>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id = 'name' name="name" placeholder="Enter Name">
                        </div>
                        <input type="text" class="d-none" name="linkID" value={{$linkID}}>
                        
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" class="form-control email" id='email' name="email" placeholder="Enter Email Address">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control phone" id='phone' name="phone" value="+60" placeholder="Enter Phone Number">
                        </div>
                        <button type="submit" onsubmit="event.preventDefault();" class="check btn btn-success btn-flat m-b-30 m-t-30">Access</button>
                    </form>
                </div>
            <?php }else{ ?>
                <p style="
    margin-top: 18%;
    margin-left: 17%;
" class="">Tekan Logo Untuk Disambungkan ke WhatsApp</p>
            <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="js/main.js"></script>
    <?php 
    if(isset($_GET['linkRedirect']))
    {
        if(isset($_GET['linkRedirect']))
    {
        if($_GET['linkRedirect'] == '2')
        {
            $address = "/openURL?name=Unknown&email=Unknown&phone=Unknown&linkID=".$linkID;
            echo "<div class='d-none'>";
            echo redirect($address);
            echo "</div>";
        }
    }
    }
    else {
    ?>
    <script>
        $('.check').click(function()
        {   
            debugger
            var email =$(this).parents('form').find('.email').val();
            var phone = $(this).parents('form').find('.phone').val()
            if(!email.includes('@') || !email.includes('.'))
            {
                alert('Email is of incorrect format!!');
                return false;
            }
            else if(!phone.startsWith('+60'))
            {
                alert('Your phone number must start with +60');
                return false;
            }
            else if(/([A-Z]|[a-z])/.test(phone))
            {
                alert('Your phone number must contain numbers only!!');
                return false;
            }
            
        })
    </script>
    <?php } ?>
@endsection