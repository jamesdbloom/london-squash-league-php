<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/match', 'match.php');
load::load_file('domain/player', 'playerDAO.php');
load::load_file('domain/round', 'roundDAO.php');
class MatchDAO extends DAO implements Mapper
{
    const table_name = 'MATCHES';
    const player_one_id_column = 'PLAYER_ONE_ID';
    const player_two_id_column = 'PLAYER_TWO_ID';
    const round_id_column = 'ROUND_ID';

    public static function create_match_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::player_one_id_column . " INT NOT NULL, " .
            self::player_two_id_column . " INT NOT NULL, " .
            self::round_id_column . " VARCHAR(25), " .
            "CONSTRAINT foreign_key_" . self::player_one_id_column . " FOREIGN KEY (" . self::player_one_id_column . ") REFERENCES " . UserDAO::table_name . "(" . UserDAO::id_column . "), " .
            "CONSTRAINT foreign_key_" . self::player_two_id_column . " FOREIGN KEY (" . self::player_two_id_column . ") REFERENCES " . UserDAO::table_name . "(" . UserDAO::id_column . "), " .
            "CONSTRAINT foreign_key_" . self::round_id_column . " FOREIGN KEY (" . self::round_id_column . ") REFERENCES " . DivisionDAO::table_name . "(" . DivisionDAO::id_column . "), " .
            "CONSTRAINT unique_" . self::player_one_id_column . "_" . self::player_two_id_column . "_" . self::round_id_column . " UNIQUE (" . self::player_one_id_column . ", " . self::player_two_id_column . ", " . self::round_id_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }


    public static function create_stored_procedure()
    {
        $procedure_name = self::table_name . "_CREATE_MATCH";
        $query = "DELIMITER // DROP PROCEDURE IF EXISTS " . $procedure_name . " " .
            "CREATE PROCEDURE " . $procedure_name . " (" .
            "IN " . strtolower(self::player_one_id_column) . " INT NOT NULL, " .
            "IN " . strtolower(self::player_two_id_column) . " INT NOT NULL, " .
            "IN " . strtolower(self::round_id_column) . " VARCHAR(25)" . ") " .
            "BEGIN " .
                "IF " . strtolower(self::player_one_id_column) . " IS NOT " . strtolower(self::player_two_id_column) . " THEN " .
                    "BEGIN " .
                        "INSERT INTO " . self::table_name . "(" .
                        self::player_one_id_column . ", " .
                        self::player_two_id_column . ", " .
                        self::round_id_column .
                        ") VALUES (" .
                        ":" . self::player_one_id_column . ", " .
                        ":" . self::player_two_id_column . ", " .
                        ":" . self::round_id_column .
                        "); " .
                    "END; " .
                "ELSE " .
                    "BEGIN " .
                    "END " .
                "END IF;" .
            "END // DELIMITER ;";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create stored procedure ');
    }

    public static function get_all()
    {
        $query = "SELECT * FROM " . self::table_name;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of matches ');
    }

    public static function get_all_by_user_id($user_id)
    {
        $query =
            "SELECT DISTINCT " . MatchDAO::table_name . ".* " .
                " FROM " . MatchDAO::table_name .
                " INNER JOIN " . PlayerDAO::table_name .
                " ON ((" . MatchDAO::table_name . "." . MatchDAO::player_one_id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::id_column . ") " .
                " OR  (" . MatchDAO::table_name . "." . MatchDAO::player_two_id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::id_column . "))" .
                " WHERE " . PlayerDAO::table_name . "." . PlayerDAO::user_id_column . " = :" . PlayerDAO::user_id_column;
        $parameters = array(
            ':' . PlayerDAO::user_id_column => self::sanitize_value($user_id),
        );
        return self::load_all_objects($query, $parameters, new self(), 'load list of matches by user_id ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load match by id ');
    }

    public static function get_by_player_id_and_round_id($player_one_id, $player_two_id, $round_id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::player_one_id_column . " = :" . self::player_one_id_column . " AND " . self::player_two_id_column . " = :" . self::player_two_id_column . " AND " . self::round_id_column . " = :" . self::round_id_column;
        $parameters = array(
            ':' . self::player_one_id_column => self::sanitize_value($player_one_id),
            ':' . self::player_two_id_column => self::sanitize_value($player_two_id),
            ':' . self::round_id_column => self::sanitize_email($round_id),
        );
        return self::load_object($query, $parameters, new self(), 'load player by email ');
    }

    public static function create($player_one_id, $player_two_id, $round_id)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::player_one_id_column . "," .
            self::player_two_id_column . "," .
            self::round_id_column .
            ") VALUES (" .
            ":" . self::player_one_id_column . "," .
            ":" . self::player_two_id_column . "," .
            ":" . self::round_id_column .
            ")";
        $parameters = array(
            ':' . self::player_one_id_column => self::sanitize_value($player_one_id),
            ':' . self::player_two_id_column => self::sanitize_value($player_two_id),
            ':' . self::round_id_column => self::sanitize_value($round_id),
        );
        self::insert_update_delete_create($query, $parameters, 'save match ');
        return self::get_by_player_id_and_round_id($player_one_id, $player_two_id, $round_id);
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete match by id ');
    }

    public function map(array $match_row)
    {
        return new Match(
            $match_row[self::id_column],
            $match_row[self::player_one_id_column],
            $match_row[self::player_two_id_column],
            $match_row[self::round_id_column]
        );
    }
}

?>