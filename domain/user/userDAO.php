<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/user', 'user.php');
load::load_file('domain/session', 'sessionDAO.php');
class UserDAO extends DAO implements Mapper
{
    const table_name = 'USER';
    const name_column = 'NAME';
    const password_column = 'PASSWORD';
    const email_column = 'EMAIL';
    const mobile_column = 'MOBILE';
    const activation_key_column = 'USER_ACTIVATION_KEY';

    public static function create_user_schema(Error $errors)
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ', $errors);

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::name_column . " VARCHAR(25), " .
            self::password_column . " VARCHAR(12), " .
            self::email_column . " VARCHAR(75), " .
            self::mobile_column . " VARCHAR(25), " .
            self::activation_key_column . " VARCHAR(20), " .
            "CONSTRAINT unique_" . self::email_column . " UNIQUE (" . self::email_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ', $errors);
    }

    public static function get_all(Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of users ', $errors);
    }

    public static function get_by_id($id, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load user by id ', $errors);
    }

    public static function get_by_session_id($session_id, Error $errors)
    {
        $query =
            "SELECT * " .
                " FROM " . self::table_name .
                " INNER JOIN " . SessionDAO::table_name .
                " ON " . self::table_name . "." . self::id_column . " = " . SessionDAO::table_name . "." . SessionDAO::user_id_column .
                " WHERE " . SessionDAO::table_name . "." . SessionDAO::id_column . " = :" . SessionDAO::id_column;
        $parameters = array(
            ':' . SessionDAO::id_column => $session_id,
        );
        return self::load_object($query, $parameters, new self(), 'load user by id ', $errors);
    }

    public static function get_by_email($email, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
        );
        return self::load_object($query, $parameters, new self(), 'load user by email ', $errors);
    }

    public static function email_already_registered($email, Error $errors)
    {
        return self::get_by_email($email, $errors) != null;
    }

    public static function get_by_email_and_activation_key($email, $key, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column . " AND " . self::activation_key_column . " = :" . self::activation_key_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
            ':' . self::activation_key_column => $key,
        );
        return self::load_object($query, $parameters, new self(), 'load user by email and activation key ', $errors);
    }


    public static function get_by_email_and_password($email, $password, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column . " AND " . self::password_column . " = :" . self::password_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
            ':' . self::password_column => $password,
        );
        return self::load_object($query, $parameters, new self(), 'load user by email and password ', $errors);
    }

    public static function create($name, $password, $email, $mobile, $key, Error $errors)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::name_column . "," .
            self::password_column . "," .
            self::email_column . "," .
            self::mobile_column . "," .
            self::activation_key_column .
            ") VALUES (" .
            ":" . self::name_column . "," .
            ":" . self::password_column . "," .
            ":" . self::email_column . "," .
            ":" . self::mobile_column . "," .
            ":" . self::activation_key_column .
            ")";
        $parameters = array(
            ':' . self::name_column => self::sanitize_value($name),
            ':' . self::password_column => $password,
            ':' . self::email_column => self::sanitize_email($email),
            ':' . self::mobile_column => self::sanitize_value($mobile),
            ':' . self::activation_key_column => $key,
        );
        self::insert_update_delete_create($query, $parameters, 'save user ', $errors);
        return self::get_by_email($email, $errors);
    }


    public static function update_password($email, $new_password, Error $errors)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::password_column . " = :" . self::password_column . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::password_column => $new_password,
            ':' . self::email_column => self::sanitize_email($email),
        );
        self::insert_update_delete_create($query, $parameters, 'update password ', $errors);
    }

    public static function update_activation_key($email, $key, Error $errors)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::activation_key_column . " = :" . self::activation_key_column . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::activation_key_column => $key,
            ':' . self::email_column => self::sanitize_email($email),
        );
        self::insert_update_delete_create($query, $parameters, 'update activate key ', $errors);
    }

    public static function delete_by_id($id, Error $errors)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete user by id ', $errors);
    }

    public static function get_activation_key($email, Error $errors)
    {
        $query = "SELECT " . self::activation_key_column . " FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
        );
        self::insert_update_delete_create($query, $parameters, 'load activation key ', $errors);
    }

    public function map(array $user_row, Error $errors)
    {
        return new User(
            $user_row[self::id_column],
            $user_row[self::name_column],
            $user_row[self::email_column],
            $user_row[self::mobile_column]
        );
    }
}

?>