<?php

$profile =$block->test();

$shop_title= $profile['profile'];

$shop_title= str_replace('-',' ',$shop_title);
$shop = $block->getShop($shop_title);

if(empty($shop->getData('shop_title'))) {
    echo "<div class='alert alert-danger text-center' > <h4>No shop has this name (' " . $shop_title . " ') </h4>";
    echo "<a href='". $this->getUrl()."' > Go Home </a>";
    echo "</div>";
}else {


    $title = $shop->getData('shop_title');
    $id = $shop->getData('shop_id');
    $customerID = $shop->getData('customer_id');
    $banner = $block->getUrlImage() . $shop->getData('shop_banner');
    $logo = $block->getUrlImage() . $shop->getData('shop_logo');
    $facebook = $shop->getData('facebook_id');
    $twitter = $shop->getData('twitter_id');
    $youtube = $shop->getData('youtube_id');
    $instagram = $shop->getData('instagram_id');
    $contact = $shop->getData('contact_number');
    $tax = $shop->getData('tax_number');
    $return = $shop->getData('return_policy');
    $shipping = $shop->getData('shipping_policy');
    $country = $shop->getData('country');
    $address = $shop->getData('shop_address');
    $desc = $shop->getData('shop_description');

    $products =$block->getProducts($customerID);

// for rates
    $rates = $block->getRates($id);

    $count = count($rates);
    if ($count > 0) {
        $price = 0;
        $value = 0;
        $quality = 0;
        foreach ($rates as $v) {
            $price += $v['price'];
            $value += $v['value'];
            $quality += $v['quality'];
        }
        $price = round($price / $count, 1);
        $value = round($value / $count, 1);
        $quality = round($quality / $count, 1);
        $rate = round(($price + $value + $quality) / 3, 1);
        $ratee = ($rate / 5) * 100;

    }

    ?>

    <div class="shop">
    <div class="container-fluid">

    <!--cover-->
    <div class="cover" style="background:url('<?php echo $banner; ?> ')">
    </div>

    <!--navbar-->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="#"><img class='logo img-responsive img-thumbnail '
                                                      src="<?php echo $logo; ?>" alt=""></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">

                <ul class="nav navbar-nav">
                    <li>
                        <a class="title-cont" href="#">
                            <b class="title"><?php echo $title . "<br>"; ?> </b>
                            <b class="country"><?php echo '<i class="fa fa-map-marker "></i>  ' . $country; ?></b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo rtrim($block->getUrlNav(str_replace(" ", "-", $shop_title)), "/") . "#products"; ?>">Products</a>
                    </li>
                    <li>
                        <a href="<?php echo rtrim($block->getUrlNav(str_replace(" ", "-", $shop_title)), "/") . "#about"; ?>">About</a>
                    </li>
                    <li>
                        <a href="<?php echo rtrim($block->getUrlNav(str_replace(" ", "-", $shop_title)), "/") . "#rate"; ?>">Rate</a>
                    </li>
                    <li>
                        <a href="<?php echo rtrim($block->getUrlNav(str_replace(" ", "-", $shop_title)), "/") . "#policy"; ?>">Return </a>
                    </li>
                    <li>
                        <a href="<?php echo rtrim($block->getUrlNav(str_replace(" ", "-", $shop_title)), "/") . "#policy"; ?>">Shipping </a>
                    </li>
                    <li>
                        <a href="<?php echo rtrim($block->getUrlNav(str_replace(" ", "-", $shop_title)), "/") . "#contact"; ?>">Contact</a>
                    </li>

                </ul>


                <ul class="nav navbar-nav navbar-right">
                    <?php if (!empty($facebook)) echo '<li><a href="' . $facebook . '"><i class="fa fa-facebook"></i> </a></li>'; ?>
                    <?php if (!empty($twitter)) echo '<li><a href="' . $twitter . '"><i class="fa fa-twitter"></i> </a></li>'; ?>
                    <?php if (!empty($instagram)) echo '<li><a href="' . $instagram . '"> <i class="fa fa-instagram"></i> </a></li>'; ?>
                    <?php if (!empty($youtube)) echo '<li><a href="' . $youtube . '"> <i class="fa fa-youtube"></i> </a></li>'; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php

    }
