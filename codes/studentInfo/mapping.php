<?php
include("./nav.php");
$bctId = $_SESSION['bct_id'];
$db = new DBController();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
    <style>
        table {
            width: 100%;
        }

        input {
            height: 30px;
        }
    </style>
</head>

<body>
    <!-- header start -->
    <?php
    include("header.php");
    ?>
    <!-- header end -->
    <!-- CREATE map -->
    <div class="mapBox">
        <form action="mapping.php" method="POST">
            <div class="form-group">
                <label for="">CLO: Enter CLO(CLO1) in capital word</label>
                <input type="text" name="CLOM" class="form-control" id="" placeholder="Enter CLO">

            </div>
            <div class="form-group">

                <label for="">PLO: Enter PLO(PLO2) in capital word </label>
                <input type="text" name="PLOM" class="form-control" id="" placeholder="Enter PLO">
            </div>
            <button type="submit" name="addMap" class="btn btn-primary">Add map</button>
        </form>
    </div>

    <!-- PO Table Start -->
    <div class="relative flex flex-col w-full min-w-0 mb-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">

        <?php
        if (isset($_POST['addMap'])) {
            $courseId = $_SESSION['course_id'];
            $clo = $_POST["CLOM"];
            $plo = $_POST["PLOM"];

            createMap($courseId, $clo, $plo);
        }

        $courseId = $_SESSION['course_id'];
        echo "course id : " . $courseId . "<br>";

        $sql = "SELECT * FROM `plomapping` WHERE course_id = $courseId";
        $row = $db->readData($sql);

        $cloArr = array();
        $copoArr = array();

        if (!empty($row)) {

            foreach ($row as $k => $v) {
                $arr = array();
                $arr[$row[$k]['CLO']] = $row[$k]['PLO'];
                $copoArr[] = $arr;

                array_push($cloArr, $row[$k]['CLO']);
            }
        }
        $_SESSION['copoArr'] = $copoArr;
        $_SESSION['cloArr'] = $cloArr;
        print_r($copoArr);

        ?>
        <table class="table table-striped">
            <thead class="align-bottom">
                <tr>
                    <th></th>
                    <th scope="col">plo1</th>
                    <th scope="col">plo2</th>
                    <th scope="col">plo3</th>
                    <th scope="col">plo4</th>
                    <th scope="col">plo5</th>
                    <th scope="col">plo6</th>
                    <th scope="col">plo7</th>
                    <th scope="col">plo8</th>
                    <th scope="col">plo9</th>
                    <th scope="col">plo10</th>
                    <th scope="col">plo11</th>
                    <th scope="col">plo12</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 1; $i < 6; $i++) {
                ?>
                    <tr>
                        <th scope="row"><?php echo "clo$i" ?></th>
                        <?php
                        for ($j = 1; $j < 13; $j++) { ?>

                            <td><?php if (isCLO("CLO$i") && isCOPO("CLO$i", "PLO$j")) {
                                    echo "Yes";
                                } else {
                                    // echo "No";
                                }  ?></td>
                        <?php
                        }
                        ?>
                    </tr>

                <?php

                }
                ?>

            </tbody>
        </table>
    </div>
    <!-- PO Table End -->
</body>

</html>
<?php
// all fuctions

function createMap($courseId, $clo, $plo)
{
    require_once "../db.php";
    $db = new DBController();

    echo $clo . " : " . $plo;
    $sql = "INSERT INTO `plomapping`(`course_id`, `CLO`, `PLO`) VALUES
     ($courseId,'$clo','$plo')";
    $id = $db->insertData($sql);
}
function isCOPO($co, $po)
{
    $arr = $_SESSION['copoArr'];
    foreach ($arr as $k => $v) {
        if (!empty($arr[$k][$co]) && $arr[$k][$co] == $po) {
            return true;
        }
    }
    return false;
}
function isCLO($clo)
{
    $arr = $_SESSION['cloArr'];
    foreach ($arr as $k => $v) {
        if ($v == $clo) {
            return true;
        }
    }
    return false;
}

?>