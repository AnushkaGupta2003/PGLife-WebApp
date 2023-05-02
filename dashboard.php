<?php
 session_start();
 require "includes/database_connect.php";
 
 if(!isset($_SESSION['user_id'])){
    header ("location: index.php");
    exit;
 }
 
 $user_id=$_SESSION['user_id'];
 $sql="SELECT * FROM users WHERE id='$user_id'";
 $result=mysqli_query($conn, $sql);
 if(!$result){
    echo "Something went wrong!";
    exit;
 }
  $user=mysqli_fetch_assoc($result);

  


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PG Life</title>
    <?php
    include "includes/head_links.php";
    ?>
    
    <link href="css/dashboard.css" rel="stylesheet" />
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
            
            <li class="breadcrumb-item active" aria-current="page">
                Dashboard
            </li>
        </ol>
    </nav>
    <div class="profile-container">
        <h1 class="m-20" >My Profile</h1>
        <div >
            <div>
                <i class="fas fa-user profile-img rounded-border justify-content-between"></i>
            </div>
            <div class="detail">
                <div class="name"><b><?php echo $user['full_name']?> </b></div>
                <div class="email"><?php echo $user['email']?> </div>
                <div class="phone"><?php echo $user['phone']?> </div>
                <div class="college"><?php echo $user['college_name']?> </div>
            </div>
            <div class="editpage">
                Edit Profile
            </div>
        </div>
        
   
    </div>
    
    <div class="interested container-fluid ">
        <div class="row    heading-container "><h1>My Interested Properties</h1></div>
        <div class="property-card row">
            <div class="image-container col-md-4">
                <img src="img/properties/1/eace7b9114fd6046.jpg" />
            </div>
            <div class="content-container col-md-8">
                <div class="row no-gutters justify-content-between">
                    <div class="star-container" title="4.8">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="interested-container">
                        <i class="fas fa-heart color-red"></i>
                        <div class="interested-text"></div>
                    </div>
                </div>
                <div class="detail-container">
                    <div class="property-name">Ganpati Paying Guest</div>
                    <div class="property-address">Police Beat, Sainath Complex, Besides, SV Rd, Daulat Nagar, Borivali East, Mumbai - 400066</div>
                    <div class="property-gender">
                        <img src="img/unisex.png" />
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="rent-container col-6">
                        <div class="rent">Rs 8,500/-</div>
                        <div class="rent-unit">per month</div>
                    </div>
                    <div class="button-container col-6">
                        <a href="property_detail.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="property-card row">
            <div class="image-container col-md-4">
                <img src="img/properties/1/1d4f0757fdb86d5f.jpg" />
            </div>
            <div class="content-container col-md-8">
                <div class="row no-gutters justify-content-between">
                    <div class="star-container" title="4.5">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="interested-container">
                        <i class="fas fa-heart color-red"></i>
                        
                    </div>
                </div>
                <div class="detail-container">
                    <div class="property-name">Navkar Paying Guest</div>
                    <div class="property-address">44, Juhu Scheme, Juhu, Mumbai, Maharashtra 400058</div>
                    <div class="property-gender">
                        <img src="img/male.png" />
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="rent-container col-6">
                        <div class="rent">Rs 9,500/-</div>
                        <div class="rent-unit">per month</div>
                    </div>
                    <div class="button-container col-6">
                        <a href="property_detail.html" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    include "includes/footer.php";
    ?>
    

    
</body>

</html>
