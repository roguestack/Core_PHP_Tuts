<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once 'db_config.php';

$result= $conn->query("SELECT * FROM countries");
$result = $result->fetchAll();
// echo "<pre>"; 
// print_r($result);
//exit;
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <title>DropDown Demo</title>
</head>
<body>
<div class="container-fluid">
  <form class="form-horizontal">

    <!-- Country Dropdown -->
    <div class="form-group">
      <label class="control-label col-sm-2" for="country">Country:</label>
      <div class="col-sm-10">
          <select id="country-dropdown" class="form-control">
              <option value=""> Select Country </option>
              <?php foreach($result as $res){ ?>
              <option value=" <?= $res['id'] ?>"><?php echo $res['name'] ?>  </option>
              <?php }  ?>

          <!-- <?php  foreach($result as $res ){ 
          // echo  "<option value=''>" .$res['country_name'] . "</option>";
              }  ?>  -->
          </select>
      </div>
    </div>
  
    <!-- State Dropdown -->
    <div class="form-group">
      <label class="control-label col-sm-2" for="state">State:</label>
      <div class="col-sm-10">
      <select id="state-dropdown" class="form-control">
        <option value=" ">Select State</option>
          </select>
      </div>
    </div>
  
    <!-- City Dropdown -->
    <div class="form-group">
      <label class="control-label col-sm-2" for="city">City:</label>
      <div class="col-sm-10">
      <select id="city-dropdown" class="form-control">
          <option value=" "> Select City</option>
        </select>
      </div>
    </div>

  <!-- <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>-->

</form> 
</div> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
  
    $('#country-dropdown').on('change', function() {
    var country_id = this.value;
    $.ajax({
            url: "states.php",
            type: "POST",
        data: {
            country_id: country_id
        },
// cache: false,
success: function(result){
$("#state-dropdown").html(result);
$('#city-dropdown').html('<option value="">Select State First</option>'); 
}
});
});    
$('#state-dropdown').on('change', function() {
    var state_id = this.value;
    $.ajax({
    url: "cities.php",
    type: "POST",
    data: {
    state_id: state_id
},
//cache: false,
success: function(result){
    console.log(result)
$("#city-dropdown").html(result);
}
});
});
});
</script>

</body>
</html>