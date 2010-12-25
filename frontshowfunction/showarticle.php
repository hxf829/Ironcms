<?php
include '../conn.php';
include 'frontbasefunction.php';
$columnid = $_GET["columnid"];
$currentpage = $_GET["currentpage"];
showarticlelist($columnid,$currentpage);
?>