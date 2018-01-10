<?php
// Include config file
require_once 'config.php';
 

$fin= $iss= $address= $head=  $date=$curr=$part=$gross= $ser= $net="";

 $fin_err=$iss_err=$address_err=$head_err=$date_err=$curr_err=$part_err=$gross_err=$ser_err=$net_err= "";
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

   //validate financial year
    $input_fin = trim($_POST["fin"]);
    if(empty($input_fin)){
        $fin_err = "Please enter financial year.";
    } 
    else{
        $fin = $input_fin;
    }
    //validate issued to 
     $input_iss = trim($_POST["iss"]);
    if(empty($input_iss)){
        $iss_err = "Please enter issued to.";
    } 
    else{
        $iss = $input_iss;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Please enter an address.';     
    } else{
        $address = $input_address;
    }

// Validate heading
     $input_head = trim($_POST["head"]);
    if(empty($input_head)){
        $head_err = 'Please enter heading.';   
    } else{
        $head = $input_head;
    }

// Validate currency

     $input_curr = trim($_POST["curr"]);
    if(empty($input_curr)){
        $curr_err = 'Please enter currency.';     
    } else{
        $curr = $input_curr;
    }

   // Validate date
     $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = 'Please enter date.';     
    } else{
       $date = strtotime($input_date);
       $date= date('Y/m/d H:i:s', $date);
    }



   //Validate particulars  
   $input_part = $_POST["particulars"];
    
    if($input_part[0]==""){
        $part_err = "Please enter the particulars.";     
    }
    else{
        
        array_pop($input_part);
        $part = implode("$$", $input_part);
    }


    //Validate gross amount  
     $input_gross= trim($_POST["gross"]);
    if(empty($input_gross)){
        $gross_err = 'Please enter gross amount.';     
    } 
     
    else{
        $gross = $input_gross;
    }
   

   //Validate service tax
     $input_ser = trim($_POST["ser"]);
    if(empty($input_ser)){
        $ser_err = 'Please enter service tax.';     
    }
   
    else{
        $ser = $input_ser;
    }

    
 //Validate net amount
     $input_net = trim($_POST["net"]);
    if(empty($input_net)){
        $net_err = 'Please enter  net amount.';     
    } else{
        $net= $input_net;
    }
   
    
    // Check input errors before inserting in database
    if(empty($fin_err) && empty($iss_err) && empty($address_err)&&empty($head_err) &&empty($date_err)&&empty($curr_err)&&empty($part_err)&&empty($gross_err)&&empty($ser_err)&&empty($net_err)){
        // Prepare an update statement
       $sql = "UPDATE invoices SET  `Financial Year`='$fin', `Issued To`= '$iss', Address='$address',Heading=  '$head', `Date & time`= '$date' , Currency='$curr', Particulars = '$part', `Gross Amount`='$gross',`Service Tax`= '$ser', `Net Amount`= '$net' WHERE id= ".$id;

                  
         $part=explode("$$",$part);


    if(mysqli_query($link, $sql)) {
    
    echo "<br><div class='container-fluid'><div class='row'><div class='col-md-12'><div class='alert alert-success' role='alert'>Record updated successfully</div></div></div></div>";
    } else {
    echo "<br><div class='container-fluid'><div class='row'><div class='col-md-12'><div class='alert alert-success' role='alert'>"."Error updating record: " . mysqli_error($link)."</div></div></div></div>";
    }


    
    }// Close connection
    mysqli_close($link);

$firstpart = "";
if(isset($part[0]))
{$firstpart = $part[0];}
    } else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM invoices WHERE id =".$id;
        
             $result = mysqli_query($link, $sql);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                   $fin= $row["Financial Year"];
                   $iss=$row["Issued To"];
                   $address=$row["Address"];
                   $head=$row["Heading"];
                   $date=$row["Date & time"];
                   $curr=$row["Currency"];
                   $part = array();
                   $part=explode("$$",$row["Particulars"]);
                   $gross=$row["Gross Amount"];
                   $ser=$row["Service Tax"];
                   $net= $row["Net Amount"];


                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            }
      
        // Close connection
        mysqli_close($link);
$firstpart = "";
if(isset($part[0]))
{$firstpart = $part[0];}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Invoice Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="css/bootstrap-tagsinput.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group col-sm-4 <?php echo (!empty($fin_err)) ? 'has-error' : ''; ?>">
                            <label>Financial Year</label>
                            <input type="text" name="fin" class="form-control" value="<?php echo $fin; ?>">
                            <span class="help-block"><?php echo $fin_err;?></span>
                    </div>
                    <div class="form-group col-sm-4 <?php echo (!empty($iss_err)) ? 'has-error' : ''; ?>">
                            <label>Issued To</label>
                            <input type="text" name="iss" class="form-control" value="<?php echo $iss; ?>">
                            <span class="help-block"><?php echo $iss_err;?></span>
                    </div>
                     <div class="form-group col-sm-4 <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                            <span class="help-block"><?php echo $address_err;?></span>
                    </div>
                    <div class="form-group col-sm-4 <?php echo (!empty($head_err)) ? 'has-error' : ''; ?>">
                        <label>Heading</label>
                        <input type="text" name = "head"  class="form-control" value="<?php echo $head; ?>">
                        <span class="help-block"><?php echo $head_err;?></span>
                    </div>

                    <div class="form-group col-sm-4 <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                        <label>Date & Time</label>
                    <div class="form-group">
                    <div class='input-group date' id='datetimepicker2'>
                        <input type="text" name ="date" class="form-control" value="<?php echo (new DateTime($date))->format('m/d/Y H:i:s'); ?>">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                     </div>
                    </div>
                            <span class="help-block"><?php echo $date_err;?></span>
                    </div>
                        
                           
                    <div class="form-group col-sm-4 <?php echo (!empty($curr_err)) ? 'has-error' : ''; ?>">
                        <label>Currency</label>
                        <input type="text" name="curr" class="form-control" value="<?php echo $curr; ?>">
                        <span class="help-block"><?php echo $curr_err;?></span>
                    </div>


                   <div class="row">
                   <div class="col-xs-12">
                    
                    <div class="form-group col-sm-4 <?php echo (!empty($gross_err)) ? 'has-error' : ''; ?>">
                        <label>Gross Amount</label>
                        <input type="text" name="gross" class="form-control" value="<?php echo $gross; ?>">
                        <span class="help-block"><?php echo $gross_err;?></span>
                    </div>

                    <div class="form-group col-sm-4 <?php echo (!empty($ser_err)) ? 'has-error' : ''; ?>">
                        <label>Service Tax</label>
                        <input type="text" name="ser" class="form-control" value="<?php echo $ser; ?>">
                        <span class="help-block"><?php echo $ser_err;?></span>
                    </div>
                    <div class="form-group col-sm-4 <?php echo (!empty($net_err)) ? 'has-error' : ''; ?>">
                        <label>Net Amount</label>
                        <input type="text" name="net" class="form-control" value="<?php echo $net; ?>">
                        <span class="help-block"><?php echo $net_err;?></span>
                    </div>
                    </div>
                    </div>
                           
                           
                    <div  id ="parti" class="form-group  col-sm-6 <?php echo (!empty($part_err)) ? 'has-error' : ''; ?>">
                            
                      <label>Particulars </label>
                    <div class="form-group " >
                    <div class="row">
                    <div class="col-xs-offset-2 col-xs-7">
                     <input type="text" class="form-control" name="particulars[]"  value="<?php echo $firstpart; ?>" >
                    </div>

                     <div class="col-xs-3">
                              <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                    </div>
                        </div>
                        </div>
                     <?php   
                    
                     for($i = 1;$i< sizeof($part); $i++) {?>
    
                    <div class="form-group " >
                    <div class="row">
                    <div class="col-xs-offset-2 col-xs-7">
                        <input type="text" class="form-control" name="particulars[]"  value="<?php echo $part[$i]; ?>" >

                    </div>

                    <div class="col-xs-3">
                        <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                    </div>
                    </div>
                    </div>
                         
                     <?php  
                     } ?>
                    <div class="form-group hide" id="optionTemplate">
                    <div class="row">
                       <div class="col-xs-offset-2  col-xs-7">
                        <input class="form-control" type="text" name="particulars[]" >
                    </div>
                    <div class="col-xs-3">
                       <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                    </div>
                    </div>
                    </div>
                        <span class="help-block"><?php echo $part_err;?></span>
                    </div>

                   <div class="col-xs-6">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="invoice.php" class="btn btn-default">Cancel</a>
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
<script>
$(document).ready(function() {
    // The maximum number of options
   

    $('#parti').on('click', '.addButton', function() {
            var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template),
                $option   = $clone.find('[name="particulars[]"]');

            // Add new field
            $('#parti').formValidation('addField', $option);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row    = $(this).closest('.form-group'),
                $option = $row.find('[name="particulars[]"]');

            // Remove element containing the option
            $row.remove();

            // Remove field
            $('#parti').formValidation('removeField', $option);
        })

        
});
</script>

</html>