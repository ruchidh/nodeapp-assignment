<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$title= $desc= $address= $startDate= $endDate=$price=$latitude=$longitude= $file=$tags=$join=$status= "";
 $title_err=$desc_err=$address_err=$startDate_err=$endDate_err=$price_err=$latitude_err=$longitude_err=$file_err=$join_err=$status_err= $tags_err= "";
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
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
        $desc_err = "Please enter a title.";
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
    
    //  validate startdate
     $input_startDate = trim($_POST["startDate"]);
    if(empty($input_startDate)){
        $startDate_err = 'Please enter an address.';     
    } else{
         $date = strtotime($input_startDate);
       $startDate= date('Y/m/d H:i:s', $date);
    }

    // validate end date
     $input_endDate = trim($_POST["endDate"]);
    if(empty($input_endDate)){
        $endDate_err = 'Please enter an address.';     
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
    //validate longitude
     $input_longitude = trim($_POST["longitude"]);
    if(empty($input_longitude)){
        $longitude_err = 'Please enter an longitude.';     
    }
   
    else{
        $longitude = $input_longitude;
    }

    //validate file 
    $file = $_FILES['file'];
     $file_name = $file['name'];
     $file_path = $file ['tmp_name'];
   
    //validate join
     $input_join = trim($_POST["join"]);
    if(empty($input_join)){
        $join_err = 'Please enter an join.';     
    } else{
        $join = $input_join;
    }
    //validate status
     $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = 'Please enter an status.';     
    } else{
        $status = $input_status;
    }
    //validate tags
     $input_tags = trim($_POST["tags"]);
    if(empty($input_tags)){
        $tags_err = 'Please enter tags.';     
    } else{
        $tags =$input_tags;
    }

    //validate image
     $image = $_POST["oldfile"];
     if($file_name != $_POST["oldfile"] and !empty($file_name)){

        move_uploaded_file($file_path,'images/'.$file_name);
         $image = $file_name;
    }

   

    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($address_err) && empty($desc_err)&&empty($startDate_err) &&empty($endDate_err)&&empty($price_err)&&empty($latitude_err)&&empty($longitude_err)&&empty($file_err)&&empty($join_err)&&empty($status_err)&&empty($tags_err)){
        // Prepare an update statement
       $sql = "UPDATE events SET  Title='$title', Description= '$desc', Address='$address',`StartDate&Time`=  '$startDate', `EndDate&Time`= '$endDate' , JoinType='$join', Status = '$status', Price ='$price', Latitude = '$latitude', Longitude= '$longitude', Image= '$image',Tags = '$tags'  WHERE id= ".$id;

     if (mysqli_query($link, $sql)) {
    echo "<br><div class='container-fluid'><div class='row'><div class='col-md-12'><div class='alert alert-success' role='alert'>Record updated successfully</div></div></div></div>";
} else {
    echo "<br><div class='container-fluid'><div class='row'><div class='col-md-12'><div class='alert alert-success' role='alert'>"."Error updating record: " . mysqli_error($link)."</div></div></div></div>";
}


    
    }// Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM events WHERE id =".$id;
        
             $result = mysqli_query($link, $sql);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                   $title= $row["Title"];
                   $desc=$row["Description"];
                   $address=$row["Address"];
                   $startDate=$row["StartDate&Time"];
                   $endDate=$row["EndDate&Time"];
                   $join=$row["JoinType"];
                   $status=$row["Status"];
                   $price=$row["Price"];
                   $latitude=$row["Latitude"];
                    $longitude= $row["Longitude"];
                    $image= $row["Image"];
                    $tags = $row["Tags"];


                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            }
      
        // Close connection
        mysqli_close($link);

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13">
                        <div class="form-group col-sm-4 <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                            <span class="help-block"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group col-sm-4 <?php echo (!empty($desc_err)) ? 'has-error' : ''; ?>">
                            <label>Description</label>
                            <input type="text" name="desc" class="form-control" value="<?php echo $desc; ?>">
                            <span class="help-block"><?php echo $desc_err;?></span>
                        </div>
                        <div class="form-group col-sm-4 <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group col-sm-4 <?php echo (!empty($startDate_err)) ? 'has-error' : ''; ?>">
                            <label>StartDate&Time</label>
                            <div class="form-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input type="text" name = "startDate"  class="form-control" value="<?php echo (new DateTime($startDate))->format('m/d/Y H:i:s'); ?>">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-sm-4 <?php echo (!empty($endDate_err)) ? 'has-error' : ''; ?>">
                            <label>EndDate&Time</label>
                            <div class="form-group">
                            <div class='input-group date' id='datetimepicker2'>
                            <input type="text" name ="endDate" class="form-control" value="<?php echo (new DateTime($endDate))->format('m/d/Y H:i:s'); ?>">
                             <span class="input-group-addon">
                             <span class="glyphicon glyphicon-calendar"></span>
                             </span>
                             </div>
                            </div>
                        </div>

                        

                        <div class="form-group  col-sm-4 <?php echo (!empty($join_err)) ? 'has-error' : ''; ?>">
                            <label >JoinType</label>
                            <select class="form-control" name="join" value ="<?php echo $join;?>">
                            <option value = ""></option>
                            <option value="FREE" <?php echo $join == "FREE" ? "selected" : "";?> >FREE</option>
                            <option value="PAID" <?php echo $join == "PAID" ? "selected" : "";?> >PAID</option>
   
                           </select>
                           <span class="help-block" ><?php echo $join_err;?></span>
                           </div>
                            
                        <div class="row">
                        <div class="col-xs-12">

                           <div class="form-group col-sm-4  <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>"> 
                            <label>Status</label>
                            <select class="form-control" name="status" value = "<?php echo $status;?>">
                            <option value = ""></option>
                            <option value="LIVE" <?php echo $status == "LIVE" ? "selected" : "";?> >LIVE</option>
                            <option value="CANCELLED" <?php echo $status == "CANCELLED" ? "selected" : "";?> >CANCELLED</option>
   
                             </select>
                           <span class="help-block"><?php echo $status_err;?></span>
                        </div>

                         <div class="form-group col-sm-4 <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>

                        

                          <div class="form-group col-sm-4 <?php echo (!empty($latitude_err)) ? 'has-error' : ''; ?>">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="form-control" value="<?php echo $latitude; ?>">
                            <span class="help-block"><?php echo $latitude_err;?></span>
                        </div>
                          
                          </div>
                        </div> 
                         <div class="form-group col-sm-4 <?php echo (!empty($longitude_err)) ? 'has-error' : ''; ?>">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control" value="<?php echo $longitude; ?>">
                            <span class="help-block"><?php echo $longitude_err;?></span>
                        </div>        
                        <input type="hidden" name= "oldfile" value= "<?php echo $image;?>" class="form-control">
                        <div class="form-group col-sm-4 <?php echo (!empty($file_err)) ? 'has-error' : ''; ?>">
                            <label>Image</label>
                            
                            <input type="file" name= "file" value= "<?php echo $image;?>" class="form-control">
                            <img width="50" height="50" src="images/<?php echo $image;?>"/>
                            <span class="help-block"><?php echo $file_err;?></span>
                        </div>
                          <div class="form-group col-sm-4 <?php echo (!empty($tags_err)) ? 'has-error' : ''; ?>">
                            <label>Tags</label><br>
                            <input type="text" name = "tags"  class="form-control" value="<?php echo $tags;?>" data-role="tagsinput" >
                            <span class="help-block"><?php echo $tags_err;?></span>
                        </div>

                        <div class="col-xs-6" >
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
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