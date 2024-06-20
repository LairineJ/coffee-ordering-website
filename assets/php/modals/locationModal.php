<?php include "../assets/connection.php";
session_start();

$custEmail = $_SESSION['custEmail'];

$sql = "select address from customer where email = '$custEmail'";
$sqlrun = mysqli_query($conn, $sql);
if($sqlrun){
    $result = mysqli_fetch_assoc($sqlrun);
    $prevLoc = $result['address'];
}
?>

<form id="locationForm" action="index.php" method="POST" enctype="multipart/form-data">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Customize the modal header to remove the close button -->
                <h5 class="modal-title" id="locationModalLabel">Location Search</h5>
                <!-- No close button here -->
            </div>
            <div class="modal-body">
                <div class="logMap" style="display: flex; align-items: center; justify-content: center; width: 100%;">
                    <input type="text" class="locationInput" id="locationInput" name="locationInput" value= "<?php echo $prevLoc ?>" style="width: 50%;" >
                    <button type="button" onclick="searchLocation()" class="logMapBtn">Set Location</button>
                </div>
                <hr>
                <!-- Map container inside modal body -->
                <div id="locationMapContainer" style="height: 300px;"></div>
            </div>
            <div class="modal-footer">
                <div class="logMapBtnFooter" style="display: flex; align-items: center; justify-content: center; width: 100%;">
                    <button type="submit" id="confirmButton" class="locationBtn" name="locationBtn" disabled>Confirm</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var locationInput = document.getElementById('locationInput');
    var confirmButton = document.getElementById('confirmButton');

    // Add event listener to locationInput
    locationInput.addEventListener('input', function() {
        // Enable or disable the confirmButton based on the input value
        confirmButton.disabled = true;
    });
</script>

<style>
.logMapBtn{
    background-color: #562B08;
    border: none;
    color: #fff;
    font-size: 1rem;
    padding: 20px 15px 20px 15px;
    border-radius: 0 15px 15px 0;
    border: none;
    border-bottom: 1px solid #4b3619;
}

.logMap input {
    font-family: 'Poppins';
    border-radius: 15px 0 0 15px;
    outline: none;
    background-color: rgb(244, 244, 244);
    font-size: 1rem;
    color: #000;
    border: none;
    border-bottom: 1px solid #c2c4c3;
    padding: 20px 10px 20px 5px;
}
.locationInput{
    display: flex;
    align-items: center;
    border-bottom: 1px solid #c2c4c3;
    transition: .5s ease;
  }

.logMap input:hover{
    border-bottom: 1px solid #4b3619;
  }

.locationBtn{
    outline: none;
    border: none;
    width: 30%;
    height: 50px;
    border-radius: 30px;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
    background-color: #562B08;
    box-shadow: 1px 1px 5px #000,
                -1px -1px 5px #fff; 
    transition: .5s;
  }

.locationBtn:hover{
    background-color: #6F4E37;
  }
.locationBtn:disabled {
    background-color: #ccc; 
    color: #999;
    cursor: not-allowed; 
}
</style>
<script src="../app.js"></script>