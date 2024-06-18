<?php
include_once 'admin/include/class.user.php'; 
$user=new User();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Resort Booking</title>

    <!-- Bootstrap -->
    <link href="css1/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.css">

    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    
    
    <style>
          
        .well {
            background: rgba(0, 0, 0, 0.7);
            border: none;
            height: 200px;
        }
        
        body {
            background-image: url('images/loginbackground.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        h4 {
            color: #ffbb2b;
        }
        h6
        {
            color: navajowhite;
            font-family:  monospace;
        }
        .room-img {
            height: 10rem;
        }
        .action-container {            
            display: flex;
            align-items: center;
        }


    </style>
    
    
</head>

<body>
    <div class="container">
      
      
       <img class="img-responsive" src="images/home_banner.jpg" style="width:100%; height:180px;">      
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="room.php">Room &amp; Facilities</a></li>
                    <li><a href="review.php">Review</a></li>
                
                </ul>

                <div id="click_here">
                    <a href="index.php">Back to Home</a>
                </div>
                
            </div>
        </nav>
        
        
    <?php
        
        $sql="SELECT * FROM rooms";
        $result = mysqli_query($dbcon, $sql);
        if($result)
        {
            if(mysqli_num_rows($result) > 0)
            {
//               ********************************************** Show Room Category***********************
                while($row = mysqli_fetch_array($result))
                {
    ?>
        <div class='row'>
            <div class='col-md-3'></div>
                <div class='col-md-12 well'>
                    <div class="row">
                        <div class="col-md-7">
                            <h4><?php echo $row['room_name'];?></h4><hr>
                            <h6>Facilities: <?php echo $row['facility'];?></h6>
                            <h6>Price: <?php echo $row['room_price'];?> tk/night.</h6>
                        </div>
                        <div class="col-md-3">
                            <img class="room-img" src="<?php echo $row['picture'];?>" alt='room image'>
                        </div>
                        <div class="col-md-2 action-container">
                            <?php
                            echo "<a href='./booknow.php?room_id=".$row['room_id']."&room_name=".$row['room_name']."'><button class='btn btn-primary button'>Book Now</button> </a>";
                            ?>
                        </div>
                    </div>                    
                </div>  
            </div>
                    
                   
    <?php 
                }
                
                
                          
            }
            else
            {
                echo "NO Data Exist";
            }
        }
        else
        {
            echo "Cannot connect to server".$result;
        }
    ?>


</div>
    
    
    
    
    





    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>