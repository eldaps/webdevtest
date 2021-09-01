<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <script src="jquery.js"></script>
    <script src="validation.js"></script>
    <span style="display: none;">
    <?php
        include('subscribe.php');

        require_once 'Mobile_Detect.php';
        $detect = new Mobile_Detect;

        // Redirect mobile devices to mobile site
        if ( $detect->isMobile() ) {
            header("Location: /mobile.php");
            die();
        }
    ?>
    </span>
</head>
<body>
    <img class="mainimage" src="images/image_summer.png">
    <div class="leftpanel">
        <div class="topbar">
            <img src="/images/logo_pineapple.png" class="logopineapple">
            <img src="/images/text_pineapple.png" class="textpineapple">
            <a class="toplink" href="#">About</a>
            <a class="toplink" href="#">How it works</a>
            <a class="toplink" href="#">Contact</a>
        </div>

        <div class="subscribeform" id="subscribeform" <?php if($subscribed) {echo 'style="display: none"';}?>>
            <h1 class="subscribeheading">Subscribe to newsletter</h1>
            <p class="subscribetext">Subscribe to our newsletter and get 10% discount on pineapple glasses.</p>
            <form action="index.php" method="post" id="form" onsubmit="return validateForm();">
            <div class="emailbox">
                <span class="emailboxline"></span>
                <input id="email" type="text" name="email" class="emailinput" placeholder="     Type your email address here…">
                <input type="submit" value="" class="emailsubmit" id="emailsubmit">
            </div>
            <div class="tospanel">
                <span class="checkboxborder"></span>
                <label>
                    <input type="checkbox" name="agreetos" id="agreetos" class="toscheckbox"><span class="checkboxbg"></span><span class="checkmark"></span><span class="toslabel">I agree to <a class="link" href="#">terms of service</a></span>
                </label>
            </div>
            </form>
            <p class="error" id="error"><?php echo $error; ?></p>
        </div>
        
        <div class="thankspanel" id="thankspanel" <?php if(!$subscribed) {echo 'style="display: none"';}?>>
            <img src="images/thanks.png" class="thanksimage">
            <h1 class="thanksheading">Thanks for subscribing!</h1>
            <p class="thanksmessage">You have successfully subscribed to our email listing.<br>
            Check your email for the discount code.</p>
        </div>
        
        <hr class="hbar">
        <div class="socialmediapanel">
            <a class="buttonfacebook" href="#"></a>
            <a class="buttoninstagram" href="#"></a>
            <a class="buttontwitter" href="#"></a>
            <a class="buttonyoutube" href="#"></a>
        </div>
    </div>
</body>
</html>