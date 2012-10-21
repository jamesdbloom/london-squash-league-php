<?php
require_once('../../load.php');
load::load_file('domain/match', 'matchDAO.php');

$score = Parameters::read_post_input('score');
$match = MatchDAO::get_by_id(Parameters::read_post_input('match_id'));

if (empty($match)) {
    $GLOBALS['errors']->add('match_id_invalid', 'No match has been found for match id ' . Parameters::read_post_input('match_id'));
}
if (!preg_match('/^[0-9]{1,2}-[0-9]{1,2}/', $score)) {
    $GLOBALS['errors']->add('score_incorrect_format', 'Please enter a score using the format x-x');
}

if (!$GLOBALS['errors']->has_errors()) {
    MatchDAO::update_score_by_id(
        Parameters::read_post_input('match_id'),
        Parameters::read_post_input('score')
    );
}

if ($GLOBALS['errors']->has_errors()) {
    page::basic_page('Error', "<a href='/secure'>Home</a>");
} else {
    Headers::set_redirect_header(Link::View_League);
}
?>