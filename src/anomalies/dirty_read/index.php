<!DOCTYPE html>
<style>
    th,
    td {
        padding: 0.5rem 2rem;
        text-align: start;
        border: 1px solid gray;
    }
</style>
<?php
include_once "../../database.php";

$example = new Database("pgsql:host=0.0.0.0;port=5432;dbname=db", "postgres", "password");
$example->setup_user_table();

$example->db->beginTransaction();
$example->set_isolation_level_read_uncommited();

$example->dump_user_table();
$user = $example->get_user($_GET['user']);

sleep(10);
$example->update_user_balance($user['id'], $user['balance']);

$example->db->commit();

$example->dump_user_table();
