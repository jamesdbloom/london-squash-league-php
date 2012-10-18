<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/player', 'player.php');
load::load_file('domain/user', 'userDAO.php');
load::load_file('domain/division', 'divisionDAO.php');
class PlayerDAO extends DAO implements Mapper
{
    const table_name = 'PLAYER';
    const id_column = 'PLAYER_ID';
    const user_id_column = 'USER_ID';
    const division_id_column = 'DIVISION_ID';

    public static function create_player_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::user_id_column . " INT NOT NULL, " .
            self::division_id_column . " VARCHAR(25), " .
            "CONSTRAINT foreign_key_" . self::user_id_column . " FOREIGN KEY (" . self::user_id_column . ") REFERENCES " . UserDAO::table_name . "(" . UserDAO::id_column . "), " .
            "CONSTRAINT foreign_key_" . self::division_id_column . " FOREIGN KEY (" . self::division_id_column . ") REFERENCES " . DivisionDAO::table_name . "(" . DivisionDAO::id_column . "), " .
            "CONSTRAINT unique_" . self::user_id_column . "_" . self::division_id_column . " UNIQUE (" . self::user_id_column . ", " . self::division_id_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query = "SELECT DISTINCT " . self::table_name . ".* FROM " . self::table_name . " " .
            "JOIN " . UserDAO::table_name . " USING (" . self::user_id_column . ") " .
            "JOIN " . DivisionDAO::table_name . " USING (" . self::division_id_column . ") " .
            "JOIN " . LeagueDAO::table_name . " USING (" . DivisionDAO::league_id_column . ") " .
            "JOIN " . ClubDAO::table_name . " USING (" . LeagueDAO::club_id_column . ") " .
            "ORDER BY " .
            ClubDAO::table_name . "." . ClubDAO::name_column . ", " .
            LeagueDAO::table_name . "." . LeagueDAO::name_column . ", " .
            DivisionDAO::table_name . "." . DivisionDAO::name_column . ", " .
            UserDAO::table_name . "." . UserDAO::name_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of players ');
    }

    public static function get_all_by_user_id($user_id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::user_id_column . " = :" . self::user_id_column;
        $parameters = array(
            ':' . self::user_id_column => self::sanitize_value($user_id),
        );
        return self::load_all_objects($query, $parameters, new self(), 'load list of players by user_id ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load player by id ');
    }

    public static function create($user_id, $division_id)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::user_id_column . "," .
            self::division_id_column .
            ") VALUES (" .
            ":" . self::user_id_column . "," .
            ":" . self::division_id_column .
            ")";
        $parameters = array(
            ':' . self::user_id_column => self::sanitize_value($user_id),
            ':' . self::division_id_column => self::sanitize_value($division_id),
        );
        self::insert_update_delete_create($query, $parameters, 'save player ');
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete player by id ');
    }

    public static function delete_by_division_id_and_user_id($division_id, $user_id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::division_id_column . " = :" . self::division_id_column . " AND " . self::user_id_column . " = :" . self::user_id_column;
        $parameters = array(
            ':' . self::division_id_column => $division_id,
            ':' . self::user_id_column => $user_id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete player by division id and user id ');
    }

    public function map(array $player_row)
    {
        return new Player(
            $player_row[self::id_column],
            $player_row[self::user_id_column],
            $player_row[self::division_id_column]
        );
    }
}

?>