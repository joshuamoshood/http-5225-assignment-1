<?php
require_once __DIR__ . "/database/DbConnection.php";

$db = new DbConnection(
    host: "host.docker.internal",
    username: "root",
    password: "root",
    port: 3306,
    dbName: "php-assign-1"
);
    $db->query("SELECT * from `player_info` pi LEFT JOIN player_stats ps on ps.player_id = pi.id");
    $playersInfo = $db->resultSet();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Player Data</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Football Player Information</h1>
        <table id="player-info">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Player Name</th>
                    <th>Age</th>
                    <th>Country</th>
                    <th>Club</th>
                    <!-- <th>Profile Picture</th> -->
                    <th>Appearances</th>
                    <th>Goals</th>
                    <th>Assists</th>
                    <th>Yellow Cards</th>
                    <th>Red Cards</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sn = 1;
                    foreach ($playersInfo as $player) {
                        echo <<<EOD
                            <tr>
                                <td>$sn</td>
                                <td>$player->player_name</td>
                                <td>$player->age</td>
                                <td>$player->country</td>
                                <td>$player->club</td>
                                <td>$player->appearances</td>
                                <td>$player->goals</td>
                                <td>$player->assists</td>
                                <td>$player->yellow_cards</td>
                                <td>$player->red_cards</td>
                            </tr>
                        EOD;
                        $sn++;
                    }

                    if(empty($playersInfo)){
                        echo <<<EOD
                            <tr>
                                <td>No player data<td>
                            </tr>
                        EOD;
                    }
                ?>

            </tbody>
        </table>
    </div>
</body>
</html>
