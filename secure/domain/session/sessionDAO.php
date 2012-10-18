<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/session', 'session.php');
load::load_file('domain/user', 'userDAO.php');
class SessionDAO extends DAO implements Mapper
{
    const table_name = 'SESSION';
    const id_column = 'SESSION_ID';
    const user_id_column = 'USER_ID';
    const status_column = 'STATUS';
    const created_date_column = 'CREATED';
    const last_activity_date_column = 'LAST_ACTIVITY';

    public static function create_session_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " VARCHAR(128) NOT NULL PRIMARY KEY, " .
            self::user_id_column . " INT NOT NULL, " .
            self::status_column . " VARCHAR(12), " .
            self::created_date_column . " DATETIME, " .
            self::last_activity_date_column . " DATETIME, " .
            "CONSTRAINT foreign_key_" . self::user_id_column . " FOREIGN KEY (" . self::user_id_column . ") REFERENCES " . UserDAO::table_name . "(" . UserDAO::id_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query = "SELECT * FROM " . self::table_name . " ORDER BY " . self::created_date_column . ", " . self::last_activity_date_column . ", " . self::status_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of sessions ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load session by id ');
    }

    public static function get_by_user_id($user_id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::user_id_column . " = :" . self::user_id_column;
        $parameters = array(
            ':' . self::user_id_column => self::sanitize_email($user_id),
        );
        return self::load_object($query, $parameters, new self(), 'load session by user id ');
    }

    public static function session_id_already_taken($id)
    {
        return self::get_by_id($id) != null;
    }

    public static function user_already_has_session($user_id)
    {
        return self::get_by_user_id($user_id) != null;
    }

    public static function create($id, $user_id)
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
            ':' . self::status_column => 'active',
            ':' . self::created_date_column => date('Y-m-d H:i:s'),
            ':' . self::last_activity_date_column => date('Y-m-d H:i:s'),
        );
        self::insert_update_delete_create($query, $parameters, 'save session ');
        return self::get_by_id($id);
    }


    public static function update_status($id, $status)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::status_column . " = :" . self::status_column . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::status_column => $status,
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'update status ');
    }

    public static function update_last_activity_date($id)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::last_activity_date_column . " = :" . self::last_activity_date_column . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::last_activity_date_column => date('Y-m-d H:i:s'),
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'update last activity date ');
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete session by id ');
    }

    public static function delete_by_user_id($user_id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::user_id_column . " = :" . self::user_id_column;
        $parameters = array(
            ':' . self::user_id_column => $user_id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete session by user id ');
    }

    public static function delete_by_last_activity($date)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::last_activity_date_column . " < :" . self::last_activity_date_column;
        $parameters = array(
            ':' . self::last_activity_date_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($date))),
        );
        self::insert_update_delete_create($query, $parameters, 'delete session by user id ');
    }

    public static function delete_by_created_date($date)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::created_date_column . " < :" . self::created_date_column;
        $parameters = array(
            ':' . self::created_date_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($date))),
        );
        self::insert_update_delete_create($query, $parameters, 'delete session by user id ');
    }

    public function map(array $row)
    {
        return new Session(
            $row[self::id_column],
            $row[self::user_id_column],
            $row[self::status_column],
            $row[self::created_date_column],
            $row[self::last_activity_date_column]
        );
    }
}

?>