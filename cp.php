<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a href="?a=sr">show reservations</a>
<!-- <a href="?a=mr">make reservation</a> -->
<a href="index.html">make reservation</a>



    <?php
        if(isset($_GET['a'])){
            $action = $_GET['a'];

            if($action == "sr"){
                echo '<h1>Reservations</h1>';
                show_reservations();

            } elseif($action == 'mr'){
                echo '<h1>Reservation form</h1>';

            } else {
                echo "<h1>nice try</h1>";
            }
        }

        function show_reservations(){
            echo "<table>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                    <th>Location</th>
                    <th>Name</th>
                    <th>Mobil</th>
                    <th>Email</th>
                </tr>";
                try {
                    $db = new PDO('sqlite:reservations.sqlite3');

                    $query = 'SELECT * FROM reservation';

                    $stmt = $db->prepare($query);
                    $stmt->execute();

                    $row = $stmt->fetch();

                    if ($row) {
                        do {
                            echo "<tr>";
                            echo "<td>" . $row['reservation_date'] . "</td>";
                            echo "<td>" . $row['reservation_time'] . "</td>";
                            echo "<td>" . $row['guests'] . "</td>";
                            echo "<td>" . $row['table_location'] . "</td>";
                            echo "<td>" . $row['guest_name'] . "</td>";
                            echo "<td>" . $row['guest_tel'] . "</td>";
                            echo "<td>" . $row['guest_email'] . "</td>";
                            echo '<td><button>edit</button></td>';
                            echo '<td><button>delete</button></td>';
                            echo "</tr>";
                        } while ($row = $stmt->fetch());
                    } else {
                        echo "<h1>no results found</h1>";
                    }

                } catch(Exception $e) {
                    $error = $e->getMessage();
                    echo $e;
                }
                echo "</table>";
            }
        ?>

</body>
</html>