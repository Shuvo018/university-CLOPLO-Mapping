<?php
if (empty($_SESSION['bct_id'])) {
    header("Location: index.php");
}
echo "<h4>batch no : {$_SESSION['batch_no']}</h4>";
echo "<h4>course code: {$_SESSION['course_code']}</h4>";
echo "<h4>course title: {$_SESSION['course_title']}</h4>";
