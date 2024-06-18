<?php    
    require_once('classes/database.php');
    $con = new database();

    $id = $_SESSION['User_Id'];

    $roomname=$_GET['room_name'];
    $roomid=$_GET['room_id'];
    if(isset($_REQUEST['submit'])) 
    { 
        extract($_REQUEST);  

        $isRoomFree = $con->check_room_availability($checkin, $checkout,$roomid);
        echo $isRoomFree;
        if($isRoomFree) 
        {
            $isBooked = $con-> book_now($checkin, $checkout, $phone, $roomid, $persons,$id);
            if($isBooked)
            {
                echo "<script type='text/javascript'>
                        alert('Your Room has been booked!!');
                    </script>";
            }
            else 
            {
                echo "<script type='text/javascript'>
                        alert('Unexpected Error Happened. Please Contact Administrator');
                    </script>";
            }
        } else {
            echo "<script type='text/javascript'>
                    alert('Room Is Not Available for the selected Day/Time');
                </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resort Booking</title>
    <link href="css1/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/css/reg.css" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat : 'yy-mm-dd'
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <img class="img-responsive" src="images/home_banner.jpg" style="width:100%; height:180px;">      
        <div class="well">
            <h2>Book Now: <?php echo $roomname; ?></h2>
            <hr>
            <form action="" method="post" name="room_category">
                <div class="form-group">
                    <label for="persons">Number of Persons:</label>
                    <input type="number" class="form-control" name="persons" placeholder="1" min="1" required>
                </div>
                <div class="form-group">
                    <label for="checkin">Check In :</label>&nbsp;&nbsp;&nbsp;
                    <input type="datetime-local"  name="checkin">                    
                </div>
                <div class="form-group">
                    <label for="checkout">Check Out:</label>&nbsp;
                    <input type="datetime-local" name="checkout">
                </div>
                <div class="form-group">
                    <label for="phone">Enter Your Phone Number:</label>
                    <input type="text" class="form-control" name="phone" placeholder="018XXXXXXX" required>
                </div>
                <button type="submit" class="btn btn-lg btn-primary button" name="submit">Book Now</button>
                <br>
                <div id="click_here">
                    <a href="index.php">Back to Home</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
