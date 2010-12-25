<?php
include '../conn.php';
include 'frontbasefunction.php';
$columnid = $_GET["columnid"];
$currentpage = $_GET["currentpage"];
echo "<div class='showpage'>";
showpage($columnid,$currentpage);
echo "</div>";
?>