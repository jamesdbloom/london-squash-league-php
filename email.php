<?php
$message = "
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' type='text/css' href='https://www.london-squash-league.com/view/global_2012_08_31_22_10.css'>
    <title>London Squash League</title>
</head>
<body>
<div>
<div id='container'>
    <div id='header' style='font-size: 2.5em; line-height: 1.25em'>London Squash League - Sign Up Now</div>
    <div id='main_content'>
        <div class='section'>
            <p class='message' style='font-size: 1.65em; line-height: 1.5em'>I have now launched the squash league website please use the link below to <a title='1. Register' href='https://www.london-squash-league.com/register'>Register</a>.<br/><br/>When you register you will be asked to select your league and initial division.  Once the rounds get going on 14th November your division will be automatically updated depending on how many matches you win in each round.<br/><br/>Once you have registered you will not see any games until two days before the first round starts (i.e. 12th November) </p>
            <ol class='link_list' style='font-size: 2em; line-height: 1.5em'>
                <li><a title='1. Register' href='https://www.london-squash-league.com/register'>1. Register</a></li>
                <li><a title='2. Join A League' href='https://www.london-squash-league.com/account#divisions'>2. Join A League</a></li>
            </ol>
            <h2 class='table_title'>Division / Rounds</h2>
            <table class='action_table' style='font-size: 1.35em; line-height: 1.25em'>
                <tbody>
                <tr>
                    <th class='division'>Division</th>
                    <th class='date'>Start</th>
                    <th class='date'>End</th>
                    <th class='last'>&nbsp;</th>
                </tr>
                <tr>
                    <td class='division'>Hammersmith GLL &#8250; Evening &#8250; 1</td>
                    <td class='date'>14-Nov-2012</td>
                    <td class='date'>19-Dec-2012</td>
                    <td class='last'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='division'>Hammersmith GLL &#8250; Evening &#8250; 2</td>
                    <td class='date'>14-Nov-2012</td>
                    <td class='date'>19-Dec-2012</td>
                    <td class='last'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='division'>Hammersmith GLL &#8250; Evening &#8250; 3</td>
                    <td class='date'>14-Nov-2012</td>
                    <td class='date'>19-Dec-2012</td>
                    <td class='last'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='division'>Hammersmith GLL &#8250; Evening &#8250; 4</td>
                    <td class='date'>14-Nov-2012</td>
                    <td class='date'>19-Dec-2012</td>
                    <td class='last'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='division'>Hammersmith GLL &#8250; Lunchtime &#8250; 1</td>
                    <td class='date'>14-Nov-2012</td>
                    <td class='date'>19-Dec-2012</td>
                    <td class='last'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='division'>Hammersmith GLL &#8250; Lunchtime &#8250; 2</td>
                    <td class='date'>14-Nov-2012</td>
                    <td class='date'>19-Dec-2012</td>
                    <td class='last'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='division'>Hammersmith GLL &#8250; Lunchtime &#8250; 3</td>
                    <td class='date'>14-Nov-2012</td>
                    <td class='date'>19-Dec-2012</td>
                    <td class='last'>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <p class='message' style='font-size: 1.65em; line-height: 1.5em'>If the links in this email do not work please copy the following URL into your browser <a href='https://www.london-squash-league.com'>https://www.london-squash-league.com</a></p>
        </div>

    </div>
</div>
<div id='footer' style='font-size: 1.65em; line-height: 1.5em'><p>2012 James D Bloom</p></div>
</div>
</body>
</html>
        ";
// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= "From: info@london-squash-league.com \r\n";
//$to = "Andrea Caldera <andrea.caldera@gmail.com>,  Catherine Little <catherinemlittle@gmail.com>,  Daniel Marks <argylehater@gmail.com>,  Daniel Morley <morley_daniel@yahoo.co.uk>,  David Beguier-Barnett <david@beguier.com>,  James Bloom <jamesdbloom@gmal.com>,  James Trundle <jwtrundle@gmail.com>,  Joe Klimis <joe.klimis@cw.com>,  John Keen <johnkeen@nhs.net>,  Julian Townshend <j.townshend@mmu.ac.uk>,  Marco Cioni <marco.cioni@haymarket.com>,  Patrick O'Neill <pjmon@hotmail.co.uk>,  Paul Taylor <email@paultaylor.me>,  Ray Swanton <swantonray@gmail.com>,  Hotchkiss,  Robert <Robert.Hotchkiss@cw.com>,  Robin Bruce <robin.bruce@gmail.com>,  Sarita Noronha <wroamer@hotmail.com>,  Scott Hands <scotthands@nhs.net>,  Taryn Armitage <tarynarmitage@gmail.com>,  Will Oliver <wo102@hotmail.co.uk>,  Andy Keen <andy@jobs4tennis.com>, James Bloom <jamesdbloom@gmail.com>";
$to = "James Bloom <jamesdbloom@gmail.com>";
// $to = "Tracey Evans <tracey.evans@gll.org>";
mail($to, 'London Squash League - Sign Up Now', $message, $headers)
?>