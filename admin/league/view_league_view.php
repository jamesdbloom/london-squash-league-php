<!DOCTYPE>
<html>

<head>
    <title>View League</title>
</head>

<body>
<table border="1">
    <tr>
        <td align="center">View League</td>
    </tr>
    <tr>
        <td>
            <table>
                <form method="post" action="view_league_controller.php">
                    <tr>
                        <td>Id</td>
                        <td><input name="id" type="number" size="12" min="0">
                        </td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><input name="name" type="number" size="12" min="0">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><input type="submit" name="submit" value="Sent"></td>
                    </tr>
            </table>
        </td>
    </tr>
</table>
<?php
include '../layout/footer/footer.php';
?>
</body>
</html>