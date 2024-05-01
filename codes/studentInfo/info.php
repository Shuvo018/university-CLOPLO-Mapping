<?php
include("./nav.php");
if (isset($_GET['bctId'])) {
    $_SESSION['bct_id'] = $_GET['bctId'];
} else if (empty($_SESSION['bct_id'])) {
    header("Location: index.php");
}


$getBCTid = $_SESSION['bct_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>

    <?php
    //find batch, course id from batch_course_teacher db
    $bctSql = "SELECT id, batch_id, course_id, teacher_id FROM batch_course_teacher
     WHERE id = $getBCTid";

    $bctRow = $db->readData($bctSql);
    if (!empty($bctRow)) {
        $batch_id = $bctRow[0]['batch_id'];
        $course_id = $bctRow[0]['course_id'];
        $_SESSION['course_id'] = $course_id;
        //find batch ttile from batch db 
        $bSql = "SELECT batch_no FROM batch WHERE id = '$batch_id'";
        $bRow = $db->readData($bSql);
        if (!empty($bRow)) {
            $_SESSION['batch_no'] = $bRow[0]['batch_no'];
            echo "<h1>batch: {$bRow[0]['batch_no']}</h1><br>";
        }

        //find course ttile from course db 
        $cSql = "SELECT course_code, course_title FROM course WHERE id = '$course_id'";
        $cRow = $db->readData($cSql);
        if (!empty($cRow)) {
            $_SESSION['course_code'] = $cRow[0]['course_code'];
            $_SESSION['course_title'] = $cRow[0]['course_title'];
            echo "<h4>Course: {$cRow[0]['course_code']}</h4>";
            echo "<h4>Course: {$cRow[0]['course_title']}</h4>";
        }
    }
    ?>

    <table class="table mb-3">
        <thead>
            <tr>
                <th scope="col">stu_id</th>
                <th scope="col">stu name</th>
                <th scope="col">co</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // finding students from running course 
            $rcSql = "SELECT id, b_c_t_id, stu_id FROM running_course WHERE b_c_t_id = $getBCTid";
            $rcRows = $db->readData($rcSql);
            if (!empty($rcRows)) {
                foreach ($rcRows as $k => $v) {
                    $stu_id = $rcRows[$k]['stu_id'];
                    $stu_cId = null;
                    $stu_name = null;
                    // find student name from student db
                    $sSql = "SELECT stu_cardId, stu_name FROM student WHERE id = $stu_id";
                    $sRow = $db->readData($sSql);
                    if (!empty($sRow)) {
                        $stu_cId = $sRow[0]['stu_cardId'];
                        $stu_name = $sRow[0]['stu_name'];
                    }
                    echo "<tr>
                    <td>{$stu_cId}</td>
                    <td>{$stu_name}</td>
                    </tr>";
                }
            }
            ?>
            <tr>

            </tr>
        </tbody>
    </table>
    <a href="mapping.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">mapping</a>
    <!--searching student map -->

    <div class="mapBox">
        <form action="info.php" method="POST">
            <div class="form-group">
                <label for="">Enter student id</label>
                <input type="text" name="stuId" class="form-control" id="" placeholder="id" required>
            </div>
            <button type="submit" name="map" class="btn btn-primary">map</button>
        </form>
    </div>

    <?php
    if (isset($_POST['map'])) {
        $stuId = $_POST['stuId'];
    ?>
        <!-- PO Table Start -->
        <div>
            <?php
            $courseId = $_SESSION['course_id'];
            $sql = "SELECT * FROM plomapping WHERE course_id = $courseId";
            $row = $db->readData($sql);
            if (!empty($row)) {
                $cloArr = array();
                $copoArr = array();

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
                                        $getCloMark = getCloMark("co$i");
                                        $stuMark = cloMarks("CLO$i", $stuId);
                                        // echo $stuMark;
                                        // echo $getCloMark;
                                        if ($getCloMark != 0 && ($stuMark / $getCloMark) * 100 >= 40) {
                                            echo  " Yes ";
                                        } else {
                                            echo " No ";
                                        }
                                    } else {
                                        // echo "space";
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
    <?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<?php
// all functions
function getCloMark($co)
{
    require_once "../db.php";
    $db = new DBController();

    $total = 0;
    $bctId = $_SESSION['bct_id'];
    $sql = "SELECT  co1, co2, co3, co4, co5 FROM constant WHERE bct_id = $bctId ";
    $row = $db->readData($sql);
    if (!empty($row)) {
        foreach ($row as $k => $v) {
            $total += $row[$k]["$co"];
        }
    }
    return $total;
}
function cloMarks($clo, $stuCid)
{
    require_once "../db.php";
    $db = new DBController();

    $bctId = $_SESSION['bct_id'];
    $total = 0;
    $stuId = null;
    $sql = "SELECT id, stu_cardId, stu_name FROM student WHERE stu_cardId = '$stuCid'";
    $row = $db->readData($sql);
    if (!empty($row)) {
        $stuId = $row[0]['id'];
    }
    $co = "co5";
    if ($clo == "CLO1") {
        $co = "co1";
    } elseif ($clo == "CLO2") {
        $co = "co2";
    } elseif ($clo == "CLO3") {
        $co = "co3";
    } elseif ($clo == "CLO4") {
        $co = "co4";
    }

    // assignment
    $sql2 = "SELECT * FROM assignment WHERE bct_id = '$bctId' AND stu_id = '$stuId'";
    $row2 = $db->readData($sql2);
    if (!empty($row2)) {
        foreach ($row2 as $k => $v) {
            $total += $row2[$k][$co];
        }
    }

    // attendence
    $sql3 = "SELECT * FROM attandence WHERE bct_id = '$bctId' AND stu_id = '$stuId'";
    $row3 = $db->readData($sql3);
    if (!empty($row3)) {
        foreach ($row3 as $k => $v) {
            $total += $row3[$k][$co];
        }
    }

    // ct
    $sql4 = "SELECT * FROM classtest WHERE bct_id = '$bctId' AND stu_id = '$stuId'";
    $row4 = $db->readData($sql4);
    if (!empty($row4)) {
        foreach ($row4 as $k => $v) {
            $total += $row4[$k][$co];
        }
    }

    // exam
    $sql5 = "SELECT * FROM constant_stu_exam WHERE bct_id = '$bctId' AND stu_id = '$stuId'";
    $row5 = $db->readData($sql5);
    if (!empty($row5)) {
        foreach ($row5 as $k => $v) {
            $total += $row5[$k][$co];
        }
    }

    return $total;
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
