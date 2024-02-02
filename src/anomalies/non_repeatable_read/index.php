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

$example->dump_user_table();
sleep(5);
$example->dump_user_table();

$example->db->commit();
