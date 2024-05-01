<?php

require_once "../../db.php";
$db = new DBController();
// for teacher term changing
if (isset($_POST['action']) && $_POST['action'] == 'teacher') {
    $bctId = $_POST['id'];
    $term = $_POST['term'];
    displayTopRow($bctId, $term);
}
// for student term changing
if (isset($_POST['action']) && $_POST['action'] == 'student') {
    $bctId = $_POST['id'];
    $term = $_POST['term'];

    // finding students from running course 
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
            // attandence operations
            if (getStuMark($bctId, $stu_id, $term) == null) {
                newStu($bctId, $stu_id, $term);
            }
            $stuMark = getStuMark($bctId, $stu_id, $term);
?>
            <tr>
                <td class="idStyle"><?php echo $stu_cId; ?></td>
                <td class="nameStyle"><?php echo $stu_name; ?></td>
                <td><input type="text" name="co1" data-id="<?php echo $stuMark[0]['id']; ?>" value="<?php echo $stuMark[0]['co1']; ?>"></td>
                <td><input type="text" name="co2" data-id="" value="<?php echo $stuMark[0]['co2']; ?>"></td>
                <td><input type="text" name="co3" data-id="" value="<?php echo $stuMark[0]['co3']; ?>"></td>
                <td><input type="text" name="co4" data-id="" value="<?php echo $stuMark[0]['co4']; ?>"></td>
                <td><input type="text" name="co5" data-id="" value="<?php echo $stuMark[0]['co5']; ?>"></td>
                <td class="sTotal"><?php echo $stuMark[0]['total']; ?></td>
                <td><?php echo $stuMark[0]['term']; ?></td>
                <input type="hidden" name="bctId" data-id="<?php echo $bctId; ?>">
                <input type="hidden" name="attanTerm" data-id="<?php echo $stuMark[0]['term']; ?>">
            </tr>
        <?php
        }
    }
}
// update student marks
elseif (isset($_POST['action']) && $_POST['action'] == 'stuMarks') {
    $sAId = $_POST['id'];
    $co1 = $_POST['co1'];
    $co2 = $_POST['co2'];
    $co3 = $_POST['co3'];
    $co4 = $_POST['co4'];
    $co5 = $_POST['co5'];
    $total = $_POST['total'];

    $uSql = "UPDATE `attandence` SET 
    `co1`='$co1',`co2`='$co2',
    `co3`='$co3',`co4`='$co4',
    `co5`='$co5',`total`='$total'
     WHERE id = $sAId ";

    $db->updataData($uSql);
    echo "updated successfully";
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
    `co5`='$co5',`total`='$total' WHERE
     action = 'attandence' AND term = '$term' AND bct_id = $bctId ";

    $db->updataData($sql);
    displayTopRow($bctId, $term);
}
// all functions here
function getStuMark($bctId, $stu_id, $term)
{
    require_once "../../db.php";
    $db = new DBController();
    $sql = "SELECT `id`, `co1`, `co2`, `co3`, `co4`, `co5`, `total`, `term`, `bct_id`, `stu_id` FROM `attandence` 
        WHERE term = '$term' AND bct_id = '$bctId' AND stu_id = '$stu_id'";

    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
    return null;
}
function newStu($bctId, $stu_id, $term)
{
    require_once "../../db.php";
    $db = new DBController();
    $sql = "INSERT INTO `attandence`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `term`, `bct_id`, `stu_id`) VALUES 
    ('0','0','0','0','0','0','$term','$bctId','$stu_id')";
    $id = $db->insertData($sql);
}
function displayTopRow($bctId, $term)
{
    require_once "../../db.php";
    $db = new DBController();

    if (getTopRow($term, $bctId) == null) {
        newTopRow($term, $bctId);
    }
    $row = getTopRow($term, $bctId);
    if (!empty($row)) {
        ?>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type='text' name='tco1' data-id="<?php echo $bctId; ?>" value="<?php echo "{$row[0]['co1']}"; ?>">
            </td>
            <td>
                <input type='text' name='tco2' value='<?php echo "{$row[0]['co2']}"; ?>'>
            </td>
            <td>
                <input type='text' name='tco3' value='<?php echo "{$row[0]['co3']}"; ?>'>
            </td>
            <td>
                <input type='text' name='tco4' value='<?php echo "{$row[0]['co4']}"; ?>'>
            </td>
            <td>
                <input type='text' name='tco5' value='<?php echo "{$row[0]['co5']}"; ?>'>
            </td>
            <td>
                <?php echo "{$row[0]['total']}"; ?>
            </td>
            <td><?php echo "{$row[0]['term']}"; ?></td>
            <input type="hidden" name="tTerm" data-id="<?php echo $row[0]['term']; ?>">

        </tr>
<?php
    }
}

function getTopRow($term, $bctId)
{
    require_once "../../db.php";
    $db = new DBController();

    $sql = "SELECT * FROM constant WHERE action = 'attandence' AND term = '$term' AND bct_id = $bctId ";
    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
}
function newTopRow($term, $bctId)
{
    require_once "../../db.php";
    $db = new DBController();

    $insertSql = "INSERT INTO `constant`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `action`, `term`, `bct_id`) VALUES
         ('0','0','0','0','0','0','attandence','$term','$bctId')";
    $insert_id = $db->insertData($insertSql);
}
?>