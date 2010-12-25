<?php
include '../conn.php';
include 'frontbasefunction.php';
$columnid = $_GET["columnid"];
$currentpage = $_GET["currentpage"];
showarticlelist($columnid,$currentpage);
echo "<div class='showpage'>";
showpage($columnid,$currentpage);
echo "</div>";
?>