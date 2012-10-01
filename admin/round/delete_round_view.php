<!DOCTYPE>
<html>

<head>
    <title>Delete Round</title>
</head>

<body>
<table border="1">
    <tr>
        <td align="center">Delete Round</td>
    </tr>
    <tr>
        <td>
            <table>
                <form method="post" action="delete_round_controller.php">
                    <tr>
                        <td>Id</td>
                        <td><input name="id" type="number" size="12" required="required" min="0"></td>
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