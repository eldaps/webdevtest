<!DOCTYPE html>
<html>
    
    <head>
        <link rel="stylesheet" href="styles.css">
        <script src="jquery.js"></script>
        <script src="validation.js"></script>
        <span style="display: none;">
            <?php
                include('subscribe.php');
            ?>
        </span>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
    <body>
        <div class="mtoppanel">
            <img src="images/logo_pineapple.png" class="mlogopineapple">
            <a href="#" class="mtoplink">About</a>
            <a href="#" class="mtoplink">How it works</a>
            <a href="#" class="mtoplink">Contact</a>
        </div>
        <div class="mbackground"></div>
        <div class="mmidpanel">
            <div class="msubscribeform" id="subscribeform" <?php if($subscribed) {echo 'style="display: none"';}?>>
                <h1 class="msubscribeheading">Subscribe to newsletter</h1>
                <p class="msubscribetext">Subscribe to our newsletter and get 10% discount on pineapple glasses.</p>
                <form action="mobile.php" method="post" id="form" onsubmit="return validateForm();">
                    <div class="memailbox">
                        <span class="memailboxline"></span>
                        <input id="email" type="text" name="email" class="memailinput" placeholder="Type your email address here…">
                        <input type="submit" value="" class="memailsubmit" id="emailsubmit">
                    </div>
                    <div class="mtospanel">
                        <span class="checkboxborder"></span>
                        <label>
                            <input type="checkbox" name="agreetos" id="agreetos" class="toscheckbox"><span class="checkboxbg"></span><span class="checkmark"></span><span class="toslabel">I agree to <a class="link" href="#">terms of service</a></span>
                        </label>
                    </div>
                </form>
                <p class="merror" id="error"><?php echo $error; ?></p>
                
            </div>
            <div class="mthankspanel" id="thankspanel" <?php if(!$subscribed) {echo 'style="display: none"';}?>>
                <img src="images/thanks.png" class="mthanksimage">
                <h1 class="mthanksheading">Thanks for subscribing!</h1>
                <p class="mthanksmessage">You have successfully subscribed to our email listing. Check your email for the discount code.</p>
            </div>
            <hr class="mhbar">
            <div class="msocialmediapanel">
                <a class="mbuttonfacebook" href="#"></a>
                <a class="mbuttoninstagram" href="#"></a>
                <a class="mbuttontwitter" href="#"></a>
                <a class="mbuttonyoutube" href="#"></a>
            </div>
        </div>
    </body>
</html>