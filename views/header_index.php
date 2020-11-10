<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=(isset($this->title)) ? $this->title : 'Wasthra'; ?></title>
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/all.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/canvas.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/wave.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/libs/font-awesome.min.css">
    <script src="<?php echo URL ?>public/js/libs/fontawesome.js"></script>
    <script src="<?php echo URL ?>public/js/libs/jquery.min.js"></script>
</head>

<body>
<div id="preloader-overlay"></div>
<div id="spinner"></div>
    <?php if(Session::get('loggedIn')==true){
    require 'views/user/profile_card.php';
} ?>
    <?php require 'views/error/error_popup.php';?>
    <div class="header" id="header">
        <div class="contaner">
            <div class="navbar">
                <div class="logo">
                    <img src="<?php echo URL;?>public/images/logo.png" width="125px">
                </div>
                
                <nav>
                    <ul id="menuItems">
                    <li><div class="search-bar">
                    <form onsubmit="event.preventDefault();" role="search">
                        <input id="search" type="search" placeholder="Search..." autofocus required />
                        <button type="submit"><i class="fa fa-search"></i></button>    
                    </form>
                </div></li>
                        <li><a href="<?php echo URL; ?>">Home</a></li>
                        <li><a href="<?php echo URL; ?>shop">Shop</a></li>
                        <li><a href="<?php echo URL; ?>contact">Contact Us</a></li>
                        <?php if(Session::get('loggedIn')!==true): ?>
                            <li><a href="<?php echo URL;?>login" onclick="passScreenSize()">Login/Signup</a></li>
                        
                        <?php endif;
                         if(Session::get('loggedIn')==true && Session::get('userType')=='customer'): ?>
                            <li><a href="<?php echo URL;?>orders/myOrders">My Orders</a></li>
                            <li><a href="#">Wishlist</a></li>
                            <?php endif; ?>
                    </ul>
                </nav>

                <?php if(Session::get('loggedIn')==true): ?>
                            <div class="user-box">
                                <div class="user-info"><p>Hi, <?php echo Session::get('firstName')?>!</p></div>
                                <a class="user-box-btn" href="#profile-card">
                                    <i class="fa fa-user-circle-o fa-2x"></i>
                                </a>
                            </div>
                <?php endif; ?>
                
                <a class="bag" id="bag" <?php if(Session::get('loggedIn')=='true'){?>onclick="bagDown()"<?php } else{?>href="<?php echo URL;?>login?loginRequired=true"<?php }?>><i class="fa fa-shopping-bag fa-2x"></i><span class="badge">3</span></a>
                
                <img src="<?php echo URL; ?>public/images/menu.png" class="menu-icon" onclick="menuToggle()">
            </div>
            <?php require 'views/shop/cart_dropdown.php'; ?>
            <div class="row">
                <div class="col-2">
                    <h1>It's all about <br>clothing!</h1>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. A praesentium aspernatur molestias
                        dolor eius inventore voluptatem nostrum consequuntur dolorem. <br>Vero tempore deserunt hic
                        laboriosam eligendi eos maiores ad. Consequuntur, ipsum.</p>
                    <a href="" class="btn">Shop Now &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="<?php echo URL; ?>public/images/image1.png">
                </div>
            </div>
        </div>
    </div>
    <div class="loader"></div>
    <div class="area" id="area">
            <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
            </ul>
            </div>
    <script type="text/javascript" src="<?php echo URL ?>public/js/preloader.js"></script>
    <script>
        $(window).ready(function() {
   $('#area').height(
        $('#header').height()
    );
});
    $(window).resize(function() {
   $('#area').height(
        $('#header').height()
    );
});


        function passScreenSize(){
            var size = $(window).width();
            document.getElementById('screen-size').value = size;
            document.getElementById('login-redirect').submit();

        }
        
    

</script>