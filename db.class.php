<?php
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

    /** @noinspection PhpInconsistentReturnPointsInspection
     * @noinspection PhpIncludeInspection
     * @param $inColumns
     * @param $inTable
     * @param $inQuery
     * @param $fetchType
     * @return array
     */
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

//    /** @noinspection PhpInconsistentReturnPointsInspection */
//    function getSomeRowsFromTable($inObjectReturnType, $inSortBy, $inQuery, $inColumn, $id, $fetchType) {
//        try {
//            // Decide if I am going to use a fetch class or an associative array
//            switch ($fetchType) {
//                case "class":
//
//                    /** @noinspection PhpIncludeInspection */
//                    include_once "model/{$inObjectReturnType}.class.php";
//
//                    // Build query outside of the PDO Prepare instead of binding the params in the PDO since Table and Column names CANNOT be replaced by parameters in PDO.
//                    $query = "$inQuery WHERE $inColumn = :id ORDER BY :orderby";
//                    $statement = $this->dbholder->prepare($query);
//                    $statement->execute(array("id" => $id, "orderby" => $inSortBy));
//                    $statement->setFetchMode(PDO::FETCH_CLASS, $inObjectReturnType);
//                    return $statement->fetchAll();
//                    break;
//
//                case "array":
//                    // Build query outside of the PDO Prepare instead of binding the params in the PDO since Table and Column names CANNOT be replaced by parameters in PDO.
//                    $query = "$inQuery where m_e.manager = :id";
//                    $statement = $this->dbholder->prepare($query);
//                    var_dump($statement);
//                    $statement->execute(array("id" => $id));
//                    $statement->setFetchMode(PDO::FETCH_ASSOC);
//                    return $statement->fetchAll();
//                    break;
//
//                    break;
//
//            }
//
//        } catch (PDOException $exception) {
//            echo $exception->getMessage();
//            return array();
//        }
//    }


    //////////////////////////////////////// START STATUS FUNCTIONS ////////////////////////////////////////

    function setStatus($memberId, $status) {
        try {
            $statement = $this->dbholder->prepare("UPDATE status SET status = :status WHERE member = :memberID");
            $statement->execute(array("memberID" => $memberId, "status" => $status));
            return $this->dbholder->lastInsertId();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return array();
        }
    }

    function checkStatus($memberId, $attendeeId) {
        try {
            $statement = $this->dbholder->prepare("SELECT status from status WHERE member = :memberID");
            $statement->execute(array("memberID" => $memberId));
            $data = $statement->fetchAll();
            return $data;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return array();
        }
    }
    //////////////////////////////////////// END STATUS FUNCTIONS ////////////////////////////////////////

}