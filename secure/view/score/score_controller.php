<?php
require_once('../../load.php');
load::load_file('domain/match', 'matchDAO.php');

MatchDAO::update_score_by_id(
    Parameters::read_post_input('match_id'),
    Parameters::read_post_input('score')
);

if ($GLOBALS['errors']->has_errors()) {
    page::basic_page('Error', "<a href='/secure'>Home</a>");
} else {
    Headers::set_redirect_header(Link::View_League);
}
?>