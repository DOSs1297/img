<?php
require_once('classes/database.php');
$con = new database();
session_start();
?>
 <body>

<?php include('includes/user_navbar.php'); ?>

<div class="container my-3">
    
  <?php

    $sql="SELECT
    users.User_Id,
    users.firstname,
    users.lastname,
    users.birthday,
    users.sex,
    users.username, 
    users.password,
    users.user_profile_picture,
    user_address.street,user_address.barangay,user_address.city,user_address.province,
    booking.*,
    rooms.*

    FROM
    users
    JOIN user_address ON users.User_Id = user_address.User_Id
    JOIN booking On users.User_Id = booking.user_id
    JOIN rooms On rooms.room_id = booking.room_id;";
    $result = mysqli_query($dbcon, $sql);
    if($result)
    {
      if(mysqli_num_rows($result) > 0)
      {
        while($row = mysqli_fetch_array($result))
        {
          echo '

          <div class="row">
            <div class="col-md-12">
              <div class="profile-info">
                <div class="info-header">
                  <h3>Reservation Information</h3>
                </div>
                <div class="info-body">
                  <p><strong>Room ID: </strong>'.$row['room_id'].' </p>
                  <p><strong>Room Name: </strong>' . $row ['room_name'].'</p>
                  <p><strong>User: </strong> '. $row ['firstname'].' '.$row ['lastname'].'</p>
                  <p><strong>Pax: </strong>'. $row ['pax'].'</p>
                  <p><strong>Phone: </strong> '. $row ['phone'].'</p>
            
                </div>
              </div>
            </div>
          </div>
            
          <div class="row">
            <div class="col-md-12">
              <div class="address-info">
                <div class="info-header">
                  <h3>Date Information</h3>
                </div>
                <div class="info-body">
                  <p><strong>checkin: </strong>'. date('M-d-Y h:i A',strtotime($row ['check_in'])).'</p>
                  <p><strong>checkout: </strong>'. date('M-d-Y h:i A',strtotime($row ['check_out'])).'</p>
                  
                </div>
              </div>
            </div>
          </div>
      ';
        }
      }
    }
  ?>
</div>
</body>
</html>