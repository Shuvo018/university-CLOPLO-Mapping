<?php
require_once "db.php";
$db = new DBController();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
    <style>
        body {
            width: 100%;
            background-color: #A3C1AD;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Teacher </h1>
        <p>Looking for course</p>

        <form action="index.php" method="post">
            <div class="form-group mb-3">
                <!-- teacher id because same name multiple teacher can exists -->
                <label for="">*Teacher cid: CSE 90</label>
                <input type="text" placeholder="Enter teacher id" name="teacher_cid" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="">*batch: CSE 024</label>
                <input type="text" placeholder="Enter batch:" name="batch" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" name="find" value="find" class="btn btn-primary">
            </div>
        </form>
    </div>

</body>

</html>
<?php
if (isset($_POST["find"])) {
    $t_cid = $_POST["teacher_cid"];
    $batch = $_POST["batch"];
    $errorFlag = FALSE;
    if (strlen($t_cid) > 3 && strlen($batch) > 5) {
        // finding batch id from batch no
        $bSql = "SELECT id FROM batch WHERE batch_no = '$batch' ";

        $bRow = $db->readData($bSql);
        if (!empty($bRow)) {
            $_SESSION['batch_id'] = $bRow[0]['id'];
            $_SESSION['batch'] = $batch;
            echo $bRow[0]['id'];
        } else {
            $errorFlag = TRUE;
?>
            <div class="alert alert-danger" role="alert">
                This batch is not available in database
            </div>
        <?php
        }

        // teacher id
        $tSql = "SELECT * FROM teacher WHERE t_cardId = '$t_cid'";

        $teacher_id = $teacher_name = null;
        $tRow = $db->readData($tSql);
        if (!empty($tRow)) {
            $teacher_id = $tRow[0]['id'];
            $teacher_name = $tRow[0]['t_name'];
            echo $tRow[0]['t_name'];
        } else {
            $errorFlag = TRUE;
        ?>
            <div class="alert alert-danger" role="alert">
                This teacher is not available in database
            </div>
<?php
        }
        if (!$errorFlag) {
            header("Location: courseList.php");

            $_SESSION['teacher_id'] = $teacher_id;
            $_SESSION['teacher_name'] = $teacher_name;
        }
    }
}

?>