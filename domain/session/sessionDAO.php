<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/session', 'session.php');
load::load_file('domain/user', 'userDAO.php');
class SessionDAO extends DAO implements Mapper
{
    const table_name = 'SESSION';
    const user_id_column = 'USER_ID';
    const status_column = 'STATUS';
    const created_date_column = 'CREATED_DATE';
    const last_activity_date_column = 'LAST_ACTIVITY';

    public static function create_session_schema(Error $errors)
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table', $errors);

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " VARCHAR(128) NOT NULL PRIMARY KEY, " .
            self::user_id_column . " INT NOT NULL, " .
            self::status_column . " VARCHAR(12), " .
            self::created_date_column . " DATETIME, " .
            self::last_activity_date_column . " DATETIME, " .
            "CONSTRAINT unique_" . self::user_id_column . " FOREIGN KEY (" . self::user_id_column . ") REFERENCES " . UserDAO::table_name . "(" . UserDAO::id_column . ")" .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table', $errors);
    }

    public static function get_all(Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of sessions', $errors);
    }

    public static function get_by_id($id, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load session by id', $errors);
    }

    public static function get_by_user_id($user_id, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::user_id_column . " = :" . self::user_id_column;
        $parameters = array(
            ':' . self::user_id_column => self::sanitize_email($user_id),
        );
        return self::load_object($query, $parameters, new self(), 'load session by user id', $errors);
    }

    public static function session_id_already_taken($id, Error $errors)
    {
        return self::get_by_id($id, $errors) != null;
    }

    public static function user_already_has_session($user_id, Error $errors)
    {
        return self::get_by_user_id($user_id, $errors) != null;
    }

    public static function create($id, $user_id, $status, Error $errors)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::id_column . "," .
            self::user_id_column . "," .
            self::status_column . "," .
            self::created_date_column . "," .
            self::last_activity_date_column .
            ") VALUES (" .
            ":" . self::id_column . "," .
            ":" . self::user_id_column . "," .
            ":" . self::status_column . "," .
            ":" . self::created_date_column . "," .
            ":" . self::last_activity_date_column .
            ")";
        $parameters = array(
            ':' . self::id_column => $id,
            ':' . self::user_id_column => $user_id,
            ':' . self::status_column => $status,
            ':' . self::created_date_column => date('Y-m-d H:i:s'),
            ':' . self::last_activity_date_column => date('Y-m-d H:i:s'),
        );
        self::insert_update_delete_create($query, $parameters, 'save session', $errors);
        return self::get_by_id($id, $errors);
    }


    public static function update_status($id, $status, Error $errors)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::status_column . " = :" . self::status_column . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::status_column => $status,
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'update status', $errors);
    }

    public static function update_last_activity_date($id, Error $errors)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::last_activity_date_column . " = :" . self::last_activity_date_column . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::last_activity_date_column => date('Y-m-d H:i:s'),
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'update last activity date', $errors);
    }

    public static function delete_by_id($id, Error $errors)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete session by id', $errors);
    }

    public static function delete_by_user_id($user_id, Error $errors)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::user_id_column . " = :" . self::user_id_column;
        $parameters = array(
            ':' . self::user_id_column => $user_id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete session by user id', $errors);
    }

    public function map(array $row, Error $errors)
    {
        return new Session(
            $row[self::id_column],
            $row[self::user_id_column],
            $row[self::status_column],
            $row[self::created_date_column],
            $row[self::last_activity_date_column],
            $errors);
    }
}

?>