<?php
// include("../db.php");
require_once "../db.php";
$db = new DBController();
session_start();
?>
<nav style="background-color: #5F9EA0;" id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
    <a class="navbar-brand" href="../index.php">index</a>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="info.php">info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="attandence.php">attandence</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="assignment.php">assignment/Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="ct.php">CT/Viva</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="exam.php">exam/Quiz</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="report.php">report</a>
        </li>
    </ul>
</nav>