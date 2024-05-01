<?php
include("../db.php");

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
    <h1>Admin</h1>

    <div class="d-grid gap-2">
        <a href="addTeacher.php" class="btn btn-primary" role="button">add teacher</a>
        <a href="addStudent.php" class="btn btn-primary" role="button">add student</a>
        <a href="addBatch.php" class="btn btn-primary" role="button">add batch</a>
        <a href="addCourse.php" class="btn btn-primary" role="button">add course</a>
        <a href="addBatchCourseTeacher.php" class="btn btn-primary" role="button">add batch course teacher</a>
        <a href="addRunninCourse.php" class="btn btn-primary" role="button">add running course</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>