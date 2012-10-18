<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/user', 'user.php');
load::load_file('domain/session', 'sessionDAO.php');
class UserDAO extends DAO implements Mapper
{
    const table_name = 'USER';
    const id_column = 'USER_ID';
    const name_column = 'NAME';
    const password_column = 'PASSWORD';
    const email_column = 'EMAIL';
    const mobile_column = 'MOBILE';
    const type_column = 'TYPE';
    const activation_key_column = 'USER_ACTIVATION_KEY';

    public static function create_user_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::name_column . " VARCHAR(25), " .
            self::password_column . " VARCHAR(12), " .
            self::email_column . " VARCHAR(75), " .
            self::mobile_column . " VARCHAR(25), " .
            self::activation_key_column . " VARCHAR(20), " .
            self::type_column . " VARCHAR(12), " .
            "CONSTRAINT unique_" . self::email_column . " UNIQUE (" . self::email_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query = "SELECT * FROM " . self::table_name . " ORDER BY " . self::name_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of users ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load user by id ');
    }

    public static function get_by_session_id($session_id)
    {
        $query =
            "SELECT DISTINCT " . UserDAO::table_name . ".* " .
                " FROM " . UserDAO::table_name .
                " INNER JOIN " . SessionDAO::table_name .
                " ON " . UserDAO::table_name . "." . UserDAO::id_column . " = " . SessionDAO::table_name . "." . SessionDAO::user_id_column .
                " WHERE " . SessionDAO::table_name . "." . SessionDAO::id_column . " = :" . SessionDAO::id_column;
        $parameters = array(
            ':' . SessionDAO::id_column => $session_id,
        );
        return self::load_object($query, $parameters, new self(), 'load user by id ');
    }

    public static function get_by_email($email)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
        );
        return self::load_object($query, $parameters, new self(), 'load user by email ');
    }

    public static function email_already_registered($email)
    {
        return self::get_by_email($email) != null;
    }

    public static function get_by_email_and_activation_key($email, $key)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column . " AND " . self::activation_key_column . " = :" . self::activation_key_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
            ':' . self::activation_key_column => $key,
        );
        return self::load_object($query, $parameters, new self(), 'load user by email and activation key ');
    }


    public static function get_by_email_and_password($email, $password)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column . " AND " . self::password_column . " = :" . self::password_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
            ':' . self::password_column => $password,
        );
        return self::load_object($query, $parameters, new self(), 'load user by email and password ');
    }

    public static function create($name, $password, $email, $mobile, $key, $type = User::player)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::name_column . "," .
            self::password_column . "," .
            self::email_column . "," .
            self::mobile_column . "," .
            self::activation_key_column . "," .
            self::type_column .
            ") VALUES (" .
            ":" . self::name_column . "," .
            ":" . self::password_column . "," .
            ":" . self::email_column . "," .
            ":" . self::mobile_column . "," .
            ":" . self::activation_key_column . "," .
            ":" . self::type_column .
            ")";
        $parameters = array(
            ':' . self::name_column => self::sanitize_value($name),
            ':' . self::password_column => $password,
            ':' . self::email_column => self::sanitize_email($email),
            ':' . self::mobile_column => self::sanitize_value($mobile),
            ':' . self::activation_key_column => $key,
            ':' . self::type_column => $type,
        );
        self::insert_update_delete_create($query, $parameters, 'save user ');
        return self::get_by_email($email);
    }


    public static function update_password($email, $new_password)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::password_column . " = :" . self::password_column . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::password_column => $new_password,
            ':' . self::email_column => self::sanitize_email($email),
        );
        self::insert_update_delete_create($query, $parameters, 'update password ');
    }

    public static function update_activation_key($email, $key)
    {
        $query = "UPDATE " . self::table_name . " SET " . self::activation_key_column . " = :" . self::activation_key_column . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::activation_key_column => $key,
            ':' . self::email_column => self::sanitize_email($email),
        );
        self::insert_update_delete_create($query, $parameters, 'update activate key ');
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete user by id ');
    }

    public static function get_activation_key($email)
    {
        $query = "SELECT " . self::activation_key_column . " FROM " . self::table_name . " WHERE " . self::email_column . " = :" . self::email_column;
        $parameters = array(
            ':' . self::email_column => self::sanitize_email($email),
        );
        return self::load_value($query, $parameters, 'load activation key ');
    }

    public function map(array $user_row)
    {
        return new User(
            $user_row[self::id_column],
            $user_row[self::name_column],
            $user_row[self::email_column],
            $user_row[self::mobile_column],
            $user_row[self::type_column]
        );
    }
}

?>