<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/round', 'round.php');
load::load_file('domain/division', 'divisionDAO.php');
class RoundDAO extends DAO implements Mapper
{
    const table_name = 'ROUND';
    const id_column = 'ROUND_ID';
    const league_id_column = 'LEAGUE_ID';
    const start_column = 'START';
    const end_column = 'END';

    // 1: backup round table
//     DROP TABLE ROUND_BACKUP;
//     CREATE TABLE ROUND_BACKUP LIKE ROUND;
//     INSERT ROUND_BACKUP SELECT * FROM ROUND;
    // 2: add column and reference constraint
//     ALTER TABLE ROUND ADD COLUMN LEAGUE_ID INT NOT NULL;
//     ALTER TABLE ROUND ADD CONSTRAINT foreign_key_LEAGUE_ID FOREIGN KEY (LEAGUE_ID) REFERENCES LEAGUE(LEAGUE_ID);
//     UPDATE ROUND SET ROUND.LEAGUE_ID = (SELECT DIVISION.LEAGUE_ID FROM DIVISION WHERE DIVISION.DIVISION_ID = ROUND.DIVISION_ID);
    // 3: copy new data to temp table
//     DROP TABLE ROUND_NEW;
//     CREATE TABLE ROUND_NEW LIKE ROUND;
//     ALTER TABLE ROUND_NEW ADD CONSTRAINT foreign_key_LEAGUE_ID FOREIGN KEY (LEAGUE_ID) REFERENCES LEAGUE(LEAGUE_ID) ON UPDATE CASCADE ON DELETE RESTRICT;
//     ALTER TABLE ROUND_NEW ADD CONSTRAINT unique_LEAGUE_ID_START UNIQUE (LEAGUE_ID, START);
//     ALTER TABLE ROUND_NEW DROP INDEX unique_DIVISION_ID_START;
//     ALTER TABLE ROUND_NEW DROP COLUMN DIVISION_ID;
//     INSERT ROUND_NEW (START,END,LEAGUE_ID) SELECT START,END,LEAGUE_ID from ROUND GROUP BY START,END,LEAGUE_ID ORDER BY START,LEAGUE_ID,END;
    // 4: map old id to new id
//     DROP TABLE MATCHES_BACKUP;
//     CREATE TABLE MATCHES_BACKUP LIKE MATCHES;
//     INSERT MATCHES_BACKUP SELECT * FROM MATCHES;
//     ALTER TABLE MATCHES DROP INDEX unique_PLAYER_ONE_ID_PLAYER_TWO_ID_ROUND_ID;
//     ALTER TABLE MATCHES ADD CONSTRAINT unique_PLAYER_ONE_ID_PLAYER_TWO_ID_ROUND_ID_DIVISION_ID UNIQUE (PLAYER_ONE_ID, PLAYER_TWO_ID, ROUND_ID, DIVISION_ID);
//     UPDATE MATCHES SET MATCHES.ROUND_ID = (SELECT ROUND_NEW.ROUND_ID FROM ROUND_NEW JOIN ROUND ON ROUND_NEW.START = ROUND.START AND ROUND_NEW.LEAGUE_ID = ROUND.LEAGUE_ID WHERE MATCHES.ROUND_ID = ROUND.ROUND_ID);
    // 5: update ROUND table
//     DELETE * FROM ROUND; INSERT ROUND SELECT * FROM ROUND_NEW;
    // 6: add unique constraints
//     ALTER TABLE ROUND ADD CONSTRAINT unique_LEAGUE_ID_START UNIQUE (LEAGUE_ID, START);
//     ALTER TABLE ROUND DROP INDEX unique_DIVISION_ID_START;
//     ALTER TABLE ROUND DROP COLUMN DIVISION_ID;

// NOTES:
//select count(*),PLAYER_ONE_ID,PLAYER_TWO_ID,ROUND_NEW.ROUND_ID,DIVISION_ID from MATCHES JOIN (SELECT ROUND_NEW.ROUND_ID,ROUND.LEAGUE_ID FROM ROUND_NEW JOIN ROUND ON ROUND_NEW.START = ROUND.START AND ROUND_NEW.LEAGUE_ID = ROUND.LEAGUE_ID) ROUND_NEW ON MATCHES.ROUND_ID = ROUND_NEW.ROUND_ID GROUP BY PLAYER_ONE_ID,PLAYER_TWO_ID,ROUND_NEW.ROUND_ID,DIVISION_ID;
//select * from MATCHES LEFT JOIN (SELECT ROUND_NEW.ROUND_ID,ROUND.LEAGUE_ID FROM ROUND_NEW JOIN ROUND ON ROUND_NEW.START = ROUND.START AND ROUND_NEW.LEAGUE_ID = ROUND.LEAGUE_ID) ROUND_NEW ON MATCHES.ROUND_ID = ROUND_NEW.ROUND_ID ORDER BY PLAYER_ONE_ID,PLAYER_TWO_ID,ROUND_NEW.ROUND_ID,DIVISION_ID;
//select * from MATCHES ORDER BY PLAYER_ONE_ID,PLAYER_TWO_ID,ROUND_ID,DIVISION_ID;

//select * from MATCHES LEFT JOIN (SELECT ROUND.ROUND_ID as ROUND_ID, ROUND_NEW.ROUND_ID as N_ROUND_ID, ROUND.START as START, ROUND_NEW.START as N_START, ROUND.END as END, ROUND_NEW.END as N_END, ROUND.LEAGUE_ID as LEAGUE_ID, ROUND_NEW.LEAGUE_ID as N_LEAGUE_ID FROM ROUND_NEW JOIN ROUND ON ROUND_NEW.START = ROUND.START AND ROUND_NEW.LEAGUE_ID = ROUND.LEAGUE_ID) ROUND_NEW ON MATCHES.ROUND_ID = ROUND_NEW.N_ROUND_ID ORDER BY PLAYER_ONE_ID,PLAYER_TWO_ID,ROUND_NEW.N_ROUND_ID,DIVISION_ID;

    public static function create_round_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::league_id_column . " INT NOT NULL, " .
            self::start_column . " DATETIME NOT NULL, " .
            self::end_column . " DATETIME NOT NULL, " .
            "CONSTRAINT foreign_key_" . self::league_id_column . " FOREIGN KEY (" . self::league_id_column . ") REFERENCES " . LeagueDAO::table_name . "(" . LeagueDAO::id_column . ") ON UPDATE CASCADE ON DELETE RESTRICT, " .
            "CONSTRAINT unique_" . self::league_id_column . "_" . self::start_column . " UNIQUE (" . self::league_id_column . ", " . self::start_column . ") " .

            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query = "SELECT DISTINCT " . self::table_name . ".* FROM " . self::table_name . " " .
            "JOIN " . LeagueDAO::table_name . " USING (" . self::league_id_column . ") " .
            "JOIN " . ClubDAO::table_name . " USING (" . LeagueDAO::club_id_column . ") " .
            "ORDER BY " .
            ClubDAO::table_name . "." . ClubDAO::name_column . ", " .
            LeagueDAO::table_name . "." . LeagueDAO::name_column . ", " .
            self::start_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of rounds ');
    }

    public static function get_all_by_user_id($user_id)
    {
        $query =
            "SELECT DISTINCT " . RoundDAO::table_name . ".* " .
                " FROM " . RoundDAO::table_name .
                "   INNER JOIN " . PlayerDAO::table_name .
                " ON " . RoundDAO::table_name . "." . RoundDAO::league_id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::league_id_column .
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

    public static function create($league_id, $start, $end)
    {
        $query = "INSERT INTO " . self::table_name . "(" .
            self::league_id_column . "," .
            self::start_column . "," .
            self::end_column .
            ") VALUES (" .
            ":" . self::league_id_column . "," .
            ":" . self::start_column . "," .
            ":" . self::end_column .
            ")";
        $parameters = array(
            ':' . self::league_id_column => self::sanitize_value($league_id),
            ':' . self::start_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($start))),
            ':' . self::end_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($end))),
        );
        self::insert_update_delete_create($query, $parameters, 'save round ');
    }

    public static function update($id, $league_id, $start, $end)
    {
        $query = "UPDATE " . self::table_name . " SET " .
            self::league_id_column . " = :" . self::league_id_column . ", " .
            self::start_column . " = :" . self::start_column . ", " .
            self::end_column . " = :" . self::end_column .
            " WHERE " .
            self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => self::sanitize_value($id),
            ':' . self::league_id_column => self::sanitize_value($league_id),
            ':' . self::start_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($start))),
            ':' . self::end_column => date('Y-m-d H:i:s', strtotime(self::sanitize_value($end))),
        );
        self::insert_update_delete_create($query, $parameters, 'update league ');
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
            $round_row[self::league_id_column],
            strtotime($round_row[self::start_column]),
            strtotime($round_row[self::end_column])
        );
    }
}

?>