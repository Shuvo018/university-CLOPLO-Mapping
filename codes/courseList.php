<?php
require_once "db.php";
$db = new DBController();
session_start();

if (empty($_SESSION['teacher_id'])) {
    header("Location: index.php");
}
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
    <h1>course list</h1>
    <p>That teacher took before</p>

    <table class="table mb-3">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">course id</th>
                <th scope="col">course title</th>
            </tr>
        </thead>
        <tbody>
            <?php
            echo $_SESSION['batch_id'];
            echo $_SESSION['batch'];
            // echo $_SESSION['teacher_id'];
            echo $_SESSION['teacher_name'];

            $getBatchId = $_SESSION['batch_id'];
            $getTeacherId = $_SESSION['teacher_id'];

            // get batch and course form batch course teacher db";
            $bctSql = "SELECT `id`, `batch_id`, `course_id`, `teacher_id` FROM `batch_course_teacher`
             WHERE batch_id = $getBatchId AND teacher_id = $getTeacherId";

            $rows = $db->readData($bctSql);
            if (!empty($rows)) {
                foreach ($rows as $k => $v) {
                    $id = $rows[$k]['id'];
                    $course_id = $rows[$k]['course_id'];
                    $course_title = null;

                    //get course title from course database
                    $cSql = "SELECT `id`, `course_code`, `course_title` FROM `course` WHERE id = $course_id";

                    $cRow = $db->readData($cSql);
                    if (!empty($cRow)) {
                        $course_title = $cRow[0]['course_title'];
                    }
                    echo "<tr>
                <td>{$id}</td>
                <td>{$course_id}</td>
                <td>{$course_title}</td>
                <td> <a href = './studentInfo/info.php?bctId={$id}' class='btn btn-primary'> open </a></td>
            </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>