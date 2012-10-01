<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/division', 'division.php');
load::load_file('domain/league', 'leagueDAO.php');
class DivisionDAO extends DAO implements Mapper
{
    const table_name = 'DIVISION';
    const league_id_column = 'LEAGUE_ID';
    const name_column = 'NAME';

    public static function create_division_schema(Error $errors)
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ', $errors);

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::league_id_column . " INT NOT NULL, " .
            self::name_column . " VARCHAR(25), " .
            "CONSTRAINT unique_" . self::league_id_column . " FOREIGN KEY (" . self::league_id_column . ") REFERENCES " . LeagueDAO::table_name . "(" . LeagueDAO::id_column . "), " .
            "CONSTRAINT unique_" . self::name_column . " UNIQUE (" . self::name_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ', $errors);
    }

    public static function get_all(Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of divisions ', $errors);
    }

    public static function get_by_id($id, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load division by id ', $errors);
    }

    public static function get_by_name($name, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::name_column . " = :" . self::name_column;
        $parameters = array(
            ':' . self::name_column => self::sanitize_email($name),
        );
        return self::load_object($query, $parameters, new self(), 'load user by email ', $errors);
    }

    public static function create($league_id, $name, Error $errors)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::league_id_column . "," .
            self::name_column .
            ") VALUES (" .
            ":" . self::league_id_column . "," .
            ":" . self::name_column .
            ")";
        $parameters = array(
            ':' . self::league_id_column => self::sanitize_value($league_id),
            ':' . self::name_column => self::sanitize_value($name),
        );
        self::insert_update_delete_create($query, $parameters, 'save division ', $errors);
        return self::get_by_name($name, $errors);
    }

    public static function delete_by_id($id, Error $errors)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete division by id ', $errors);
    }

    public function map(array $division_row, Error $errors)
    {
        return new Division(
            $division_row[self::id_column],
            $division_row[self::league_id_column],
            $division_row[self::name_column]
        );
    }
}

?>