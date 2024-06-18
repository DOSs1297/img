<?php
//update this depending on the db setup
$dbcon = mysqli_connect("localhost","root","","hotel") or die ("could not connect database");

class database{

    function opencon(){
        return new PDO('mysql:host=localhost; dbname=hotel', 'root', '');
    }


    // function check($username, $password){
    //     $con = $this->opencon();
    //     $query = "SELECT * from users WHERE username='".$username."'&&password='".$password."'                ";
    //     return $con->query($query)->fetch();
    // }

function check($username, $password) {
        // Open database connection
        $con = $this->opencon();
    
        // Prepare the SQL query
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
    
        // Fetch the user data as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // If a user is found, verify the password
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
    
        // If no user is found or password is incorrect, return false
        return false;
    }

function signup($username, $password, $firstname, $lastname, $birthday, $sex){
        $con = $this->opencon();

// Check if the username is already exists

    $query=$con->prepare("SELECT username FROM users WHERE username =?");
    $query->execute([$username]);
    $existingUser= $query->fetch();
    

// If the username already exists, return false
    if($existingUser){
    return false;
}
// Insert the new username and password into the database
    return $con->prepare("INSERT INTO users(username, password,firstname,lastname,birthday,sex)
VALUES (?, ?, ?, ?, ?, ?)")
           ->execute([$username,$password, $firstname, $lastname, $birthday, $sex]);
           
}

// function signupUser($username, $password, $firstname, $lastname, $birthday, $sex){
//     $con = $this->opencon();


//     // Check if the username is already exists

//     $query=$con->prepare("SELECT username FROM users WHERE username =?");
//     $query->execute([$username]);
//     $existingUser= $query->fetch();
    

// // If the username already exists, return false
//     if($existingUser){
//     return false;
// }
// // Insert the new username and password into the database
//  $con->prepare("INSERT INTO users(username,password,firstname,lastname,birthday,sex)
// VALUES (?, ?, ?, ?, ?, ?)")
//            ->execute([$username,$password, $firstname, $lastname, $birthday, $sex]);
//            return $con->lastInsertId();
// }


function signupUser($firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture)
{
    $con = $this->opencon();
    // Save user data along with profile picture path to the database
    $con->prepare("INSERT INTO users (firstname, lastname, birthday, sex, user_email, username, password, user_profile_picture) VALUES (?,?,?,?,?,?,?,?)")->execute([$firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture]);
    return $con->lastInsertId();
    }
// function insertAddress($User_Id, $street, $barangay, $city, $province){
//     $con = $this->opencon();
//      return $con->prepare("INSERT INTO user_address (User_Id,street, barangay, city,province) VALUES(?, ?, ?, ?, ?)") ->execute([$User_Id, $street, $barangay, $city, $province]);
    
 

// }


function insertAddress($User_Id, $street, $barangay, $city, $province)
{
    $con = $this->opencon();
    return $con->prepare("INSERT INTO user_address (User_Id, street, barangay, city, province) VALUES (?,?,?,?,?)")->execute([$User_Id, $street, $barangay,  $city, $province]);
      
}

function view(){
        $con = $this->opencon();
        return $con->query("SELECT
        users.User_Id,
        users.firstname,
        users.lastname,
        users.birthday,
        users.sex,
        users.username, 
        users.password,
        users.user_profile_picture, 
        CONCAT(
            user_address.street,' ',user_address.barangay,' ',user_address.city,' ',user_address.province
        ) AS address
    FROM
        users
    JOIN user_address ON users.User_Id = user_address.User_Id")->fetchAll();

    }

    
    function delete($id){
        try{
            $con = $this->opencon();
            $con->beginTransaction();

            // Delete user address

            $query = $con->prepare("DELETE FROM user_address
            WHERE User_Id =?");
            $query->execute([$id]);
        
            // Delete user

          
            $query2 = $con->prepare("DELETE FROM users
            WHERE User_Id =?");
            $query2->execute([$id]);

            $con->commit();
            return true; //Deletion successful
} catch (PDOException $e) {
    $con->rollBack();
    return false;
} 

}

function getUserLoggedInData($id) {
    try {
        $con = $this->opencon();
        $query = $con->prepare("SELECT
        users.User_Id,
        users.firstname,
        users.lastname,
        users.birthday,
        users.sex,
        users.username, 
        users.password,
        users.user_profile_picture,
        user_address.street,user_address.barangay,user_address.city,user_address.province
        
    FROM
        users
    JOIN user_address ON users.User_Id = user_address.User_Id
    Where users.User_Id =?;");
        $query->execute([$id]);
        return $query->fetch();
    } catch (PDOException $e) {
        // Handle the exception (e.g. , log error, return empty array. etc.)
        return [];
    
  
        }
}

function viewdata(){
    try {
        $con = $this->opencon();
        $query = $con->prepare("SELECT
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
    JOIN rooms On rooms.room_id = booking.room_id;");
     $query->execute();
        return $query->fetchAll();
    } catch (PDOException $e) {
        // Handle the exception (e.g. , log error, return empty array. etc.)
        return [];
    
  
        }
    }

    function updateUser($User_Id, $username,$password,$firstname, $lastname, $birthday, $sex) {
        try { 
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET username=?, password=?, firstname=?, lastname=?, birthday=?, sex=? WHERE User_Id=?");
            $query->execute([$username, $password, $firstname, $lastname, $birthday, $sex, $User_Id]);
        
            // Update Successful
            $con->commit();
            return true;
        }catch (PDOException $e) {
            // Handle the exception (e.g., log error, return false, etc.)
            $con->rollBack();
            return false;

        }
    }


    function rooms($room_id, $room_cat, $checkin, $checkout, $name, $phone, $book  , $persons	, $checkin_ampm, $checkout_ampm) {
        try { 
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE rooms SET room_id=?, room_cat=?, checkout=?, name=? phone=?, book=? persons=?, checkin_ampm=?, checkout_ampm=?    WHERE User_Id=?");
            $query->execute([$room_id, $room_cat, $checkin, $checkout, $name, $phone, $book  , $persons	, $checkin_ampm, $checkout_ampm]);
        
            // Update Successful
            $con->commit();
            return true;
        }catch (PDOException $e) {
            // Handle the exception (e.g., log error, return false, etc.)
            $con->rollBack();
            return false;
      
        }
      }

      public function update_room($roomid, $roomname, $roomprice, $roomfacilities) {
        try {
        $con = $this->opencon();
        $con->beginTransaction();
        $query= $con->prepare("UPDATE rooms SET room_name=?, room_price=?, facility=? WHERE room_id=?");
        $query->execute([$roomname, $roomprice, $roomfacilities, $roomid]);
        $con->commit();
        return true;
        }
        catch(PDOException $e) {
            // Handle the exception (e.g., log error, return false, etc.)
            $con->rollBack();
            return false; // Update failed
        }
    }
    
        
    // // function check_account_type($username) {
    //     $query = $this->connection->prepare("SELECT account_type FROM users WHERE username = :username");
    //     $query->bindParam(":username", $username);
    //     $query->execute();

    //     $result = $query->fetch(PDO::FETCH_ASSOC);
    //     if ($result) {
    //         return $result['account_type'];
    //     } else {
    //         return false;
    //     }
    // }
        
    
    function validateCurrentPassword($User_Id, $currentPassword) {
        // Open database connection
        $con = $this->opencon();
    
        // Prepare the SQL query
        $query = $con->prepare("SELECT password FROM users WHERE User_Id = ?");
        $query->execute([$User_Id]);
    
        // Fetch the user data as an associative array
        $user = $query->fetch(PDO::FETCH_ASSOC);
    
        // If a user is found, verify the password
        if ($user && password_verify($currentPassword, $user['password'])) {
            return true;
        }
    
        // If no user is found or password is incorrect, return false
        return false;
    }
function updatePassword($userId, $hashedPassword){
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET password = ? WHERE User_Id = ?");
            $query->execute([$hashedPassword, $userId]);
            // Update successful
            $con->commit();
            return true;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log error, return false, etc.)
             $con->rollBack();
            return false; // Update failed
        }
        }
    function updateUserProfilePicture($userID, $profilePicturePath) {
            try {
                $con = $this->opencon();
                $con->beginTransaction();
                $query = $con->prepare("UPDATE users SET user_profile_picture = ? WHERE User_Id = ?");
                $query->execute([$profilePicturePath, $userID]);
                // Update successful`
                $con->commit();
                return true;
            } catch (PDOException $e) {
                // Handle the exception (e.g., log error, return false, etc.)
                 $con->rollBack();
                return false; // Update failed
            }
             }
    
    function updateRoomPicture($room_id, $roomPicturePath) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE rooms SET picture = ? WHERE room_id = ?");
            $query->execute([$roomPicturePath, $room_id]);
            // Update successful`
            $con->commit();
            return true;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log error, return false, etc.)
                $con->rollBack();
            return false; // Update failed
        }
    }


}

    




   