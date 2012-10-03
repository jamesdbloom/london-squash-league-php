<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/club', 'club.php');
class ClubDAO extends DAO implements Mapper
{
    const table_name = 'CLUB';
    const name_column = 'NAME';
    const address_column = 'ADDRESS';

    public static function create_club_schema(Error $errors)
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ', $errors);

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::name_column . " VARCHAR(25), " .
            self::address_column . " VARCHAR(125), " .
            "CONSTRAINT unique_" . self::name_column . " UNIQUE (" . self::name_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ', $errors);
    }

    public static function get_all(Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of clubs ', $errors);
    }

    public static function get_by_id($id, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load club by id ', $errors);
    }

    public static function get_by_name($name, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::name_column . " = :" . self::name_column;
        $parameters = array(
            ':' . self::name_column => self::sanitize_value($name),
        );
        return self::load_object($query, $parameters, new self(), 'load club by name ', $errors);
    }

    public static function create($name, $address, Error $errors)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::name_column . "," .
            self::address_column .
            ") VALUES (" .
            ":" . self::name_column . "," .
            ":" . self::address_column .
            ")";
        $parameters = array(
            ':' . self::name_column => self::sanitize_value($name),
            ':' . self::address_column => self::sanitize_value($address),
        );
        self::insert_update_delete_create($query, $parameters, 'save club ', $errors);
        return self::get_by_name($name, $errors);
    }

    public static function delete_by_id($id, Error $errors)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete club by id ', $errors);
    }

    public function map(array $club_row, Error $errors)
    {
        return new Club(
            $club_row[self::id_column],
            $club_row[self::name_column],
            $club_row[self::address_column]
        );
    }
}

?>