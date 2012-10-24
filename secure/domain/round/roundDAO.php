<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/round', 'round.php');
load::load_file('domain/division', 'divisionDAO.php');
class RoundDAO extends DAO implements Mapper
{
    const table_name = 'ROUND';
    const id_column = 'ROUND_ID';
    const division_id_column = 'DIVISION_ID';
    const start_column = 'START';
    const end_column = 'END';

    public static function create_round_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::division_id_column . " INT NOT NULL, " .
            self::start_column . " DATETIME NOT NULL, " .
            self::end_column . " DATETIME NOT NULL, " .
            "CONSTRAINT foreign_key_" . self::division_id_column . " FOREIGN KEY (" . self::division_id_column . ") REFERENCES " . DivisionDAO::table_name . "(" . DivisionDAO::id_column . "), " .
            "CONSTRAINT unique_" . self::division_id_column . "_" . self::start_column . " UNIQUE (" . self::division_id_column . ", " . self::start_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query = "SELECT DISTINCT " . self::table_name . ".* FROM " . self::table_name . " " .
            "JOIN " . DivisionDAO::table_name . " USING (" . self::division_id_column . ") " .
            "JOIN " . LeagueDAO::table_name . " USING (" . DivisionDAO::league_id_column . ") " .
            "JOIN " . ClubDAO::table_name . " USING (" . LeagueDAO::club_id_column . ") " .
            "ORDER BY " .
            ClubDAO::table_name . "." . ClubDAO::name_column . ", " .
            LeagueDAO::table_name . "." . LeagueDAO::name_column . ", " .
            self::start_column . ", " .
            DivisionDAO::table_name . "." . DivisionDAO::name_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of rounds ');
    }

    public static function get_all_by_user_id($user_id)
    {
        $query =
            "SELECT DISTINCT " . RoundDAO::table_name . ".* " .
                " FROM " . RoundDAO::table_name .
                "   INNER JOIN " . PlayerDAO::table_name .
                " ON " . RoundDAO::table_name . "." . RoundDAO::division_id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::division_id_column .
                " WHERE " . PlayerDAO::table_name . "." . PlayerDAO::user_id_column . " = :" . PlayerDAO::user_id_column .
                " AND " . PlayerDAO::table_name . "." . PlayerDAO::status_column . " <> '" . Player::inactive . "' ";
        $parameters = array(
            ':' . PlayerDAO::user_id_column => self::sanitize_value($user_id),
        );
        return self::load_all_objects($query, $parameters, new self(), 'load list of rounds by user_id ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load round by id ');
    }

    public static function create($division_id, $start, $end)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::division_id_column . "," .
            self::start_column . "," .
            self::end_column .
            ") VALUES (" .
            ":" . self::division_id_column . "," .
            ":" . self::start_column . "," .
            ":" . self::end_column .
            ")";
        $parameters = array(
            ':' . self::division_id_column => self::sanitize_value($division_id),
            ':' . self::start_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($start))),
            ':' . self::end_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($end))),
        );
        self::insert_update_delete_create($query, $parameters, 'save round ');
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete round by id ');
    }

    public function map(array $round_row)
    {
        return new Round(
            $round_row[self::id_column],
            $round_row[self::division_id_column],
            strtotime($round_row[self::start_column]),
            strtotime($round_row[self::end_column])
        );
    }
}

?>