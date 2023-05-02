<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome | PG Life</title>
  <?php
    include "includes/head_links.php";
    ?>
   
    <link href="css/home.css" rel="stylesheet" />
</head>

<body>
    <?php
    include "includes/header.php";
    ?>
    
    <div class="banner-container">
        <h2 class="white pb-3">Happiness per Square Foot</h2>

        <form id="search-form" method="GET" action="property_list.php">
            <div class= "input-group city-search ">
                <input type="text" class="form-control input-city" id='city' name='city' placeholder="Enter your city to search for PGs" />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
   <div class="majorcity py-70">
    <h1 >Major Cities</h1>
    <div class="citynames ">
    <div id="delhi" >
        <a href="property_list.php?city=Delhi" ><img  src="img/delhi.png"/>  </a> 
    </div>   
    <div id="Mumbai">
        <a href="property_list.php?city=Mumbai" ><img  src="img/mumbai.png"/>  </a> 
    </div>         
    <div id="bengaluru" >
        <a href="property_list.php?city=Bengaluru" ><img  src="img/bangalore.png"/>  </a> 
    </div>   
    <div id="hyderabad" >
        <a href="property_list.php?city=Hyderabad" ><img  src="img/hyderabad.png"/>  </a> 
    </div>    
    </div>    
   </div>

   

    
    
  <?php
    include "includes/login_modal.php";
    include "includes/signup_modal.php";
    include "includes/footer.php";
    ?>
    
</body>

</html>
