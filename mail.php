<!DOCTYPE html>

<html>
    <head>
        <title>Progetto Amm 2015</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" media="screen" href="./css/mail.css"/>
    </head>
    <body>
        <?php
        $mbox = imap_open("{mbox.cert.legalmail.it:993/ssl}INBOX", "M2876271", "AaBb1234")
                or die("can't connect: " . imap_last_error());

        $MC = imap_check($mbox);

// Fetch an overview for all messages in INBOX
        $result = imap_fetch_overview($mbox, "1:{$MC->Nmsgs}", 0);
        echo "<table><tr><th>Numero</th><th>Data</th><th>Mittente</th><th>Oggetto</th></tr>";
        foreach ($result as $overview) {
            if (strpos($overview->subject, "ACCETTAZIONE:") === false && strpos($overview->subject, "CONSEGNA:") === false) {
                echo '<tr><td class="numero">' . $overview->msgno . '</td><td class="data">' . $overview->date . '</td><td class="mittente">' . $overview->from . '</td><td class="oggetto">' . $overview->subject . '</td></tr>';
            }
        }
        echo "</table>";
        imap_close($mbox);
        ?>

    </body>
</html>
