<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/league', 'league.php');
load::load_file('domain/club', 'clubDAO.php');
class LeagueDAO extends DAO implements Mapper
{
    const table_name = 'LEAGUE';
    const club_id_column = 'CLUB_ID';
    const name_column = 'NAME';

    public static function create_league_schema(Error $errors)
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ', $errors);

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::club_id_column . " INT NOT NULL, " .
            self::name_column . " VARCHAR(25), " .
            "CONSTRAINT unique_" . self::club_id_column . " FOREIGN KEY (" . self::club_id_column . ") REFERENCES " . ClubDAO::table_name . "(" . ClubDAO::id_column . "), " .
            "CONSTRAINT unique_" . self::name_column . " UNIQUE (" . self::club_id_column . ", " . self::name_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ', $errors);
    }

    public static function get_all(Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of leagues ', $errors);
    }

    public static function get_by_id($id, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load league by id ', $errors);
    }

    public static function get_by_name($name, Error $errors)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::name_column . " = :" . self::name_column;
        $parameters = array(
            ':' . self::name_column => self::sanitize_email($name),
        );
        return self::load_object($query, $parameters, new self(), 'load user by email ', $errors);
    }

    public static function create($club_id, $name, Error $errors)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::club_id_column . "," .
            self::name_column .
            ") VALUES (" .
            ":" . self::club_id_column . "," .
            ":" . self::name_column .
            ")";
        $parameters = array(
            ':' . self::club_id_column => self::sanitize_value($club_id),
            ':' . self::name_column => self::sanitize_value($name),
        );
        self::insert_update_delete_create($query, $parameters, 'save league ', $errors);
        return self::get_by_name($name, $errors);
    }

    public static function delete_by_id($id, Error $errors)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete league by id ', $errors);
    }

    public function map(array $league_row, Error $errors)
    {
        return new League(
            $league_row[self::id_column],
            $league_row[self::club_id_column],
            $league_row[self::name_column]
        );
    }
}

?>