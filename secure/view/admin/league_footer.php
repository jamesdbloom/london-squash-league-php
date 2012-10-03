<?php
class Footer
{
    static function outputFooter(Error $errors)
    {
        if ($errors->has_errors()) {
            ?>
        <html>
        <head>
            <title>Recreate Table</title>
        </head>
        <body>
            <?php Error::print_errors($errors); ?>
        <p><a href="/secure">Home</a></p>
        </body>
        </html>
        <?php
        } else {
            Headers::set_redirect_header('/secure/view/league_admin/list_view.php');
        }
    }
}

?>