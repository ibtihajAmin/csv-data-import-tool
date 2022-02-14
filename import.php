<?php

$conn = mysqli_connect("localhost","root","","csv");

if(isset($_POST["import"])) {
    $fileName = $_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName,"r");

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

<form class="form-horizontal" action="" method="post" name="uploadCsv" enctype="multipart/form-data">

<div style="margin: top 20px;">
<label>Choose CSV File</label>
<input type="file" name="file" accept=".csv">
<button type="submit" name="import">Import</button>
</div>

</form>

<?php

$sqlSelect = "SELECT * FROM datainsert";

$result = mysqli_query($conn,$sqlSelect);

if(mysqli_num_rows($result) > 0) {
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Person Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start Date</th>
            </tr>
        </thead>
        <?php
        while($row = mysqli_fetch_array($result)) {
            ?>
            <tbody>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['person_name'];?></td>
                    <td><?php echo $row['position'];?></td>
                    <td><?php echo $row['office'];?></td>
                    <td><?php echo $row['age'];?></td>
                    <td><?php echo $row['start_date'];?></td>
                </tr>
            </tbody>
            <?php } ?>
    </table>
<?php
}
?>

