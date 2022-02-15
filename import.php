<?php

//connect with the database
$conn = mysqli_connect("localhost","root","","csv");

//If user hits the Import button the it will be checked if there contains any file or not
if(isset($_POST["import"])) {
    $fileName = $_FILES["file"]["tmp_name"];

    //Checking the selected file size
    if($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName,"r");

        //after read the entire file, data will be inserted to the database
        while(($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT INTO datainsert(person_name,position,office,age,start_date)
            VALUES ('".$column[0]."','".$column[1]."','".$column[2]."','".$column[3]."','".$column[4]."')";

            $result = mysqli_query($conn,$sqlInsert);

        }
        if(empty($result)) {
            echo "Data can not be inserted. Please Try again";
        }
        
    }
}

?>

<form class="form-horizontal" action="" method="post"
 name="uploadCsv" enctype="multipart/form-data"
 style="margin-top:40px">

<div style="margin-top:20px; margin-left:40%;margin-right:40%">
<label>Choose CSV File</label>
<input type="file" name="file" accept=".csv">
<button type="submit" name="import" style="margin-top:3px;background-color:#519259;padding: 8px 12px;color:#fff;border-radius: 8px;border:none">Import</button>
</div>

</form>

<?php

$sqlSelect = "SELECT * FROM datainsert";

$result = mysqli_query($conn,$sqlSelect);

if(mysqli_num_rows($result) > 0) {
    ?>
    <table style="border:1px solid black; padding: 20px; border-radius: 3px">
        <thead>
            <tr>
                <th style="padding: 8px">ID</th>
                <th style="padding: 8px">Person Name</th>
                <th style="padding: 8px">Position</th>
                <th style="padding: 8px">Office</th>
                <th style="padding: 8px">Age</th>
                <th style="padding: 8px">Start Date</th>
            </tr>
        </thead>

        <!-- fetching the data from the database -->
        <?php
        while($row = mysqli_fetch_array($result)) {
            ?>
            <tbody>
                <tr>
                    <td style="padding: 8px"><?php echo $row['id'];?></td>
                    <td style="padding: 8px"><?php echo $row['person_name'];?></td>
                    <td style="padding: 8px"><?php echo $row['position'];?></td>
                    <td style="padding: 8px"><?php echo $row['office'];?></td>
                    <td style="padding: 8px"><?php echo $row['age'];?></td>
                    <td style="padding: 8px"><?php echo $row['start_date'];?></td>
                </tr>
            </tbody>
            <?php } ?>
    </table>
<?php
}
?>

