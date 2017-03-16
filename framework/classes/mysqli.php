<?php
    /**
    *    Fetch row as associated array with indexes that match column names
    */
    define('FETCH_ASSOC', 0);
    /**
    *    Fetch row as array
    */
    define('FETCH_ARRAY', 1);
    /**
    * Fetch row as object with fields that match column names
    */
    define('FETCH_OBJECT', 2);

    /**
    * @author Levko Kravets <talvinen@i.ua>
    */
    class DataBaseException extends Exception {}

    final class SQLQuery {

        private $stmt;
        private $fields;

        private function error($link = null) {
            if (!$this->stmt) throw new DataBaseException(mysqli_error($link));
            else throw new DataBaseException(mysqli_stmt_error($this->stmt), mysqli_stmt_errno($this->stmt));
        }

        public function __construct($link, $query, $params) {
            $this->stmt = $link->prepare($query);
            if (!$this->stmt) $this->error($link);

            // Bind parameters
            if (count($params) > 0) {
                $types = "";
                foreach ($params as $value) {
                    if (is_double($value)) $types .= "d";
                    elseif (is_int($value)) $types .= "i";
                    else $types .= "s";
                }
                $param_arr = array($this->stmt, $types);
                foreach($params as $key => $value) $param_arr[] = &$params[$key];
                if (!call_user_func_array('mysqli_stmt_bind_param', $param_arr)) $this->error();
            }

            if (!mysqli_stmt_execute($this->stmt)) $this->error();
            mysqli_stmt_store_result($this->stmt);

            // Get information about resulting columns
            $this->fields = array();
            $meta = mysqli_stmt_result_metadata($this->stmt);
            if ($meta) {
                $fields = mysqli_fetch_fields($meta);
                if ($fields == false) $this->error();
                foreach($fields as $value) $this->fields[] = $value->name;
                mysqli_free_result($meta);
            }
        }

        public function __destruct() {
            if ($this->stmt) mysqli_stmt_close($this->stmt);
        }

        /**
        * ID of last inserted record (only after INSERT queries)
        */
        public function insertId() {
            if (!$this->stmt) return false;
            return mysqli_stmt_insert_id($this->stmt);
        }

        /**
        * Count of rows affected by last query
        */
        public function affectedRows() {
            if (!$this->stmt) return false;
            return mysqli_stmt_affected_rows($this->stmt);
        }

        /**
        * Fetch next record (only after SELECT queries)
        *
        * @param int One of FETCH_* flags: FETCH_ASSOC, FETCH_ARRAY or FETCH_OBJECT
        * @return mixed
        */
        public function fetch($flags = FETCH_ASSOC) {
            if (!$this->stmt) return false;
            if (count($this->fields) <= 0) return false;
            $tmp = array_pad($this->fields, 0, 0);
            $params = array($this->stmt);
            foreach($tmp as $name => $value) $params[] = &$tmp[$name];
            if (!call_user_func_array('mysqli_stmt_bind_result', $params)) $this->error();
            if (!mysqli_stmt_fetch($this->stmt)) return false;

            $res = array();
            for($i = 0; $i < count($this->fields); $i++)
                $res[$this->fields[$i]] = $tmp[$i];

            if ($flags == FETCH_ARRAY) return array_values($res);
            if ($flags == FETCH_OBJECT) return (object)$res;
            return $res;
        }

        /**
        * Fetch all records (only after SELECT queries)
        *
        * @param int One of FETCH_* flags: FETCH_ASSOC, FETCH_ARRAY or FETCH_OBJECT
        * @return array
        */
        public function fetchAll($flags = FETCH_ASSOC) {
            if (!$this->stmt) return false;
            $res = array();
            while ($row = $this->fetch($flags)) $res[] = $row;
            return $res;
        }

    }

    /**
    *    @author Levko Kravets <talvinen@i.ua>
    */
    final class DataBase {

        private $connection = null;

        public function __construct($host, $user, $password, $database) {
            $this->connection = mysqli_connect($host, $user, $password, $database);
            if (!$this->connection) throw new DataBaseException(mysqli_connect_error(), mysqli_connect_error());
        }

        public function __destruct() {
            if ($this->connection) mysqli_close($this->connection);
        }

        /**
        * Make SQL query
        *
        * @param string SQL query text
        * @param array List of parameters mathing every '?' in SQL query
        * @return SQLQuery
        */
        public function query($sql, $params = array()) {
            if (!is_array($params)) $params = array();
            return new SQLQuery($this->connection, $sql, $params);
        }

    }