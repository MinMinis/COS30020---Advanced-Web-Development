<?php
class HitCounter
{
    private $host, $user, $pwd, $db, $tb, $conn;
    function __construct($host, $user, $pswd, $dbnm, $table)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pswd;
        $this->db = $dbnm;
        $this->tb = $table;
        $this->conn = new mysqli($host, $user, $pswd);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        @$this->conn->select_db($dbnm);
    }
    function getHits()
    {
        // Get hits from hitcounter table
        $sql = "SELECT hits FROM " . $this->tb . " WHERE id = 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_row()) {
                echo "Hits: " . $row[0];
            }
        } else {
            echo "0 results";
        }
    }

    function setHits()
    {
        // Increment hits in hitcounter table
        $sql = "UPDATE " . $this->tb . " SET hits = hits + 1 WHERE id = 1";

        if ($this->conn->query($sql) === TRUE) {
            echo "Hits updated successfully";
        } else {
            echo "Error updating hits: " . $this->conn->error;
        }
    }

    function startOver()
    {
        // Set hits to zero in hitcounter table
        $sql = "UPDATE " . $this->tb . " SET hits = 0 WHERE id = 1";

        if ($this->conn->query($sql) === TRUE) {
            echo "Hits reset successfully";
        } else {
            echo "Error resetting hits: " . $this->conn->error;
        }
    }

    function closeConnection()
    {
        // Close connection
        $this->conn->close();
    }
}
