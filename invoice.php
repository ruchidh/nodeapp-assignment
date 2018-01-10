<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
   
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        
                        <a href="welcome.html" class="btn btn-info pull-left">Back to dashboard</a>
                        <a href="create_invoice.php" class="btn btn-success pull-right">Add New Invoice</a>
                        <h2 style = "text-align: center;">Invoice Details</h2>
                    </div>
                    <?php
                    // Include config file
                    require_once 'config.php';
                    
                    $sql = "SELECT * FROM invoices";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>#</th>";
                                    echo " <th>Financial Year</th>";
                                    echo "<th>Issued To</th>";
                                    echo "<th>Address</th>";
                                    echo "<th>Heading</th>";
                                    echo" <th>Date & time</th>";
                                    echo "<th>Currency</th>";
                                    echo "<th>Particulars</th>";
                                    echo "<th>Gross Amount</th>";
                                    echo "<th>Service Tax</th>";
                                    echo "<th>Net Amount</th>";
                                    echo "<th>Action </th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    $Particulars = "";
                                    $plist = explode("$$",$row['Particulars']);
                                    for ($i=1; $i <= sizeof($plist); $i++) { 
                                        $Particulars = $Particulars."".$i.". ". $plist[$i-1] ."<br>";
                                    }
                                    echo "<tr>";
                                         
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['Financial Year'] . "</td>";
                                        echo "<td>" . $row['Issued To'] . "</td>";
                                        echo "<td style='max-width:150px'>" . $row['Address'] . "</td>";
                                        echo "<td>" . $row['Heading'] . "</td>";
                                        echo "<td>" . $row['Date & time'] . "</td>";
                                        echo "<td>" . $row['Currency'] . "</td>";
                                        echo "<td>" . $Particulars . "</td>";
                                        echo "<td>" . $row['Gross Amount'] . "</td>";
                                        echo "<td>" . $row['Service Tax'] . "</td>";
                                        echo "<td>" . $row['Net Amount'] . "</td>";
                                        
                                    
                                        echo "<td>";
                                            
                                            echo "<a href='edit_invoice.php?id=". $row['id'] ."' title='Edit Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";

                                        echo "</td>";

                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>