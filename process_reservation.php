<?php
    if(isset($_POST['name'])){
        // create databases and open connections
        try {
            $db = new PDO('sqlite:reservations.sqlite3');

            // $db->exec('DROP TABLE IF EXISTS reservation');
            $db->exec("CREATE TABLE IF NOT EXISTS reservation (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        guest_name VARCHAR(100),
                        guest_email VARCHAR(100),
                        guest_tel VARCHAR(100),
                        reservation_date VARCHAR(100),
                        reservation_time VARCHAR(100),
                        guests INTEGER,
                        table_location VARCHAR(20))"
            );


            $query = 'INSERT
                      INTO reservation (guest_name, guest_email, guest_tel, reservation_date, reservation_time, guests, table_location)
                      VALUES (:guest_name, :guest_email, :guest_tel, :reservation_date, :reservation_time, :guests, :table_location)';

            $stmt = $db->prepare($query);

            $stmt->bindParam(':guest_name', $_POST['name']);
            $stmt->bindParam(':guest_email', $_POST['email']);
            $stmt->bindParam(':guest_tel', $_POST['tel']);
            $stmt->bindParam(':reservation_date', $_POST['reservationDate']);
            $stmt->bindParam(':reservation_time', $_POST['reservationTime']);
            $stmt->bindParam(':guests', $_POST['guestsNumber'], PDO::PARAM_INT);
            $stmt->bindParam(':table_location', $_POST['tableLocation']);

            $stmt->execute();

            $errorInfo = $stmt->errorInfo();

            if(isset($errorInfo[2])){
                $error = $errorInfo[2];

            }

            $query2 = 'SELECT * FROM reservation';
            $stmt2 = $db->prepare($query2);
            $stmt2->execute();

            $row = $stmt2->fetch();

            echo "row fetch done.";

            if ($row){
               do {
                    echo "<br>";
                    echo "ID: " . $row['id'] . "<br>";
                    echo "NAME: " . $row['guest_name'] . "<br>";
                    echo "EMAIL: " . $row['guest_email'] . "<br>";
                    echo "TEL: " . $row['guest_tel'] . "<br>";
                    echo "DATE: " . $row['reservation_date'] . "<br>";
                    echo "TIME: " . $row['reservation_time'] . "<br>";
                    echo "GUESTS: " . $row['guests'] . "<br>";
                    echo "LOCATION: " . $row['table_location'] . "<br>";
                    echo "...........................................................................<br>";
                } while($row = $stmt2->fetch());
            } else {
                echo "<h1>no results found</h1>";
            }

        } catch(Exception $e) {
            $error = $e->getMessage();

        }

    } else {

        echo "<h1>We ain't got shit!</h1>";
    }
    
?>



