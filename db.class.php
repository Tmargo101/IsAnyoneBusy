<?php /** @noinspection PhpUnused */
/*
    Author: Thomas Margosian
    Date created: 3/23/20
*/

require_once "CONSTANTS.php";

class DB {

    protected $dbholder;

    function __construct() {
        try {
            // Set PDO access data from constants (Cannot call a constant within string interpolation)
            $host = DB_SERVER;
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            $database = DB_DATABASE;

            $this->dbholder = new PDO("mysql:host={$host};dbname={$database}", $username, $password);
        } catch (PDOException $pdoException) {
            echo $pdoException->getMessage();
            die("<br>Bad Database");
        }
    }

    function getAllRowsFromTable($inColumns, $inTable, $inQuery) {
        try {
            // Decide if I am going to use a fetch class or an associative array

            $query = "SELECT $inColumns FROM $inTable $inQuery";
            $statement = $this->dbholder->prepare($query);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            return $statement->fetchAll();

        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return array();
        }
    }

    //////////////////////////////////////// START STATUS FUNCTIONS ////////////////////////////////////////

    function setStatus($memberId, $status) {
        try {
            $statement = $this->dbholder->prepare("UPDATE status SET status = :status, datetime=now() WHERE member = :memberID");
            $statement->execute(array("memberID" => $memberId, "status" => $status));
            return $this->dbholder->lastInsertId();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return array();
        }
    }

    function checkStatus($memberId) {
        try {
            $statement = $this->dbholder->prepare("SELECT status from status WHERE member = :memberID");
            $statement->execute(array("memberID" => $memberId));
            return $statement->fetchAll();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return array();
        }
    }

    //////////////////////////////////////// END STATUS FUNCTIONS ////////////////////////////////////////

}