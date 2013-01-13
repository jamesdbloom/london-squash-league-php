<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/match', 'match.php');
load::load_file('domain/player', 'playerDAO.php');
load::load_file('domain/round', 'roundDAO.php');
class MatchDAO extends DAO implements Mapper
{
    const table_name = 'MATCHES';
    const id_column = 'MATCH_ID';
    const player_one_id_column = 'PLAYER_ONE_ID';
    const player_two_id_column = 'PLAYER_TWO_ID';
    const round_id_column = 'ROUND_ID';
    const division_id_column = 'DIVISION_ID';
    const score_column = 'SCORE';

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
            self::division_id_column . " VARCHAR(25), " .
            self::score_column . " VARCHAR(25), " .
            "CONSTRAINT foreign_key_" . self::player_one_id_column . " FOREIGN KEY (" . self::player_one_id_column . ") REFERENCES " . UserDAO::table_name . "(" . UserDAO::id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT foreign_key_" . self::player_two_id_column . " FOREIGN KEY (" . self::player_two_id_column . ") REFERENCES " . UserDAO::table_name . "(" . UserDAO::id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT foreign_key_" . self::player_one_id_column . "_" . self::division_id_column . " FOREIGN KEY (" . self::player_one_id_column . ", " . self::division_id_column . ") REFERENCES " . PlayerDAO::table_name . "(" . PlayerDAO::user_id_column . ", " . PlayerDAO::division_id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT foreign_key_" . self::player_two_id_column . "_" . self::division_id_column . " FOREIGN KEY (" . self::player_two_id_column . ", " . self::division_id_column . ") REFERENCES " . PlayerDAO::table_name . "(" . PlayerDAO::user_id_column . ", " . PlayerDAO::division_id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT unique_" . self::player_one_id_column . "_" . self::player_two_id_column . "_" . self::round_id_column . " UNIQUE (" . self::player_one_id_column . ", " . self::player_two_id_column . ", " . self::round_id_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query = "SELECT DISTINCT " . self::table_name . ".* FROM " . self::table_name . " " .
            "JOIN " . PlayerDAO::table_name . " AS " . PlayerDAO::table_name . "_ONE" .
            " ON " . self::table_name . "." . self::player_one_id_column . " = " . PlayerDAO::table_name . "_ONE" . "." . PlayerDAO::id_column . " " .
            "JOIN " . PlayerDAO::table_name . " AS " . PlayerDAO::table_name . "_TWO" .
            " ON " . self::table_name . "." . self::player_one_id_column . " = " . PlayerDAO::table_name . "_TWO" . "." . PlayerDAO::id_column . " " .
            "JOIN " . UserDAO::table_name . " AS " . UserDAO::table_name . "_ONE" .
            " ON " . PlayerDAO::table_name . "_ONE." . PlayerDAO::user_id_column . " = " . UserDAO::table_name . "_ONE." . UserDAO::id_column . " " .
            "JOIN " . UserDAO::table_name . " AS " . UserDAO::table_name . "_TWO" .
            " ON " . PlayerDAO::table_name . "_TWO." . PlayerDAO::user_id_column . " = " . UserDAO::table_name . "_TWO." . UserDAO::id_column . " " .
            "JOIN " . RoundDAO::table_name . " ON " . self::table_name . "." . self::round_id_column . " = " . RoundDAO::table_name . "." . RoundDAO::id_column . " " .
            " WHERE " . PlayerDAO::table_name . "_ONE." . PlayerDAO::status_column . " <> '" . Player::inactive . "' " .
            " AND " . PlayerDAO::table_name . "_TWO." . PlayerDAO::status_column . " <> '" . Player::inactive . "' " .
            "ORDER BY " .
            RoundDAO::table_name . "." . RoundDAO::start_column . " DESC, " .
            UserDAO::table_name . "_ONE" . "." . UserDAO::name_column . ", " .
            UserDAO::table_name . "_TWO" . "." . UserDAO::name_column;
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
                " INNER JOIN " . RoundDAO::table_name . " USING (" . RoundDAO::id_column . ") " .
                " WHERE " . PlayerDAO::table_name . "." . PlayerDAO::user_id_column . " = :" . PlayerDAO::user_id_column .
                " AND " . PlayerDAO::table_name . "." . PlayerDAO::status_column . " <> '" . Player::inactive . "' " .
                "ORDER BY " .
                RoundDAO::table_name . "." . RoundDAO::end_column . " DESC, " .
                RoundDAO::table_name . "." . RoundDAO::start_column;
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

    public static function create($player_one_id, $player_two_id, $round_id, $division_id)
    {
        if ($player_one_id != $player_two_id) {
            $query = "INSERT INTO " . self::table_name . "(" .
                self::player_one_id_column . "," .
                self::player_two_id_column . "," .
                self::round_id_column . "," .
                self::division_id_column .
                ") VALUES (" .
                ":" . self::player_one_id_column . "," .
                ":" . self::player_two_id_column . "," .
                ":" . self::round_id_column . "," .
                ":" . self::division_id_column .
                ")";
            $parameters = array(
                ':' . self::player_one_id_column => self::sanitize_value($player_one_id),
                ':' . self::player_two_id_column => self::sanitize_value($player_two_id),
                ':' . self::round_id_column => self::sanitize_value($round_id),
                ':' . self::division_id_column => self::sanitize_value($division_id),
            );
            self::insert_update_delete_create($query, $parameters, 'save match ');
            return self::get_by_player_id_and_round_id($player_one_id, $player_two_id, $round_id);
        } else {
            $GLOBALS['errors']->add('validation_error', "A match can only be created between two different players");
        }
    }

    public static function update_score_by_id($match_id, $score)
    {
        $query =
            "UPDATE " . self::table_name .
                " SET " . self::score_column . " = :" . self::score_column .
                " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::score_column => $score,
            ':' . self::id_column => $match_id,
        );
        self::insert_update_delete_create($query, $parameters, 'update player status by division id and user id ');
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
            $match_row[self::round_id_column],
            $match_row[self::division_id_column],
            $match_row[self::score_column]
        );
    }
}

?>