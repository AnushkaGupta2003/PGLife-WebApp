<?php
session_start();
require "includes/database_connect.php";
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$property_id= $_GET["property_id"];
$sql="SELECT * FROM properties WHERE id='$property_id' ";
 $result=mysqli_query($conn, $sql);
 if (!$result) {
    echo "Something went wrong!";
    return;
}
$property=mysqli_fetch_assoc($result);

$sql="SELECT *, cities.name AS city_name  FROM properties INNER JOIN cities ON properties.city_id = cities.id  WHERE properties.id=$property_id";

$result=mysqli_query($conn, $sql);
if (!$result) {
    echo "Something went wrong!";
    return;
}

$property_city= mysqli_fetch_assoc($result);
if (!$property_city) {
    echo "Something went wrong!";
    return;
}

$sql = "SELECT * 
            FROM interested_users_properties 
            INNER JOIN properties  ON interested_users_properties.property_id = properties.id
            WHERE properties.id = $property_id";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Something went wrong!";
    return;
}
$interested_users_properties = mysqli_fetch_all($result, MYSQLI_ASSOC);
$sql = "SELECT * 
            FROM properties_amenities 
            INNER JOIN amenities  ON properties_amenities.amenity_id = amenities.id
            WHERE properties_amenities.property_id = $property_id";
 $result = mysqli_query($conn, $sql);
if (!$result) {
echo "Something went wrong!";
return;
            }
 $amenities=mysqli_fetch_all($result, MYSQLI_ASSOC);

 $sql="SELECT * FROM testimonials  WHERE property_id=$property_id";
 $result = mysqli_query($conn, $sql);
 if (!$result) {
    echo "Something went wrong!";
    return;
                }
     $testimonials=mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$property['name'];?>| PG Life</title>
     <?php
     include "includes/head_links.php";
     ?>
    
    <link href="css/property_detail.css" rel="stylesheet" />
</head>

<body>
    
<?php
     include "includes/header.php";
     ?>
    <div id="loading">
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="property_list.php?city=<?=$property_city['city_name']?>"><?=$property_city["city_name"];?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
               <?=$property['name'];?>
            </li>
        </ol>
    </nav>

    <div id="property-images" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
        <?php
         $prop_images=glob("img/properties/".$property_id."/*");
         foreach($prop_images as $index => $prop_image){
         ?>
            <li data-bs-target="#property-images" data-bs-slide-to="<?= $index ?>" class="<?= $index==0 ? "active" : "" ;?>"></li>
        <?php
         }
         ?>
            
        </ol>
        <div class="carousel-inner">
        <?php
         
         foreach($prop_images as $index => $prop_image){
         ?>
            <div class="carousel-item <?= $index== 0 ? "active" : "";?>">
               
                <img class="d-block w-100" src="<?=$prop_image ?>" alt="slide">
            </div>
            <?php } 
            ?>
          
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
      
    <div class="property-summary page-container">
        <div class="row no-gutters justify-content-between">
        <?php
            $total_rating = ($property['rating_clean']+$property['rating_food']+$property['rating_safety'])/3;
            $total_rating = round($total_rating,1);
            
            ?>
            <div class="star-container" title="$total_rating">
                    <?php
                     $rating=$total_rating;
                     for ($i = 0; $i < 5; $i++) {
                        if ($rating >= $i + 0.8) {?>
                        <i class="fas fa-star"></i>
                        <?php 
                        }
                        elseif ($rating >= $i + 0.3) {?>
                        <i class="fas fa-star-half-alt"></i>
                        <?php
                        } else {?>
                        <i class="far fa-star"></i>
                     <?php 
                        }
                     }
                     ?>
                
             </div>
            <div class="interested-container">
                        <?php
                        $is_interested = false;
                        $is_interested_count = count($interested_users_properties);
                        foreach($interested_users_properties as $iup){
                                if($iup['user_id']== $user_id){
                                    $is_interested=true;
                                    break;
                                }
                        }
                        
                        if( $is_interested) { ?>
                        <i class="fas fa-heart"></i>
                        <?php
                         }
                          else {
                        ?>
                        <i class="far fa-heart"></i>
                        <?php 
                          }
                          ?>
                
                <div class="interested-text">
                    <span class="interested-user-count"><?=$is_interested_count?></span> interested
                </div>
            </div>
        </div>
        <div class="detail-container">
            <div class="property-name"><?=$property['name']?></div>
            <div class="property-address"><?=$property['address']?></div>
            <div class="property-gender">
                        <?php
                        if($property['gender']== 'male'){ ?>
                        <img src="img/male.png" />
                        <?php
                        }
                        else if($property['gender']== 'female') { ?>
                        <img src="img/female.png" />
                        <?php
                       } else { ?>
                        <img src="img/unisex.png" />
                        <?php
                       } ?>
             </div>
        </div>
        <div class="row no-gutters">
            <div class="rent-container col-6">
                <div class="rent">Rs <?=$property['rent']?>/-</div>
                <div class="rent-unit">per month</div>
            </div>
            <div class="button-container col-6">
                <a href="#" class="btn btn-primary">Book Now</a>
            </div>
        </div>
    </div>

    <div class="property-amenities">
        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                
                <div class="col-md-auto">
                    <h5>Building</h5>
                    <?php
                   foreach($amenities AS $amenity ){
                    if($amenity['type']== 'Building') { ?>
                    <div class="amenity-container">
                        <img src="img/amenities/<?= $amenity['icon']?>.svg">
                        <span><?= $amenity['name']?></span>
                    </div>
                    <?php } }  ?>
                </div>
                
                
                <div class="col-md-auto">
                    <h5>Common Area</h5>
                    <?php
                    foreach($amenities AS $amenity ){
                        if($amenity['type']== 'Common Area'){ ?>
                    <div class="amenity-container">
                        <img src="img/amenities/<?= $amenity['icon']?>.svg">
                        <span><?= $amenity['name']?></span>
                    </div>
                    <?php } } ?>
                    
                </div>
                
                <div class="col-md-auto">
                    <h5>Bedroom</h5>
                  <?php  
                  foreach($amenities AS $amenity ){
                  if($amenity['type']== 'Bedroom'){ ?>
                    <div class="amenity-container">
                        <img src="img/amenities/<?= $amenity['icon']?>.svg">
                        <span><?= $amenity['name']?></span>
                    </div>
                    <?php } } ?>
                </div>
                
                
                <div class="col-md-auto">
                    <h5>Washroom</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Washroom") {
                    ?>
                    <div class="amenity-container">
                        <img src="img/amenities/<?= $amenity['icon']?>.svg">
                        <span><?= $amenity['name']?></span>
                    </div>
                    <?php } } ?>
                </div>
               
            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Property</h1>
        <p><?=$property['description']?></p>
    </div>

    <div class="property-rating">
        <div class="page-container">
            <h1>Property Rating</h1>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-broom"></i>
                            <span class="rating-criteria-text">Cleanliness</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_clean']?>">
                         <?php
                         $rating = $property['rating_clean'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>  
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-utensils"></i>
                            <span class="rating-criteria-text">Food Quality</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_food']?>">
                           <?php
                            $rating = $property['rating_food'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fa fa-lock"></i>
                            <span class="rating-criteria-text">Safety</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?=$property['rating_safety']?>">
                            <?php
                            $rating = $property['rating_safety'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rating-circle">
                        <?php
                        $rating= $total_rating; ?>
                        <div class="total-rating"><?= $rating?></div>
                        <div class="rating-circle-star-container">
                            <?php
                        $rating = $property['rating_clean'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="property-testimonials page-container">
        <h1>What people say</h1>
        <?php
        foreach($testimonials AS $testimonials){ ?>
        <div class="testimonial-block">
            <div class="testimonial-image-container">
                <img class="testimonial-img" src="img/man.png">
            </div>
            <div class="testimonial-text">
                <i class="fa fa-quote-left" aria-hidden="true"></i>
                <p><?=$testimonials['content']?></p>
            </div>
            <div class="testimonial-name">- <?=$testimonials['user_name']?></div>
        </div>
        <?php } ?>
        
    </div>

    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
     include "includes/footer.php";
     ?>
    
</body>

</html>
