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
    <form action="add_flight.php" method="post">

        <div class="form-group">
            <input type="text" class="form-control" name="total_seats" placeholder="Enter teacher id">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="total_seats" placeholder="Enter teacher name">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="submit" name="submit">
            <input type="submit" class="btn btn-danger" value="cancel" name="submit">
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>