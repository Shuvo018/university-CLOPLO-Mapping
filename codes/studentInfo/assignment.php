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
    <!-- <link rel="stylesheet" href="../style.css"> -->
    <title>Document</title>
    <style>
        body {
            /* width: 100%; */
            background-color: #A3C1AD;

        }

        table {
            width: 100%;
            background-color: #fff;
        }

        td {
            width: 50px;
        }

        input {
            width: 50px;
        }

        input {
            background-color: #95A5A6;
        }

        .idStyle,
        .nameStyle {
            width: 10%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>students assignment</h1>
        <hr>
        <?php
        include("header.php");
        ?>
    </div>
    <div id="checkBox">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="examTerm" data-id="<?php echo $bctId; ?>" value="mid" checked>mid
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="examTerm" data-id="<?php echo $bctId; ?>" value="final">final
        </div>
    </div>

    <table class="table1 table-bordered">
        <thead>
            <tr>
                <th scope="col" class="idStyle">Id</th>
                <th scope="col" class="nameStyle">Name</th>
                <th scope="col">co1</th>
                <th scope="col">co2</th>
                <th scope="col">co3</th>
                <th scope="col">co4</th>
                <th scope="col">co5</th>
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
                <td>
                    <input type='text' name='tco1' data-id="<?php echo $bctId; ?>" value="<?php echo "{$topRow[0]['co1']}"; ?>">
                </td>
                <td>
                    <input type='text' name='tco2' value='<?php echo "{$topRow[0]['co2']}"; ?>'>
                </td>
                <td>
                    <input type='text' name='tco3' value='<?php echo "{$topRow[0]['co3']}"; ?>'>
                </td>
                <td>
                    <input type='text' name='tco4' value='<?php echo "{$topRow[0]['co4']}"; ?>'>
                </td>
                <td>
                    <input type='text' name='tco5' value='<?php echo "{$topRow[0]['co5']}"; ?>'>
                </td>
                <td><?php echo "{$topRow[0]['total']}"; ?></td>
                <td><?php echo "{$topRow[0]['term']}"; ?></td>
                <input type="hidden" name="tTerm" data-id="<?php echo $topRow[0]['term']; ?>">
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

                    // attandence operations
                    if (getStuMark($bctId, $stu_id) == null) {
                        newStu($bctId, $stu_id);
                    }
                    $stuMark = getStuMark($bctId, $stu_id);

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
            ?>
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js_scripts/assignScript.js"></script>
</body>

</html>
<?php


// all function call here
function getStuMark($bctId, $stu_id)
{
    require_once "../db.php";
    $db = new DBController();

    $term = "mid";
    $sql = "SELECT * FROM `assignment` 
        WHERE term = '$term' AND bct_id = '$bctId' AND stu_id = '$stu_id'";
    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
    return null;
}
function newStu($bctId, $stu_id)
{
    require_once "../db.php";
    $db = new DBController();
    $term = "mid";
    $sql = "INSERT INTO `assignment`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `term`, `bct_id`, `stu_id`) VALUES 
    ('0','0','0','0','0','0','$term','$bctId','$stu_id')";

    $id = $db->insertData($sql);
}
function getTopRow($term, $bctId)
{
    require_once "../db.php";
    $db = new DBController();

    $sql = "SELECT * FROM constant WHERE 
    action = 'assignment' AND term = '$term' AND bct_id = '$bctId'";
    $row = $db->readData($sql);
    if (!empty($row)) {
        return $row;
    }
}
function newTopRow($term, $bctId)
{
    require_once "../db.php";
    $db = new DBController();
    $insertSql = "INSERT INTO `constant`(`co1`, `co2`, `co3`, `co4`, `co5`, `total`, `action`, `term`, `bct_id`) VALUES
         ('0','0','0','0','0','0','assignment','$term','$bctId')";

    $insert_id = $db->insertData($insertSql);
}
?>