<?php
require_once('classes/database.php');
session_start();
include('includes/user_navbar.php');

if (isset($_POST['room_id'])) {
  $roomId = $_POST['room_id'];
  $roomName = $_POST['room_name'];
  $roomPrice = $_POST['price'];
  $roomFacilities = $_POST['facilities'];  

  $result = $con->update_room($roomId, $roomName, $roomPrice, $roomFacilities);
  if($result){
      echo "<script type='text/javascript'>
          alert('Room Updated');
        </script>";
      } else {
        echo "<script type='text/javascript'>
          alert('Something went wrong!!');
        </script>";
      }
}
?>

<style>
  .edit {
    padding: unset;
    width: 10rem;
  }
  .edit-picture {
    padding: unset;
    width: 10rem;
  }
  .action-container {
    display: flex;
  }
  .room-picture {
    width: 99%;
  }
  .room-container {
    justify-content: center;
  }
</style>
<div class="container my-3">
    
  <?php

    $sql="SELECT *
    FROM
    rooms";
    $result = mysqli_query($dbcon, $sql);
    if($result)
    {
      if(mysqli_num_rows($result) > 0)
      {
        while($row = mysqli_fetch_array($result))
        {
         
  ?>
  <div class="row">
    <div class="col-md-12">
      <div class="profile-info">
        <div class="info-header">
          <h3>Reservation Information</h3>
        </div>
        <div class="row room-container">
          <div class="info-body col-md-4">
            <p><strong>Room ID: </strong><?php echo $row['room_id'] ?> </p>
            <p id="roomname<?php echo $row['room_id'];  ?>"><strong>Room Name: </strong><?php echo $row['room_name'] ?></p>
            <p id="price<?php echo $row['room_id']; ?>"><strong>Price: </strong><?php echo $row['room_price'] ?></p>
            <p id="facility<?php echo $row['room_id'];  ?>"><strong>Facility: </strong> <?php echo $row['facility'] ?></p>    
            <input type="hidden" id="facility<?php echo $row['room_id'];  ?>" value="<?php echo $row['picture'] ?>">
            <div class="action-container">
              <button class="dropdown-item edit-picture" href="#" data-toggle="modal" data-target="#changeRoomPictureModal" value="<?php echo $row['room_id']; ?>"><i class="fas fa-image"></i> Replace Picture</button>
              <button class="dropdown-item edit"  href="#" data-toggle="modal" data-target="#editRoomModal" value="<?php echo $row['room_id']; ?>"><i class="fas fa-edit"></i> Edit</button>   
            </div>      
          </div>
          <div class="info-body col-md-4">
            <img class="room-picture" src="<?php echo $row['picture']; ?>" alt="room image">
          </div>
        </div>
      </div>
    </div>
  </div>   
      
  <?php
        }
      }
    }
  ?>
</div>

<!-- Modal for Update Room -->
<div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="editRoomModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateRoomForm" method="POST">       
        <div class="form-group">
          <label for="room_name">Name</label>
          <input type="hidden" class="form-control" id="room_id" name="room_id">   
          <input type="string" class="form-control" id="room_name" name="room_name" required>
          <div id="room_name" class="invalid-feedback"></div>
        </div>
        
        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" class="form-control" id="price" name="price" required>
          <div id="price" class="invalid-feedback"></div>
        </div>
        <div class="form-group">
          <label for="facilities">Facilities</label>
          <input type="text" class="form-control" id="facilities" name="facilities" required>
          <div id="facilities" class="invalid-feedback"></div>
        </div>
        
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="updateroom" id="saveChangesBtn">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Picture -->
<div class="modal fade" id="changeRoomPictureModal" tabindex="-1" role="dialog" aria-labelledby="changeRoomPictureModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="uploadRoomPicForm" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadRoomPicModalLabel">Change Room Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="room_id-picture" name="room_id-picture">   
                    <input type="file" class="form-control form-control-file" id="roomPictureInput" name="room_picture" accept="image/*" required>
                    <small id="fileSizeError" class="form-text text-danger" style="display:none;">File size exceeds 5MB</small>
                </div>
                <div class="form-group">
                    <img id="imagePreview" src="#" alt="Image Preview" style="display:none; width: 100%; height: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        </div>
      </div>


<script>
$(document).ready(function(){
	$(document).on('click', '.edit', function(){
		var id=$(this).val();
		var roomname=$('#roomname'+id).text();
		var roomprice=$('#price'+id).text();
		var facility=$('#facility'+id).text();

    roomname = roomname.split(': ');
    roomprice = roomprice.split(': ');
    facility = facility.split(': ');
 
		$('#edit').modal('show');
		$('#room_id').val(id);
		$('#room_name').val(roomname[1]);
		$('#price').val(parseInt(roomprice[1]));
		$('#facilities').val($.trim(facility[1]));
	});
});

$(document).ready(function(){
	$(document).on('click', '.edit-picture', function(){
		var id=$(this).val();
 
		$('#edit-picture').modal('show');
		$('#room_id-picture').val(id);
	});
});

$(document).ready(function() {
        $('#roomPictureInput').change(function() {
            const file = this.files[0];
            if (file) {
                // Check file size
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'File size exceeds 5MB.',
                        icon: 'error'
                    });
                    $('#imagePreview').hide();
                    $('#uploadRoomPicForm').data('valid', false);
                    return;
                } else {
                    $('#fileSizeError').hide();
                    $('#uploadRoomPicForm').data('valid', true);
                }

                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                }
                reader.readAsDataURL(file);
            }
        });

        $('#uploadRoomPicForm').submit(function(event) {
            event.preventDefault();
            if (!$(this).data('valid')) {
                Swal.fire({
                    title: 'Error!',
                    text: 'File size exceeds 5MB.',
                    icon: 'error'
                });
                return;
            }

            const formData = new FormData(this);
            
            $.ajax({
                url: 'upload_room_picture.php', // Change this to your PHP file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response.success) {
                            $('#profilePicPreview').attr('src', response.filepath);
                            $('#changeProfilePictureModal').modal('hide');
                            Swal.fire({
                                title: 'Success!',
                                text: 'Profile picture updated successfully.',
                                icon: 'success'
                            }).then(() => {
                                // Reload the page after displaying the success message
                                window.location.href = window.location.href.split('?')[0];
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.error,
                                icon: 'error'
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: 'Error!',
                            text: e.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while uploading the file.',
                        icon: 'error'
                    });
                }
            });
        });
    });
</script>