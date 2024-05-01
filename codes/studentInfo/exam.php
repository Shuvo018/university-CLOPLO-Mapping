<?php

include("./nav.php");
$bctId = $_SESSION['bct_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>exam</title>
    <style>
        body {
            /* width: 100%; */
            background-color: #A3C1AD;
        }

        table {
            width: 100%;
        }

        input {
            width: 30px;
        }

        td {
            width: 30px;
        }

        .idStyle,
        .nameStyle {
            width: 10%;
        }

        .tdTopStyle {
            width: 38px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>students exam</h1>
        <hr>
        <?php
        include("header.php");
        ?>
    </div>
    <!-- exam term -->
    <h2>Select term : </h2>
    <div id="checkBox1">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="examTerm" data-id="<?php echo $bctId; ?>" value="mid" checked>mid
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="examTerm" data-id="<?php echo $bctId; ?>" value="final">final
        </div>
    </div>

    <!-- CLO -->
    <h2>Select CO : </h2>
    <div id="checkBox2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tCo" id="tco1" data-id="<?php echo $bctId; ?>" value="co1" checked>co1
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tCo" data-id="<?php echo $bctId; ?>" value="co2">co2
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tCo" data-id="<?php echo $bctId; ?>" value="co3">co3
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tCo" data-id="<?php echo $bctId; ?>" value="co4">co4
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tCo" data-id="<?php echo $bctId; ?>" value="co5">co5
        </div>
    </div>
    <table class="table1 table-bordered">
        <thead>
            <tr>
                <th scope="col" class="idStyle">Id</th>
                <th scope="col" class="nameStyle">Name</th>
                <th scope="col">1a</th>
                <th scope="col">1b</th>
                <th scope="col">2a</th>
                <th scope="col">2b</th>
                <th scope="col">3a</th>
                <th scope="col">3b</th>
                <th scope="col">4a</th>
                <th scope="col">4b</th>
                <th scope="col">5a</th>
                <th scope="col">5b</th>
                <th scope="col">6a</th>
                <th scope="col">6b</th>
                <th scope="col">7a</th>
                <th scope="col">7b</th>
                <th style="background-color: #EC7063 ;" scope="col" name="lco1">co1</th>
                <th style="background-color: #AF7AC5 ;" scope="col" name="lco2">co2</th>
                <th style="background-color: #5499C7 ;" scope="col" name="lco3">co3</th>
                <th style="background-color: #48C9B0 ;" scope="col" name="lco4">co4</th>
                <th style="background-color: #F4D03F ;" scope="col" name="lco5">co5</th>
                <th scope="col">total</th>
                <th scope="col">term</th>
            </tr>
        </thead>
        <tbody id="topRowTable">

            <?php
            $curTerm = "mid";
            if (getTopRow($curTerm, $bctId) == null) {
                newTopRow($curTerm, $bctId);
            }
            $topRow = getTopRow($curTerm, $bctId);
            $topRowId = $topRow[0]['id'];
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
        </tbody>
    </table>
    <table class="table2 table-bordered" style="width: 100%;">
        <tbody id="studentTB">
            <?php
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

                    // exam mark operations
                    $co = "co1";
                    if (getStuExamMark($bctId, $stu_id, $co) == null) {
                        newStu($bctId, $stu_id, $co);
                    }
                    $stuMark = getStuExamMark($bctId, $stu_id, $co);

                    if (getStuCoMark($bctId, $stu_id) == null) {
                        newStuCoMark($bctId, $stu_id);
                    }
                    $stuCoMark = getStuCoMark($bctId, $stu_id);
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
            ?>

        </tbody>
    </table>
</body>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="js_scripts/examScript2.js"></script>

</html>
<?php

// all function call here
function getStuExamMark($bctId, $stu_id, $co)
{
    require_once "../db.php";
    $db = new DBController();

    $term = "mid";
    $sql = "SELECT `id`, `1a`, `1b`, `2a`, `2b`, `3a`, `3b`, `4a`, `4b`, `5a`, `5b`, `6a`, `6b`, `7a`, `7b`, 
    `co`, `term`, `bct_id`, `stu_id` FROM `exam` 
    WHERE co = '$co' AND term = '$term' AND bct_id = '$bctId' AND stu_id = '$stu_id'";

    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
    return null;
}
function newStu($bctId, $stu_id, $co)
{
    require_once "../db.php";
    $db = new DBController();
    $term = "mid";

    $sql = "INSERT INTO `exam`(`1a`, `1b`, `2a`, `2b`, `3a`, `3b`, 
    `4a`, `4b`, `5a`, `5b`, `6a`, `6b`, `7a`, `7b`, `co`,`term`, `bct_id`, `stu_id`) VALUES
      ('0','0','0',
      '0','0','0','0','0',
      '0','0','0','0','0',
      '0','$co','$term','$bctId','$stu_id')";

    $id = $db->insertData($sql);
}
function getStuCoMark($bctId, $stu_id)
{
    require_once "../db.php";
    $db = new DBController();
    $term = "mid";

    $sql = "SELECT `id`, `co1`, `co2`, `co3`, `co4`, `co5`, `total`, `term` FROM `constant_stu_exam` 
    WHERE term = '$term' AND bct_id = $bctId AND stu_id = $stu_id";

    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
    return null;
}
function newStuCoMark($bctId, $stu_id)
{
    require_once "../db.php";
    $db = new DBController();
    $term = "mid";

    $sql = "INSERT INTO `constant_stu_exam`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `term`, `bct_id`, `stu_id`) 
    VALUES ('0','0','0','0','0','0','$term','$bctId','$stu_id')";

    $id = $db->insertData($sql);
}
// constant db operation
function getTopRow($term, $bctId)
{
    require_once "../db.php";
    $db = new DBController();

    $sql = "SELECT * FROM constant WHERE action = 'exam' AND term = '$term' AND bct_id = $bctId ";
    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
}
function newTopRow($term, $bctId)
{
    require_once "../db.php";
    $db = new DBController();

    $insertSql = "INSERT INTO `constant`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `action`, `term`, `bct_id`) 
    VALUES ('0','0','0','0','0','0','exam','$term','$bctId')";

    $insert_id = $db->insertData($insertSql);
}

// ***student mark insert operations***

?>