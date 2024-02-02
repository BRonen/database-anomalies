<?php

class Database {
    function __construct(String $uri, String $username, String $password) {
        $this->db = new PDO($uri, $username, $password);
    }

    function setup_user_table() {
        $sql = "DROP TABLE users;
                CREATE TABLE users (
                    id SERIAL PRIMARY KEY NOT NULL,
                    balance INTEGER NOT NULL,
                    username VARCHAR(30) NOT NULL,
                    created_at TIMESTAMP DEFAULT now() NOT NULL
                );
                INSERT INTO users (balance, username) VALUES (100, 'bronen'), (100, 'henri'), (100, 'guizinhos'), (100, 'geraldos');
                ";
        $this->db->exec($sql);
    }

    function dump_user_table() {
        $stmt = $this->db->prepare("SELECT id, balance, username, created_at FROM users");
        $stmt->execute();

        echo "<table>
                <thead>
                    <th>id</th>
                    <th>username</th>
                    <th>balance</th>
                    <th>created_at</th>
                </thead>
                <tbody>
            ";

        foreach($stmt->fetchAll() as $k) {
            echo "<tr>";
            echo "<td>" . $k["id"] . "</td>";
            echo "<td>" . $k["username"] . "</td>";
            echo "<td>" . $k["balance"] . "</td>";
            echo "<td>" . $k["created_at"] . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
    }

    function update_user_balance(Int $id, Int $balance) {
        $stmt = $this->db->prepare("UPDATE users SET balance=:balance WHERE id=:id;");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':balance', $balance);
        $stmt->execute();
    }

    function get_user(Int $id) {
        $stmt = $this->db->prepare("SELECT id, balance, username, created_at FROM users WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch();
        return $user;
    }

    function set_isolation_level_read_uncommited() {
        $this->db->exec("SET GLOBAL TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;");
    }
}
