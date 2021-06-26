<?php
require "app.php";
session_start();

$productModel = new Product();
$protypeModel = new Protypes();
$manuFacturesModel = new ManuFactures();
$cartModel = new Cart();
$commentModel = new Comment();
$evaluteModel = new Evalute();


$protypes = $protypeModel->getAllProtypes();
$manuFactures = $manuFacturesModel->getAllManuFactures();


// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
// }
// Hiển thị giỏ hàng user
$checkComment = false;
// Lấy id sản phẩm
if (isset($_GET['id'])) {
    $check = false;
    $products = $productModel->getProductsFromID($_GET['id']);
    $productsTypes = $productModel->getProductsPrototype($products->type_id);
    $comments = $commentModel->getAllCommentById_Product($_GET['id']);
    $evalutes = $evaluteModel->getAllevaluteByID_product($_GET['id']);
    $_SESSION['id'] = $_GET['id'];
    if (isset($_SESSION['username'])) {
        $carts = $cartModel->getAllProductOnUsernameInCard($_SESSION['username']);
        $registrationCarts = $cartModel->getAllProductOrderOnUsername($_SESSION['username']);
          // Kiểm tra user đã đăng ký sản phẩm chưa
        foreach ($registrationCarts as $registra) {
            if ($registra['id_product'] == $_SESSION['id']) {
                $checkComment  = true;
                break;
            }
        }
        $content =  $commentModel->getCommentUsernameById_Product($_SESSION['username'], $_GET['id']);   
        if ($content == null && $checkComment == true) {
            $check = true;
        }
    }
    
    
    
    
}

// Lấy nội dung comment


if (isset($_GET['comment'])) {
    $_SESSION['comment'] = $_GET['comment'];
    //header("Location: handComment.php?id=$_SESSION[id]&comment=$_SESSION[comment]");
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Product Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">


    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Owl Carousel min css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">

    <style>
        .product__small__images {
            margin-top: 20px;
        }

        button {
            background: white;
            color: black;
            padding: 2px;
            padding-left: 10px;
            padding-right: 10px;
            border: 1px solid black;
        }

        button:hover {
            background: red;
            color: black;
            padding: 2px;
            padding-left: 10px;
            padding-right: 10px;
            border: 1px solid black;
        }
    </style>
    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
</head>
<style>
    .ht__cat__thumb {
        display: block;
        height: auto;
        margin: auto;
        cursor: pointer;
        max-width: 100%;
        width: 250px;
        height: 250px;
    }

    .category {
        height: 500px;
    }

    .htc__comment__area {
        margin-top: 33px;
        margin-bottom: 230px;
    }

    input.comment_username {
        width: 1160px;
        height: 70px;
        padding: 10px;
    }

    button.comment_username {
        background: white;
        color: black;
        padding: 2px;
        padding-left: 10px;
        padding-right: 10px;
        border: 1px solid black;
        margin-left: 1108px;
        margin-top: 10px;
    }

    input.evalute {
        margin-bottom: 40px;
    }
</style>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper">
        <!-- Start Header Style -->
        <header id="htc__header" class="htc__header__area header--one">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
                                <div class="logo">
                                    <a href="index.php"><img src="admin/images/mobile-store-logo_8050-351.jpg" alt="logo images"></a>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-8 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                    <li class="drop"><a href="index.php">Trang Chủ</a></li>
                                        <li class="drop"><a href="allProduct.php">Tất Cả Sản Phẩm</a></li>
                                        
                                        <li class="drop"><a href="#">Danh Mục</a>
                                            <ul class="dropdown">
                                                <?php foreach ($protypes as $protype) { ?>
                                                    <li class="drop"><a href="product-grid.php?type=<?php echo $protype['type_id'] ?>"><?php echo $protype['type_name'] ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <li class="drop"><a href="#">Hãng</a>
                                            <ul class="dropdown">
                                                <?php foreach ($manuFactures as $manuFactures) { ?>
                                                    <li class="drop"><a href="product-grid.php?type=<?php echo $manuFactures['manu_id'] ?>"><?php echo $manuFactures['manu_name'] ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-md-3 col-lg-2 col-sm-4 col-xs-4">
                                <div class="header__right">
                                    <div class="header__search search ">
                                        <form action="result.php" method="get">
                                            <input type="text" placeholder="Tìm kiếm..." name="key" />
                                        </form>
                                    </div>
                                    <div class="header__account">
                                        <a href="#"><i class="icons"></i></a>
                                    </div>
                                    <div style="margin-right:10px" class="htc__shopping__cart">
                                        <a class="cart__menu" href="#"><i class="icon-handbag icons"></i></a>
                                        <?php if(isset($_SESSION['username'])){ ?>
                                            <a href="#"><span class="htc__qua cart__menu"><?php echo count($carts) ?></span></a>
                                        <?php } else {?>
                                            <a href="#"><span class="htc__qua cart__menu">0</span></a>
                                        <?php } ?>
                                    </div>
                                    <div class="header__account">
                                    </div>
                                    <?php if(isset($_SESSION['username'])){ ?>
                                        <a class="logout" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                                    <?php } else {?>
                                        <a class="logout" href="login.php"><i style="font-size:20px" class="icon-user icons" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Area -->
        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Cart Panel -->
            <div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <?php if(isset($_SESSION['username'])){ ?>
                    <div class="shp__cart__wrap">
                        <?php $fulltotal = 0;
                        foreach ($carts as $cart) { ?>
                            <?php $total = $cart['price'] *  $cart['amount_product'];
                            $fulltotal += $total; ?>
                            <div class="shp__single__product">
                                <div class="shp__pro__thumb">
                                    
                                        <img src="images\<?php echo $cart['pro_image'] ?>" alt="product images">
                                    
                                </div>
                                <div class="shp__pro__details">
                                    <h2><a href="product-details.php?id=<?php echo $cart['id'] ?>"><?php echo $cart['name'] ?></a></h2>
                                    <span class="quantity">Amount:  <?php echo $cart['amount_product']." VND" ?> VND</span>
                                    <span class="shp__price"><?php echo number_format($total) ." VND"; ?> </span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <ul class="shoping__total">
                        <li class="subtotal">Subtotal:</li>
                        <li class="total__price"><?php echo number_format($fulltotal)  . " VND"; ?></li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart.php">Xem giỏ hàng</a></li>
                    </ul>
                    <?php } else { ?>
                        <ul class="shoping__total">
                            <li class="subtotal">Vui lòng đăng nhập để xem giỏ hàng</li>
                        </ul>
                        <ul class="shopping__btn">
                            <li><a href="login.php">Đăng Nhập</a></li>
                        </ul>
                    <?php }  ?>
                </div>
            </div>
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.php">Trang Chủ</a>
                                    <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                    <a class="breadcrumb-item" href="allProduct.php">Sản Phẩm</a>
                                    <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                    <span class="breadcrumb-item active">
                                      
                                         <a href=""><?php echo $products->name ?> </a>
                                       
                                    </span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                            <img src="images/<?php echo $products->pro_image ?>" alt="full-image">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $products->name; ?></h2>
                                <h6> <span> </span></h6>
                                <ul class="rating">
                                    <?php $tongdiem = 0;
                                    foreach ($evalutes as $evalute) {
                                        $tongdiem += $evalute['point'];
                                    }
                                    if (count($evalutes) == 0) {
                                        $danhgia = 0;
                                    } else {
                                        $danhgia =  (float)$tongdiem / (int)count($evalutes);
                                    }
                                    ?>
                                    <li>
                                        <?php for ($i = 0; $i < $danhgia; $i++) : ?>
                                            <i class="fa fa-star" aria-hidden="true" style="color: yellowgreen"></i>
                                        <?php endfor ?>
                                        <?php for ($i = 0; $i < 5 - $danhgia; $i++) : ?>
                                            <i class="fa fa-star-o" aria-hidden="true" style="color: yellowgreen"></i>
                                        <?php endfor ?>
                                    </li>
                                    <li>| <?php echo count($evalutes); ?></li>
                                    <li>Evaluate</li>
                                </ul>
                                <ul class="pro__prize">
                                    <li><?php echo number_format($products->price); ?></li>
                                </ul>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
                                        <p><span>Type:</span> <?php echo $products->type_name ?></p>
                                    </div>
                                    <div class="_2O0llP">
                                        <?php if ($products->status == 1) { ?>
                                            <a href="handlingCart.php?id=<?php echo $products->id ?>"><button>Thêm Vào Giỏ Hàng</button></a>
                                        <?php } else {
                                            echo "<p>Sản phẩm này đã bị xóa, bạn không thể thêm vào giỏ hàng.</p>"; ?>
                                        <?php } ?>
                                    </div>
                                    <div class="sin__desc product__share__link">
                                        <p><span>Share this:</span></p>
                                        <ul class="pro__share">
                                            <li><a href="#" target="_blank"><i class="icon-social-twitter icons"></i></a></li>

                                            <li><a href="#" target="_blank"><i class="icon-social-instagram icons"></i></a></li>

                                            <li><a href="https://www.facebook.com/Furny/?ref=bookmarks" target="_blank"><i class="icon-social-facebook icons"></i></a></li>

                                            <li><a href="#" target="_blank"><i class="icon-social-google icons"></i></a></li>

                                            <li><a href="#" target="_blank"><i class="icon-social-linkedin icons"></i></a></li>

                                            <li><a href="#" target="_blank"><i class="icon-social-pinterest icons"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
        <!-- End Product Details Area -->
        <!-- Start Product Description -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">Mô tả</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                    <p></p>
                                    <p><?php echo $products->description ?></p>
                                    <p></p>
                                </div>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Description -->
        <div class="container">
        </div>
        <div class="container">
        <?php 
             if ($check == true) { ?>
                <form action="handComment.php">
                    <h4 class="title__line--5">Đánh giá</h4>
                    <input class="evalute" min=1 max=5 type="number" name="evalute" value="5" required>
                    <input name="comment" class="comment_username" maxlength="10000" placeholder="Hãy chia sẻ những gì bạn thích về sản phẩm này.." required>
                    <button class="comment_username" type="submit">Gửi</button>
                </form>
            <?php } else { ?>
                <form action="handComment.php">
                <input class="evalute" type="hidden" name="evalute" value="0" required>
                    <input name="comment" class="comment_username" maxlength="10000" placeholder="Thêm bình luận..." required>
                    <button class="comment_username" type="submit">Gửi</button>
                </form>
                <?php } ?>
             
        </div>
        <!-- Start Comment Area -->
        <div class="container">
            <div class="htc__comment__area">
           
                <h4 class="title__line--5">Có <?php echo count($comments); ?> bình luận</h4>
                <div class="ht__comment__content">
                    <?php foreach ($comments as $comment) {
                         ?>
                            <!-- Start Single Comment -->
                            <div class="comment">
                                <div class="comment__thumb">
                                </div>
                                <div class="ht__comment__details">
                                    <div class="ht__comment__title">
                                        <h2><?php echo $comment['fullname']; ?></h2>
                                    </div>
                                    <p><?php echo $comment['content']; ?></p>
                                </div>
                            </div>
                            <!-- End Single Comment -->
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- End Comment Area -->
        <!-- Start Product Area -->
        <section class="htc__product__area--2 pb--100 product-details-res">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Sản Phẩm Liên Quan</h2>
                            <p>Khám phá những sản phẩm khác</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__wrap clearfix">
                        <!-- Start Single Product -->
                        <?php foreach ($productsTypes as $productsType) { ?>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product-details.php?id=<?php echo $productsType['id']; ?>">
                                            <img src="images\<?php echo $productsType['pro_image'] ?>" alt="product images">
                                        </a>
                                    </div>
                                    <div style="padding-top: 50px" class="fr__product__inner">
                                        <h4><a href="product-details.php?id=<?php echo $productsType['id']; ?>"><?php echo $productsType['name'] ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li><?php echo number_format($productsType['price']); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End Single Product -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Area -->

        <!-- End Banner Area -->
        <!-- Start Footer Area -->
        <footer id="htc__footer">
            <!-- Start Footer Widget -->
            <div class="footer__container bg__cat--1">
                <div class="container">
                    <div class="row">
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="footer">
                                <h2 class="title__line--2">ABOUT US</h2>
                                <div class="ft__details">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim</p>
                                    <div class="ft__social__link">
                                        <ul class="social__link">
                                            <li><a href="#"><i class="icon-social-twitter icons"></i></a></li>

                                            <li><a href="#"><i class="icon-social-instagram icons"></i></a></li>

                                            <li><a href="#"><i class="icon-social-facebook icons"></i></a></li>

                                            <li><a href="#"><i class="icon-social-google icons"></i></a></li>

                                            <li><a href="#"><i class="icon-social-linkedin icons"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40">
                            <div class="footer">
                                <h2 class="title__line--2">information</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                        <li><a href="#">About us</a></li>
                                        <li><a href="#">Delivery Information</a></li>
                                        <li><a href="#">Privacy & Policy</a></li>
                                        <li><a href="#">Terms & Condition</a></li>
                                        <li><a href="#">Manufactures</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40 smt-40">
                            <div class="footer">
                                <h2 class="title__line--2">my account</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="cart.html">My Cart</a></li>
                                        <li><a href="#">Login</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40 smt-40">
                            <div class="footer">
                                <h2 class="title__line--2">Our service</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="cart.html">My Cart</a></li>
                                        <li><a href="#">Login</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-3 col-sm-6 col-xs-12 xmt-40 smt-40">
                            <div class="footer">
                                <h2 class="title__line--2">NEWSLETTER </h2>
                                <div class="ft__inner">
                                    <div class="news__input">
                                        <input type="text" placeholder="Your Mail*">
                                        <div class="send__btn">
                                            <a class="fr__btn" href="#">Send Mail</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                    </div>
                </div>
            </div>
            <!-- End Footer Widget -->
            <!-- Start Copyright Area -->
            <!-- End Copyright Area -->
        </footer>
        <!-- End Footer Style -->
    </div>
    <!-- Body main wrapper end -->

    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>

</body>

</html>