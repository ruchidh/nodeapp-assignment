<?php
// Include config file
require_once 'config.php';



  $title= $desc= $address= $startDate= $endDate=$price=$latitude=$longitude= $file=$tags=$join=$status= "";

 $title_err=$desc_err=$address_err=$startDate_err=$endDate_err=$price_err=$latitude_err=$longitude_err=$file_err=$join_err=$status_err= $tags_err= "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
 

    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a title.";
    } 
    else{
        $title = $input_title;
    }
    //validate description 
     $input_desc = trim($_POST["desc"]);
    if(empty($input_desc)){
        $desc_err = "Please enter description.";
    } 
    else{
        $desc = $input_desc;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Please enter an address.';     
    } else{
        $address = $input_address;
    }
    
   // validate startdate

     $input_startDate = trim($_POST["startDate"]);
    if(empty($input_startDate)){
        $startDate_err = 'Please enter startdate.';     
    } else{
        $date = strtotime($input_startDate);
       $startDate= date('Y/m/d H:i:s', $date);
    }

   // validate end date
     $input_endDate = trim($_POST["endDate"]);
    if(empty($input_endDate)){
        $endDate_err = 'Please enter enddate.';     
    } else{
        $date = strtotime($input_endDate);
       $endDate= date('Y/m/d H:i:s', $date);
        
    }

    // validate price
    $pattern = '/^\d+(?:\.\d{2})?$/';
   $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price amount.";     
    } 
    elseif(preg_match($pattern, $_POST["price"]) == '0') {
    $price_err = "Enter amount in right format.";
   }
    else{
        $price = $input_price;
    }
   // validate latitude 
     $input_latitude = trim($_POST["latitude"]);
    if(empty($input_latitude)){
        $latitude_err = 'Please enter an latitude.';     
    } 
   

    else{
        $latitude = $input_latitude;
    }
    // validate longitude
     $input_longitude = trim($_POST["longitude"]);
    if(empty($input_longitude)){
        $longitude_err = 'Please enter an longitude.';     
    }
   
    else{
        $longitude = $input_longitude;
    }

    // validate file 
    $file = $_FILES['file'];
     $file_name = $file['name'];
     $file_path = $file ['tmp_name'];
   
    // va;idate join
     $input_join = trim($_POST["join"]);
    if(empty($input_join)){
        $join_err = 'Please enter jointype.';     
    } else{
        $join = $input_join;
    }
    // validate status
     $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = 'Please enter status.';     
    } else{
        $status = $input_status;
    }
    // validate tags
     $input_tags = trim($_POST["tags"]);
    if(empty($input_tags)){
        $tags_err = 'Please enter tags.';     
    } else{
        $tags =$input_tags;
    }

    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($address_err) && empty($desc_err)&&empty($startDate_err) &&empty($endDate_err)&&empty($price_err)&&empty($latitude_err)&&empty($longitude_err)&&empty($file_err)&&empty($join_err)&&empty($status_err)&&empty($tags_err)&& move_uploaded_file ($file_path,'images/'.$file_name)){
    //"images" is just a folder name here we will load the file.))
        // Prepare an insert statement
       $sql = "INSERT INTO events (Title, Description,Address,`StartDate&Time`, `EndDate&Time`,JoinType,Status,Price,Latitude,Longitude,Image,Tags)
VALUES ('$title','$desc','$address','$startDate','$endDate', '$join','$status' ,'$price','$latitude','$longitude','$file_name', '$tags')";

   if (mysqli_query($link, $sql)) {
        echo "<br><div class='container-fluid'><div class='row'><div class='col-md-12'><div class='alert alert-success' role='alert'>New Record Created successfully</div></div></div></div>";
  $title= $desc= $address= $startDate= $endDate=$price=$latitude=$longitude= $file=$tags=$join=$status= "";

   } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    
    }// Close connection

}
    mysqli_close($link);

}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="css/bootstrap-tagsinput.css">
    <style type="text/css">
        .wrapper{
            
            margin: 0 auto;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    <script src="js/bootstrap-tagsinput.js"></script>
    
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class=<"page-header">
                        <h2>Create Event</h2>
                    </div>
                    <p>Please fill this form and submit to create event record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"  onkeypress="return event.keyCode != 13">
                        <div class="form-group col-sm-4  <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                            <span class="help-block"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group col-sm-4  <?php echo (!empty($desc_err)) ? 'has-error' : ''; ?>">
                            <label>Description</label>
                            <input type="text" name="desc" class="form-control" value="<?php echo $desc; ?>">
                            <span class="help-block"><?php echo $desc_err;?></span>
                        </div>
                        <div class="form-group col-sm-4  <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                         <div class="form-group col-sm-4 <?php echo (!empty($startDate_err)) ? 'has-error' : ''; ?>">
                            <label>StartDate&Time</label>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" name = "startDate"  class="form-control" value="<?php echo (new DateTime($startDate))->format('d/m/Y H:i:s'); ?>">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4  <?php echo (!empty($endDate_err)) ? 'has-error' : ''; ?>">
                            <label>EndDate&Time</label>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                 <input type="text" name ="endDate" class="form-control" value="<?php echo (new DateTime($endDate))->format('d/m/Y H:i:s'); ?>">
                                     <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  col-sm-4  <?php echo (!empty($join_err)) ? 'has-error' : ''; ?>">
                            <label >JoinType</label>
                            <select class="form-control" name="join">
                            <option value = ""></option>
                            <option value="FREE">FREE</option>
                            <option value="PAID">PAID</option>
                            </select>
                            <span class="help-block"><?php echo $join_err;?></span>
                           </div>

                                 
                        <div class="row">
                        <div class="col-xs-12"> 
                        <div class="form-group col-sm-4   <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>"> 
                            <label>Status</label>
                            <select class="form-control" name="status">
                            <option value = ""></option>
                            <option value="LIVE">LIVE</option>
                            <option value="CANCELLED">CANCELLED</option>
                            </select>
                            <span class="help-block"><?php echo $status_err;?></span>
                        </div>
                        <div class="form-group col-sm-4  <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group col-sm-4  <?php echo (!empty($latitude_err)) ? 'has-error' : ''; ?>">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="form-control" value="<?php echo $latitude; ?>">
                            <span class="help-block"><?php echo $latitude_err;?></span>
                        </div>
                        </div>
                        </div>
                        <div class="form-group col-sm-4  <?php echo (!empty($longitude_err)) ? 'has-error' : ''; ?>">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control" value="<?php echo $longitude; ?>">
                            <span class="help-block"><?php echo $longitude_err;?></span>
                        </div>

                        <div class="form-group col-sm-4 <?php echo (!empty($file_err)) ? 'has-error' : ''; ?>">
                            <label>Image</label>
                            <input type="file" name= "file" value= "<?php echo $file_name;?> " class="form-control">
                            <span class="help-block"><?php echo $file_err;?></span>
                        </div>
                        <div class="form-group col-sm-4 <?php echo (!empty($tags_err)) ? 'has-error' : ''; ?>">
                            <label>Tags</label><br>
                            <input type="text" name = "tags"  class="form-control" value="<?php echo $tags;?>" data-role="tagsinput" >
                            <span class="help-block"><?php echo $tags_err;?></span>
                        </div>
                        <div class="col-xs-6" >
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="event.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
<script>
    $('#datetimepicker1').datetimepicker({})
    $('#datetimepicker2').datetimepicker({})
</script>
</html>