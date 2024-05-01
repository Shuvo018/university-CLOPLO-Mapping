<?php
require_once "../../db.php";
$db = new DBController();
// for teacher term changing
if (isset($_POST['action']) && $_POST['action'] == 'teacher') {
    $bctId = $_POST['id'];
    $curTerm = $_POST['term'];

    if (getTopRow($curTerm, $bctId) == null) {
        newTopRow($curTerm, $bctId);
    }
    $topRow = getTopRow($curTerm, $bctId);
    displayTopRow($topRow);
}
// for student term changing
if (isset($_POST['action']) && $_POST['action'] == 'student') {
    $bctId = $_POST['id'];
    $term = $_POST['term'];
    $co = "co1";
    displayStuList($bctId, $term, $co);
}
// for student co changing
if (isset($_POST['action']) && $_POST['action'] == 'stuCo') {
    $bctId = $_POST['bctId'];
    $co = $_POST['co'];
    $term = $_POST['term'];
    displayStuList($bctId, $term, $co);
}

// update teacher marks
elseif (isset($_POST['action']) && $_POST['action'] == 'teacherMarks') {
    $bctId = $_POST['bctId'];
    $term = $_POST['term'];
    $co1 = $_POST['co1'];
    $co2 = $_POST['co2'];
    $co3 = $_POST['co3'];
    $co4 = $_POST['co4'];
    $co5 = $_POST['co5'];
    $total = $_POST['total'];

    $sql = "UPDATE `constant` SET 
    `co1`='$co1',`co2`='$co2',
    `co3`='$co3',`co4`='$co4',
    `co5`='$co5',`total`='$total'
     WHERE `action`='exam' AND `term`='$term' AND `bct_id`='$bctId'";

    $db->updataData($sql);
    echo "updated successfully";
}
// update student marks
elseif (isset($_POST['action']) && $_POST['action'] == 'stuMarks') {
    $eid = $_POST["id"];
    $sa1 = $_POST["sa1"];
    $sb1 = $_POST["sb1"];
    $sa2 = $_POST["sa2"];
    $sb2 = $_POST["sb2"];
    $sa3 = $_POST["sa3"];
    $sb3 = $_POST["sb3"];
    $sa4 = $_POST["sa4"];
    $sb4 = $_POST["sb4"];
    $sa5 = $_POST["sa5"];
    $sb5 = $_POST["sb5"];
    $sa6 = $_POST["sa6"];
    $sb6 = $_POST["sb6"];
    $sa7 = $_POST["sa7"];
    $sb7 = $_POST["sb7"];

    $sql = "UPDATE `exam` SET 
    `1a`='$sa1',`1b`='$sb1',
    `2a`='$sa2',`2b`='$sb2',
    `3a`='$sa3',`3b`='$sb3',
    `4a`='$sa4',`4b`='$sb4',
    `5a`='$sa5',`5b`='$sb5',
    `6a`='$sa6',`6b`='$sb6',
    `7a`='$sa7',`7b`='$sb7'
    WHERE id = $eid ";
    $db->updataData($sql);

    echo "updated successfully";
}
//After inserting new value update student co mark
elseif (isset($_POST['action']) && $_POST['action'] == 'updateStuCoMark') {
    $scoId = $_POST['id'];
    $curCo = $_POST['co'];
    $totalMark = $_POST['totalMark'];
    $scoMarks = $_POST['scoMarks'];
    $arr = array();
    $sum = 0;
    for ($i = 1; $i < 6; $i++) {
        if ($curCo == "co$i") {
            $arr[$i - 1] = $totalMark;
        } else {
            $arr[$i - 1] = $scoMarks[$i - 1];
        }
        $sum += $arr[$i - 1];
    }
    $arr[5] = $sum;

    updateStuCoMark($scoId, $arr);
}

function updateStuCoMark($scoId, $arr)
{
    require_once "../../db.php";
    $db = new DBController();

    $sql = "UPDATE `constant_stu_exam` SET 
    `co1`='$arr[0]',`co2`='$arr[1]',`co3`='$arr[2]',
    `co4`='$arr[3]',`co5`='$arr[4]',`total`='$arr[5]' WHERE id = $scoId ";

    $db->updataData($sql);
    echo $arr[5];
}
// all functions here
function getStuCoMark($bctId, $stu_id, $term)
{
    require_once "../../db.php";
    $db = new DBController();

    $sql = "SELECT `id`, `co1`, `co2`, `co3`, `co4`, `co5`, `total`, `term` FROM `constant_stu_exam` 
    WHERE term = '$term' AND bct_id = $bctId AND stu_id = $stu_id";

    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
    return null;
}
function newStuCoMark($bctId, $stu_id, $term)
{
    require_once "../../db.php";
    $db = new DBController();

    $sql = "INSERT INTO `constant_stu_exam`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `term`, `bct_id`, `stu_id`) 
    VALUES ('0','0','0','0','0','0','$term','$bctId','$stu_id')";

    $id = $db->insertData($sql);
}

function getStuExamMark($bctId, $stu_id, $co, $term)
{
    require_once "../../db.php";
    $db = new DBController();

    $sql = "SELECT `id`, `1a`, `1b`, `2a`, `2b`, `3a`, `3b`, `4a`, `4b`, `5a`, `5b`, `6a`, `6b`, `7a`, `7b`, 
    `co`, `term`, `bct_id`, `stu_id` FROM `exam` 
    WHERE co = '$co' AND term = '$term' AND bct_id = '$bctId' AND stu_id = '$stu_id'";

    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
    return null;
}
function newStu($bctId, $stu_id, $co, $term)
{
    require_once "../../db.php";
    $db = new DBController();

    $sql = "INSERT INTO `exam`(`1a`, `1b`, `2a`, `2b`, `3a`, `3b`, 
    `4a`, `4b`, `5a`, `5b`, `6a`, `6b`, `7a`, `7b`, `co`,`term`, `bct_id`, `stu_id`) VALUES
      ('0','0','0',
      '0','0','0','0','0',
      '0','0','0','0','0',
      '0','$co','$term','$bctId','$stu_id')";

    $id = $db->insertData($sql);
}

function displayStuList($bctId, $term, $co)
{
    require_once "../../db.php";
    $db = new DBController();

    $rcSql = "SELECT `stu_id` FROM `running_course` WHERE b_c_t_id = '$bctId'";
    $rcRows = $db->readData($rcSql);
    if (!empty($rcRows)) {
        foreach ($rcRows as $k => $v) {
            $stu_id = $rcRows[$k]['stu_id'];
            $stu_cId = null;
            $stu_name = null;
            // find student name from student db
            $sSql = "SELECT `stu_cardId`, `stu_name` FROM `student` WHERE id = $stu_id";
            $sRow = $db->readData($sSql);
            if (!empty($sRow)) {
                $stu_cId = $sRow[0]['stu_cardId'];
                $stu_name = $sRow[0]['stu_name'];
            }
            // exam mark operations
            if (getStuExamMark($bctId, $stu_id, $co, $term) == null) {
                newStu($bctId, $stu_id, $co, $term);
            }
            $stuMark = getStuExamMark($bctId, $stu_id, $co, $term);

            if (getStuCoMark($bctId, $stu_id, $term) == null) {
                newStuCoMark($bctId, $stu_id, $term);
            }
            $stuCoMark = getStuCoMark($bctId, $stu_id, $term);
?>
            <tr>
                <td class="idStyle"><?php echo $stu_cId; ?></td>
                <td class="nameStyle"><?php echo $stu_name; ?></td>
                <td><input type='text' name='sa1' data-id="<?php echo $stuMark[0]['id']; ?>" value='<?php echo $stuMark[0]['1a']; ?>' /></td>
                <td><input type='text' name='sb1' value='<?php echo $stuMark[0]['1b']; ?>' /></td>
                <td><input type='text' name='sa2' value='<?php echo $stuMark[0]['2a']; ?>' /></td>
                <td><input type='text' name='sb2' value='<?php echo $stuMark[0]['2b']; ?>' /></td>
                <td><input type='text' name='sa3' value='<?php echo $stuMark[0]['3a']; ?>' /></td>
                <td><input type='text' name='sb3' value='<?php echo $stuMark[0]['3b']; ?>' /></td>
                <td><input type='text' name='sa4' value='<?php echo $stuMark[0]['4a']; ?>' /></td>
                <td><input type='text' name='sb4' value='<?php echo $stuMark[0]['4b']; ?>' /></td>
                <td><input type='text' name='sa5' value='<?php echo $stuMark[0]['5a']; ?>' /></td>
                <td><input type='text' name='sb5' value='<?php echo $stuMark[0]['5b']; ?>' /></td>
                <td><input type='text' name='sa6' value='<?php echo $stuMark[0]['6a']; ?>' /></td>
                <td><input type='text' name='sb6' value='<?php echo $stuMark[0]['6b']; ?>' /></td>
                <td><input type='text' name='sa7' value='<?php echo $stuMark[0]['7a']; ?>' /></td>
                <td><input type='text' name='sb7' value='<?php echo $stuMark[0]['7b']; ?>' /></td>
                <input type="hidden" name="scoId" data-id="<?php echo $stuCoMark[0]['id']; ?>">
                <td style="background-color: #EC7063 ;" id="sco1"><?php echo $stuCoMark[0]['co1']; ?></td>
                <td style="background-color: #AF7AC5 ;" id="sco2"><?php echo $stuCoMark[0]['co2']; ?></td>
                <td style="background-color: #5499C7 ;" id="sco3"><?php echo $stuCoMark[0]['co3']; ?></td>
                <td style="background-color: #48C9B0 ;" id="sco4"><?php echo $stuCoMark[0]['co4']; ?></td>
                <td style="background-color: #F4D03F ;" id="sco5"><?php echo $stuCoMark[0]['co5']; ?></td>
                <td id="stuCoTotal"><?php echo $stuCoMark[0]['total']; ?></td>
                <td><?php echo $stuCoMark[0]['term']; ?></td>
            </tr>
        <?php
        }
    }
}

function displayTopRow($topRow)
{
    if (!empty($topRow)) {
        ?>
        <tr>
            <td></td>
            <td></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td class="tdTopStyle"><input type="hidden"></td>
            <td>
                <input type='text' name='co1' value="<?php echo "{$topRow[0]['co1']}"; ?>">
            </td>
            <td>
                <input type='text' name='co2' value='<?php echo "{$topRow[0]['co2']}"; ?>'>
            </td>
            <td>
                <input type='text' name='co3' value='<?php echo "{$topRow[0]['co3']}"; ?>'>
            </td>
            <td>
                <input type='text' name='co4' value='<?php echo "{$topRow[0]['co4']}"; ?>'>
            </td>
            <td>
                <input type='text' name='co5' value='<?php echo "{$topRow[0]['co5']}"; ?>'>
            </td>
            <td id="topRowTotal">
                <?php echo "{$topRow[0]['total']}"; ?>
            </td>
            <td><?php echo "{$topRow[0]['term']}"; ?></td>
        </tr>
<?php
    }
}
function getTopRow($term, $bctId)
{
    require_once "../../db.php";
    $db = new DBController();


    $sql = "SELECT * FROM constant WHERE action = 'exam' AND term = '$term' AND bct_id = $bctId ";
    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
}
function newTopRow($term, $bctId)
{
    require_once "../../db.php";
    $db = new DBController();

    $insertSql = "INSERT INTO `constant`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `action`, `term`, `bct_id`) 
    VALUES ('0','0','0','0','0','0','exam','$term','$bctId')";

    $insert_id = $db->insertData($insertSql);
}
