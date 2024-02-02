<?php
include_once "../../database.php";

$example = new Database("pgsql:host=0.0.0.0;port=5432;dbname=db", "postgres", "password");

$example->db->beginTransaction();
$example->set_isolation_level_read_uncommited();

$example->update_user_balance($_GET['user'], $_GET['balance']);
echo "<h1> Updated user #". $_GET['user'] ." with balance = ". $_GET['balance'] ." </h1>";

sleep(10);

$example->db->rollback();
echo "<h1> Rollbacked </h1>";
