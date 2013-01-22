<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/league', 'league.php');
load::load_file('domain/club', 'clubDAO.php');
class LeagueDAO extends DAO implements Mapper
{
    const table_name = 'LEAGUE';
    const id_column = 'LEAGUE_ID';
    const club_id_column = 'CLUB_ID';
    const name_column = 'NAME';

    public static function create_league_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::club_id_column . " INT NOT NULL, " .
            self::name_column . " VARCHAR(25), " .
            "CONSTRAINT foreign_key_" . self::club_id_column . " FOREIGN KEY (" . self::club_id_column . ") REFERENCES " . ClubDAO::table_name . "(" . ClubDAO::id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT unique_" . self::club_id_column . "_" . self::name_column . " UNIQUE (" . self::club_id_column . ", " . self::name_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query =
            "SELECT DISTINCT " . LeagueDAO::table_name . ".* " .
                "FROM " . self::table_name . " JOIN " . ClubDAO::table_name . " " .
                "USING (" . self::club_id_column . ") " .
                "ORDER BY " . ClubDAO::table_name . "." . ClubDAO::name_column . ", " . self::table_name . "." . self::name_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of leagues ');
    }

    public static function get_all_by_user_id($user_id, $ignore_player_status = false, $ignore_round_status = false)
    {
        $query =
            "SELECT DISTINCT " . LeagueDAO::table_name . ".* " .
                " FROM " . LeagueDAO::table_name .
                " JOIN " . DivisionDAO::table_name .
                " ON " . LeagueDAO::table_name . "." . LeagueDAO::id_column . " = " . DivisionDAO::table_name . "." . DivisionDAO::league_id_column .
                " JOIN " . MatchDAO::table_name .
                " ON " . DivisionDAO::table_name . "." . DivisionDAO::id_column . " = " . MatchDAO::table_name . "." . MatchDAO::division_id_column .
                " JOIN " . PlayerDAO::table_name .
                " ON " . MatchDAO::table_name . "." . MatchDAO::player_one_id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::id_column .
                " OR " . MatchDAO::table_name . "." . MatchDAO::player_two_id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::id_column .
                " JOIN " . RoundDAO::table_name .
                " ON " . DivisionDAO::table_name . "." . DivisionDAO::round_id_column . " = " . RoundDAO::table_name . "." . RoundDAO::id_column .
                " WHERE " . PlayerDAO::table_name . "." . PlayerDAO::user_id_column . " = :" . PlayerDAO::user_id_column .
                ($ignore_round_status ? "" : " AND " . RoundDAO::table_name . "." . RoundDAO::start_column . " <= CURDATE() AND " . RoundDAO::table_name . "." . RoundDAO::end_column . " >= CURDATE()");
        ($ignore_player_status ? "" : " AND " . PlayerDAO::table_name . "." . PlayerDAO::status_column . " <> '" . Player::inactive . "' ");
        $parameters = array(
            ':' . PlayerDAO::user_id_column => self::sanitize_value($user_id),
        );
        return self::load_all_objects($query, $parameters, new self(), 'load list of leagues by user_id ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load league by id ');
    }

    public static function get_by_name($name)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::name_column . " = :" . self::name_column;
        $parameters = array(
            ':' . self::name_column => self::sanitize_email($name),
        );
        return self::load_object($query, $parameters, new self(), 'load user by email ');
    }

    public static function create($club_id, $name)
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
        self::insert_update_delete_create($query, $parameters, 'save league ');
        return self::get_by_name($name);
    }

    public static function update($id, $club_id, $name)
    {
        $query = "UPDATE " . self::table_name . " SET " .
            self::club_id_column . " = :" . self::club_id_column . ", " .
            self::name_column . " = :" . self::name_column .
            " WHERE " .
            self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => self::sanitize_value($id),
            ':' . self::club_id_column => self::sanitize_value($club_id),
            ':' . self::name_column => self::sanitize_value($name),
        );
        self::insert_update_delete_create($query, $parameters, 'update league ');
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete league by id ');
    }

    public function map(array $league_row)
    {
        return new League(
            $league_row[self::id_column],
            $league_row[self::club_id_column],
            $league_row[self::name_column]
        );
    }
}

?>