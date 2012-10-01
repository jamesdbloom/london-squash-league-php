<!DOCTYPE>
<html>

<head>
    <title>View Club</title>
</head>

<body>
<table border="1">
    <tr>
        <td align="center">View Club</td>
    </tr>
    <tr>
        <td>
            <table>
                <form method="post" action="view_club_controller.php">
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