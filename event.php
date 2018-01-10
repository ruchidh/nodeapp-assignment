<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>

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
                        <a href="create_event.php" class="btn btn-success pull-right">Add New Event</a>
                        <h2 style = "text-align: center;">Event Details</h2>
                    </div>
                    <?php
                    // Include config file
                    require_once 'config.php';
                    
                    $sql = "SELECT * FROM events";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                                echo "<table class='table table-bordered table-striped'>";
                                    echo "<thead>";
                                      echo "<tr>";
                                      echo "<th>#</th>";
                                      echo " <th>Title</th>";
                                      echo "<th>Description</th>";
                                      echo "<th>Address</th>";
                                      echo "<th>StartDate&Time</th>";
                                      echo" <th>EndDate&Time</th>";
                                      echo "<th>JoinType</th>";
                                      echo "<th>Status</th>";
                                      echo "<th>Price</th>";
                                      echo "<th>Latitude</th>";
                                      echo "<th>Longitude</th>";
                                      echo "<th>Image</th>";
                                      echo "<th>Tags</th>";
                                      echo "<th>Action </th>";
                                      echo "</tr>";
                                    echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";   
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['Title'] . "</td>";
                                        echo "<td>" . $row['Description'] . "</td>";
                                        echo "<td>" . $row['Address'] . "</td>";
                                        echo "<td>" . $row['StartDate&Time'] . "</td>";
                                        echo "<td>" . $row['EndDate&Time'] . "</td>";
                                        echo "<td>" . $row['JoinType'] . "</td>";
                                        echo "<td>" . $row['Status'] . "</td>";
                                        echo "<td>" . $row['Price'] . "</td>";
                                        echo "<td>" . $row['Latitude'] . "</td>";
                                        echo "<td>" . $row['Longitude'] . "</td>";
                                        echo "<td><img width='50' height='50' src='images/". $row['Image']."'</td>";
                                        echo "<td style='max-width:120px'>" . implode(", ",explode(",",$row['Tags'])) . "</td>";
                                        echo "<td>";
                                            
                                        echo "<a href='edit_event.php?id=". $row['id'] ."' title='Edit Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";

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