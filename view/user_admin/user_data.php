<?php
require_once('../../load.php');
load::load_file('view/user_admin', 'user_imports.php');
load::load_file('view/admin', 'abstract_data.php');

class UserData extends AbstractData {
    public $user_list;
    public $session_list;

    public $user_map;

    public function __construct()
    {
        $this->user_list = UserDAO::get_all();
        $this->session_list = SessionDAO::get_all();

        $this->user_map = $this->list_to_map($this->user_list);
    }

    public function print_user_name($user_id) {
        $user = $this->user_map[$user_id];
        $result = "&nbsp;";
        if (!empty($user)) {
            $result = $user->name;
        } else if (!empty($user_id)) {
            $result = $user_id;
        }
        return $result;
    }
}
?>