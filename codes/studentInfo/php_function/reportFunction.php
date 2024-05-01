<?php
require_once "../../db.php";
$db = new DBController();

if (isset($_POST['action']) && $_POST['action'] == "stuResult") {
    $bctId = $_POST['id'];

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
        // echo $stuResultArr[$i] . " , ";
    }

    echo json_encode($gradeArr);
}
// all function call here
function getStuTMark($bctId, $stu_id)
{
    require_once "../../db.php";
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
