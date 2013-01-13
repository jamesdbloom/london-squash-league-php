<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/division', 'division.php');
load::load_file('domain/league', 'leagueDAO.php');
class DivisionDAO extends DAO implements Mapper
{
    const table_name = 'DIVISION';
    const id_column = 'DIVISION_ID';
    const league_id_column = 'LEAGUE_ID';
    const round_id_column = 'ROUND_ID';
    const name_column = 'NAME';

//     // 1: backup round table
//     DROP TABLE DIVISION_BACKUP;
//     CREATE TABLE DIVISION_BACKUP LIKE DIVISION;
//     INSERT DIVISION_BACKUP SELECT * FROM DIVISION;
//     // 2: add column and reference constraint
//     ALTER TABLE DIVISION ADD COLUMN ROUND_ID INT NOT NULL;
//     ALTER TABLE DIVISION ADD CONSTRAINT foreign_key_ROUND_ID FOREIGN KEY (ROUND_ID) REFERENCES ROUND(ROUND_ID);
//     UPDATE DIVISION SET DIVISION.ROUND_ID = (SELECT ROUND.ROUND_ID FROM ROUND WHERE ROUND.LEAGUE_ID = DIVISION.LEAGUE_ID);
//     ALTER TABLE DIVISION DROP INDEX unique_LEAGUE_ID_NAME;
//     ALTER TABLE DIVISION ADD CONSTRAINT unique_ROUND_ID_NAME UNIQUE (ROUND_ID, NAME);

    public static function create_division_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::league_id_column . " INT NOT NULL, " .
            self::round_id_column . " INT NOT NULL, " .
            self::name_column . " VARCHAR(25), " .
            "CONSTRAINT foreign_key_" . self::league_id_column . " FOREIGN KEY (" . self::league_id_column . ") REFERENCES " . LeagueDAO::table_name . "(" . LeagueDAO::id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT foreign_key_" . self::round_id_column . " FOREIGN KEY (" . self::round_id_column . ") REFERENCES " . LeagueDAO::table_name . "(" . LeagueDAO::id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT unique_" . self::round_id_column . "_" . self::name_column . " UNIQUE (" . self::round_id_column . ", " . self::name_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query =
            "SELECT DISTINCT " . self::table_name . ".* FROM " . self::table_name . " " .
                "JOIN " . LeagueDAO::table_name . " USING (" . self::league_id_column . ") " .
                "JOIN " . RoundDAO::table_name . " USING (" . self::round_id_column . ") " .
                "JOIN " . ClubDAO::table_name . " USING (" . LeagueDAO::club_id_column . ") " .
                "ORDER BY " .
                ClubDAO::table_name . "." . ClubDAO::name_column . ", " .
                RoundDAO::table_name . "." . RoundDAO::start_column . " DESC, " .
                LeagueDAO::table_name . "." . LeagueDAO::name_column . ", " .
                self::table_name . "." . self::name_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of divisions ');
    }

    public static function get_all_by_user_id($user_id, $ignore_player_status = false)
    {
        $query =
            "SELECT DISTINCT " . DivisionDAO::table_name . ".* " .
                " FROM " . DivisionDAO::table_name .
                " INNER JOIN " . PlayerDAO::table_name .
                " ON " . DivisionDAO::table_name . "." . DivisionDAO::id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::division_id_column .
                " WHERE " . PlayerDAO::table_name . "." . PlayerDAO::user_id_column . " = :" . PlayerDAO::user_id_column .
                ($ignore_player_status ? "" : " AND " . PlayerDAO::table_name . "." . PlayerDAO::status_column . " <> '" . Player::inactive . "' ");
        $parameters = array(
            ':' . PlayerDAO::user_id_column => self::sanitize_value($user_id),
        );
        return self::load_all_objects($query, $parameters, new self(), 'load list of divisions by user_id ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load division by id ');
    }

    public static function get_by_name($name)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::name_column . " = :" . self::name_column;
        $parameters = array(
            ':' . self::name_column => self::sanitize_email($name),
        );
        return self::load_object($query, $parameters, new self(), 'load user by email ');
    }

    public static function create($league_id, $round_id, $name)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::league_id_column . "," .
            self::round_id_column . "," .
            self::name_column .
            ") VALUES (" .
            ":" . self::league_id_column . "," .
            ":" . self::round_id_column . "," .
            ":" . self::name_column .
            ")";
        $parameters = array(
            ':' . self::league_id_column => self::sanitize_value($league_id),
            ':' . self::round_id_column => self::sanitize_value($round_id),
            ':' . self::name_column => self::sanitize_value($name),
        );
        self::insert_update_delete_create($query, $parameters, 'save division ');
        return self::get_by_name($name);
    }

    public static function update($id, $league_id, $round_id, $name)
    {
        $query = "UPDATE " . self::table_name . " SET " .
            self::league_id_column . " = :" . self::league_id_column . ", " .
            self::round_id_column . " = :" . self::round_id_column . ", " .
            self::name_column . " = :" . self::name_column .
            " WHERE " .
            self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => self::sanitize_value($id),
            ':' . self::league_id_column => self::sanitize_value($league_id),
            ':' . self::round_id_column => self::sanitize_value($round_id),
            ':' . self::name_column => self::sanitize_value($name),
        );
        self::insert_update_delete_create($query, $parameters, 'update division ');
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete division by id ');
    }

    public function map(array $division_row)
    {
        return new Division(
            $division_row[self::id_column],
            $division_row[self::league_id_column],
            $division_row[self::round_id_column],
            $division_row[self::name_column]
        );
    }
}

?>