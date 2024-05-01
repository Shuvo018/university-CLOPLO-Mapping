<?php
include("./nav.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Document</title>
    <style>
        body {
            /* width: 100%; */
            background-color: #A3C1AD;
        }

        /* Chart Design start */
        .graphBox {
            position: relative;
            width: 100%;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            grid-gap: 30px;
            min-height: 200px;
        }

        .graphBox .box {
            position: relative;
            background: #fff;
            padding: 20px;
            width: 100%;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
            border-radius: 20px;

        }

        @media (max-width:991px) {
            .graphBox {
                grid-template-columns: 1fr;
                height: auto;
            }
        }

        /* Chart Design end */

        /* Chart Design  2nd start */
        .graphBox {
            position: relative;
            width: 100%;
            padding: 20px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-gap: 30px;
            min-height: 200px;
        }

        .graphBox .box {
            position: relative;
            background: #fff;
            padding: 20px;
            width: 100%;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
            border-radius: 20px;

        }

        @media (max-width:991px) {
            .graphBox {
                grid-template-columns: 1fr;
                height: auto;
            }
        }

        /* Chart Design 2nd end */
    </style>
</head>

<body>
    <div class="container">
        <h1>students report</h1>
        <hr>
        <?php
        // for display batch , course
        include("header.php");
        ?>
    </div>

    <input type="hidden" name="bct_id" data-id="<?php echo $_SESSION['bct_id']; ?>">

    <?php
    $bctId = $_SESSION['bct_id'];

    // finding students from running course 
    $rcSql = "SELECT `stu_id` FROM `running_course` WHERE b_c_t_id = '$bctId'";
    $rcRow = $db->readData($rcSql);
    if (!empty($rcRow)) {
        $stuResultArr = array();
        foreach ($rcRow as $k => $v) {
            $stu_id = $rcRow[$k]['stu_id'];
            $stu_cId = null;
            $stu_name = null;
            // find the student name from student db
            $sSql = "SELECT `stu_cardId`, `stu_name` FROM `student` WHERE id = $stu_id";
            $sRow = $db->readData($sSql);
            if (!empty($sRow)) {
                $stu_cId = $sRow[0]['stu_cardId'];
                $stu_name = $sRow[0]['stu_name'];
            }
            // get each stu mark operations
            $stuTMark = getStuTMark($bctId, $stu_id);
            array_push($stuResultArr, $stuTMark);
        }
    }

    $gradeArr = array();
    for ($i = 'A'; $i <= 'F'; $i++) {
        $gradeArr[$i] = 0;
    }
    $gradeArr['A+'] = 0;
    $gradeArr['A-'] = 0;
    $gradeArr['B+'] = 0;
    $gradeArr['B-'] = 0;
    $gradeArr['C+'] = 0;

    for ($i = 0; $i < count($stuResultArr); $i++) {
        if ($stuResultArr[$i] >= 80 && $stuResultArr[$i] <= 100) {
            $gradeArr['A+'] += 1;
        } else if ($stuResultArr[$i] >= 75 && $stuResultArr[$i] <= 79) {
            $gradeArr['A'] += 1;
        } else if ($stuResultArr[$i] >= 70 && $stuResultArr[$i] <= 74) {
            $gradeArr['A-'] += 1;
        } else if ($stuResultArr[$i] >= 65 && $stuResultArr[$i] <= 69) {
            $gradeArr['B+'] += 1;
        } else if ($stuResultArr[$i] >= 60 && $stuResultArr[$i] <= 64) {
            $gradeArr['B'] += 1;
        } else if ($stuResultArr[$i] >= 55 && $stuResultArr[$i] <= 59) {
            $gradeArr['B-'] += 1;
        } else if ($stuResultArr[$i] >= 50 && $stuResultArr[$i] <= 54) {
            $gradeArr['C+'] += 1;
        } else if ($stuResultArr[$i] >= 45 && $stuResultArr[$i] <= 49) {
            $gradeArr['C'] += 1;
        } else if ($stuResultArr[$i] >= 40 && $stuResultArr[$i] <= 44) {
            $gradeArr['D'] += 1;
        } else {
            $gradeArr['F'] += 1;
        }
        echo $stuResultArr[$i] . " , ";
    }

    echo "<br> Grade : A+ = {$gradeArr['A+']}, A = {$gradeArr['A']}, A- = {$gradeArr['A-']},
    B+ = {$gradeArr['B+']}, B = {$gradeArr['B']},  B- = {$gradeArr['B-']}, C+ = {$gradeArr['C+']},
    C = {$gradeArr['C']}, D = {$gradeArr['D']}, F = {$gradeArr['F']} ";
    ?>
    <!-- chart start -->
    <div>
        <div class="graphBox">
            <!-- graphs -->
            <div class="box"><canvas id="graph"></canvas></div>
            <!-- pi chart -->
            <div class="box"><canvas id="pichart"></canvas></div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script src="js_scripts/reportScript.js"></script>
    </div>
    <!-- chart end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
<?php
// all function call here
function getStuTMark($bctId, $stu_id)
{
    require_once "../db.php";
    $db = new DBController();

    $tMark = 0;
    // attandence
    $attanSql = "SELECT `total` FROM `attandence` 
        WHERE  bct_id = '$bctId' AND stu_id = '$stu_id'";
    // $attresult = mysqli_query($conn, $attanSql);
    $row = $db->readData($attanSql);
    if (!empty($row)) {
        foreach ($row as $k => $v) {
            $tMark += $row[$k]['total'];
        }
    }

    // assignment
    $assSql = "SELECT `total` FROM `assignment` 
        WHERE  bct_id = '$bctId' AND stu_id = '$stu_id'";
    $row2 = $db->readData($assSql);
    if (!empty($row2)) {
        foreach ($row2 as $k => $v) {
            $tMark += $row2[$k]['total'];
        }
    }

    // ct
    $ctSql = "SELECT `total` FROM `classtest` 
    WHERE bct_id = '$bctId' AND stu_id = '$stu_id'";
    $row3 = $db->readData($ctSql);
    if (!empty($row3)) {
        foreach ($row3 as $k => $v) {
            $tMark += $row3[$k]['total'];
        }
    }

    // exam
    $examSql = "SELECT `total` FROM `constant_stu_exam` 
    WHERE bct_id = $bctId AND stu_id = $stu_id";
    $row4 = $db->readData($examSql);
    if (!empty($row4)) {
        foreach ($row4 as $k => $v) {
            $tMark += $row4[$k]['total'];
        }
    }
    return $tMark;
}
?>