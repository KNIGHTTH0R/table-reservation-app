<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a href="?a=sr">show reservations</a>
<a href="?a=mr">make reservation</a>



    <?php
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
                        echo "<td>" . $row['id'] . "</td>";
                        echo '<td><a href="?a=mr&update=yes&id='.$row['id'].'&date='.$row['reservation_date'].'&time='.$row['reservation_time'].'&guests='.$row['guests'].'&table_location='.$row['table_location'].'&name='.$row['guest_name'].'&tel='.$row['guest_tel'].'&email='.$row['guest_email'].'">edit</a></td>';
                        echo '<td><a href="?a=del&id='.$row['id'].'">delete</a></td>';
                        echo "</tr>";
                    } while ($row = $stmt->fetch());
                } else {
                    echo "<h1>no results found</h1>";
                }

            } catch(Exception $e) {
                $error = $e->getMessage();
                echo $error;
            }
            echo "</table>";

            $db = null;
        }

        function add_reservation(){
                echo '
                    <div id="reservationApp">
                        <form action="process_reservation.php" method="get" name="updateReservation" id="updateReservation">
                            <input type="hidden" name="id" value="'.$_GET['id'].'">
                            <input type="hidden" name="update" value="'.$_GET['update'].'">
                            <ul>
                                <li>
                                    <h3>Table reservation</h3>
                                </li>
                                <li>
                                    <label for="guestName">Name:</label>
                                    <input type="text" required name="name" value="'.$_GET['name'].'" id="guestName" placeholder="Brahian E. Soto M." autocomplete="name" pattern=".+"><br>
                                    <span id="name_hint" class="hint"></span>
                                </li>
                                <li>
                                    <label for="guestEmail">Email:</label>
                                    <input type="email" required name="email" value="'.$_GET['email'].'" id="guestEmail" value="" placeholder="username@server.com" autocomplete="email"><br>
                                    <span id="error_hint" class="hint"></span>
                                </li>
                                <li>
                                    <label for="guestTel">Telephone:</label>
                                    <input type="tel" required name="tel" value="'.$_GET['tel'].'" id="guestTel" autocomplete="tel" placeholder="+49 123456789">
                                </li>
                                <li>
                                    <label for="reservationDate">Date:</label>
                                    <input type="date" min="2015-11-01" required name="reservationDate" value="'.$_GET['date'].'" id="reservationDate" placeholder="TT.MM.JJJJ">
                                </li>
                                <li>
                                    <label for="reservationTime">Time:</label>
                                    <input type="time" min="12:00" max="23:00" required name="reservationTime" value="'.$_GET['time'].'" id="reservationTime" placeholder="HH:MM">
                                </li>
                                <li>
                                    <label for="guestsNumber">Guests:</label>
                                    <input type="number" name ="guestsNumber" value="'.$_GET['guests'].'" id="guestsNumber" min="1" value="4" required>
                                </li>
                                <li>
                                    <input type="radio" name="tableLocation" id="tableInside" value="inside" checked><label for="tableInside">Inside</label>
                                    <input type="radio" name="tableLocation" disabled id="tableOutside" value="outside"><label for="tableOutside">Outside</label>
                                </li>
                                <li>
                                    <input type="submit" value="Save">
                                </li>
                            </ul>
                        </form>
                    </div>
                ';
        }

        function delete_reservation($id){
            try {
                $db = new PDO('sqlite:reservations.sqlite3');

                $query = 'DELETE FROM reservation WHERE id = :id';

                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

                $stmt->execute();




            } catch(Exception $e) {
                $error = $e->getMessage();
                echo $error;
            }

            $db = null;

        }

        if(isset($_GET['a'])){
            $action = $_GET['a'];

            if($action == "sr"){
                echo '<h1>Reservations</h1>';
                show_reservations();

            } elseif($action == 'mr'){
                echo '<h1>Reservation form</h1>';
                add_reservation();

            } elseif($action == 'del'){
                echo '<h1>removing reservation...</h1>';
                delete_reservation();

            } else {
                echo "<h1>nice try</h1>";
            }
        }






        ?>

</body>
</html>