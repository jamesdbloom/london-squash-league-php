<?php
require_once('../../load.php');
load::load_file('database', 'database.php');
load::load_file('domain/club', 'club.php');
class ClubDAO extends DAO implements Mapper
{
    const table_name = 'CLUB';
    const id_column = 'CLUB_ID';
    const name_column = 'NAME';
    const address_column = 'ADDRESS';

    public static function create_club_schema()
    {
        $query = "DROP TABLE IF EXISTS " . self::table_name;
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'remove table ');

        $query = "CREATE TABLE " . self::table_name . " (" .
            self::id_column . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
            self::name_column . " VARCHAR(25), " .
            self::address_column . " VARCHAR(125), " .
            "CONSTRAINT unique_" . self::name_column . " UNIQUE (" . self::name_column . ") " .
            ")";
        $parameters = array();
        self::insert_update_delete_create($query, $parameters, 'create table ');
    }

    public static function get_all()
    {
        $query = "SELECT * FROM " . self::table_name . " ORDER BY " . self::name_column;
        $parameters = array();
        return self::load_all_objects($query, $parameters, new self(), 'load list of clubs ');
    }

    public static function get_all_by_user_id($user_id)
    {
        $query =
            "SELECT DISTINCT " . ClubDAO::table_name . ".* " .
                " FROM " . ClubDAO::table_name .
                " INNER JOIN " . LeagueDAO::table_name . " ON " . ClubDAO::table_name   . "." . ClubDAO::id_column   . " = " . LeagueDAO::table_name . "." . LeagueDAO::club_id_column   .
                " INNER JOIN " . PlayerDAO::table_name . " ON " . LeagueDAO::table_name . "." . LeagueDAO::id_column . " = " . PlayerDAO::table_name . "." . PlayerDAO::league_id_column .
                " WHERE " . PlayerDAO::table_name . "." . PlayerDAO::user_id_column . " = :"  . PlayerDAO::user_id_column .
                " AND "   . PlayerDAO::table_name . "." . PlayerDAO::status_column  . " <> '" . Player::inactive . "' "   ;
        $parameters = array(
            ':' . PlayerDAO::user_id_column => self::sanitize_value($user_id),
        );
        return self::load_all_objects($query, $parameters, new self(), 'load list of clubs by user_id ');
    }

    public static function get_by_id($id)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        return self::load_object($query, $parameters, new self(), 'load club by id ');
    }

    public static function get_by_name($name)
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE " . self::name_column . " = :" . self::name_column;
        $parameters = array(
            ':' . self::name_column => self::sanitize_value($name),
        );
        return self::load_object($query, $parameters, new self(), 'load club by name ');
    }

    public static function create($name, $address)
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
        self::insert_update_delete_create($query, $parameters, 'save club ');
        return self::get_by_name($name);
    }

    public static function update($id, $name, $address)
    {
        $query = "UPDATE " . self::table_name . " SET " .
            self::name_column . " = :" . self::name_column . ", " .
            self::address_column . " = :" . self::address_column .
            " WHERE " .
            self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => self::sanitize_value($id),
            ':' . self::name_column => self::sanitize_value($name),
            ':' . self::address_column => self::sanitize_value($address),
        );
        self::insert_update_delete_create($query, $parameters, 'update club ');
    }

    public static function delete_by_id($id)
    {
        $query = "DELETE FROM " . self::table_name . " WHERE " . self::id_column . " = :" . self::id_column;
        $parameters = array(
            ':' . self::id_column => $id,
        );
        self::insert_update_delete_create($query, $parameters, 'delete club by id ');
    }

    public function map(array $club_row)
    {
        return new Club(
            $club_row[self::id_column],
            $club_row[self::name_column],
            $club_row[self::address_column]
        );
    }
}

?>