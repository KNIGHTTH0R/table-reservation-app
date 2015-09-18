<?php

function send_email($body_of_msj="default body", $subject_of_msj="default msj")
{
// EMAIL

    $to = 'Brahian E. Soto M. <brahiansoto@use.startmail.com>, elias@use.startmail.com';
    $subject = $subject_of_msj;
    $body = $body_of_msj;
    $headers = "From: reservation_system@wissensextraktor.de\r\n";
    $headers .= "Content-Type: text/plain; Charset=utf-8\r\n";
    $headers .= "Cc: brahiansoto@hotmail.com";

    $success = mail($to, $subject, $body, $headers, '-fbrahiansoto@use.startmail.com');
    if ($success) {
        echo "Email sent.\n";
    } else {
        echo "Failed to then the email.";
    }
}

if(isset($_GET['name'])){
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

            $subject = "";
            $body = "";

            if($_GET['update'] == "yes"){
                echo "<h1>updating</h1>";
                $query = 'UPDATE reservation
                            SET `guest_name` = :guest_name,
                                `guest_email` = :guest_email,
                                `guest_tel` = :guest_tel,
                                `reservation_date` = :reservation_date,
                                `reservation_time` = :reservation_time,
                                `guests` = :guests,
                                `table_location` = :table_location
                            WHERE `id` = :id';

                $stmt = $db->prepare($query);

                $stmt->bindParam(':guest_name', $_GET['name']);
                $stmt->bindParam(':guest_email', $_GET['email']);
                $stmt->bindParam(':guest_tel', $_GET['tel']);
                $stmt->bindParam(':reservation_date', $_GET['reservationDate']);
                $stmt->bindParam(':reservation_time', $_GET['reservationTime']);
                $stmt->bindParam(':guests', $_GET['guestsNumber'], PDO::PARAM_INT);
                $stmt->bindParam(':table_location', $_GET['tableLocation']);
                $stmt->bindParam(':id', $_GET['id']);

                // EMAIL-CONTENT

                $body .= '
                CHANGE RESERVATION:
                ---------------------------------------
                DATE: '.$_GET['reservationDate'].'
                TIME: '.$_GET['reservationTime'].'
                GUESTS: '.$_GET['guestsNumber'].'
                LOCATION: '.$_GET['tableLocation'].'
                ---------------------------------------
                MADE BY: '.$_GET['name'].'
                EMAIL: '.$_GET['email'].'
                TEL: '.$_GET['tel'].'';

                $subject .= 'Change reservation';

            } else {
                echo "<h1>inserting</h1>";
                $query = 'INSERT
                          INTO reservation (guest_name, guest_email, guest_tel, reservation_date, reservation_time, guests, table_location)
                          VALUES (:guest_name, :guest_email, :guest_tel, :reservation_date, :reservation_time, :guests, :table_location)';

                $stmt = $db->prepare($query);

                $stmt->bindParam(':guest_name', $_GET['name']);
                $stmt->bindParam(':guest_email', $_GET['email']);
                $stmt->bindParam(':guest_tel', $_GET['tel']);
                $stmt->bindParam(':reservation_date', $_GET['reservationDate']);
                $stmt->bindParam(':reservation_time', $_GET['reservationTime']);
                $stmt->bindParam(':guests', $_GET['guestsNumber'], PDO::PARAM_INT);
                $stmt->bindParam(':table_location', $_GET['tableLocation']);

                // EMAIL-CONTENT

                $body .= '
                NEW RESERVATION:
                ---------------------------------------
                DATE: '.$_GET['reservationDate'].'
                TIME: '.$_GET['reservationTime'].'
                GUESTS: '.$_GET['guestsNumber'].'
                LOCATION: '.$_GET['tableLocation'].'
                ---------------------------------------
                MADE BY: '.$_GET['name'].'
                EMAIL: '.$_GET['email'].'
                TEL: '.$_GET['tel'].'';

                $subject .= 'New reservation';


            }

            $stmt->execute();

            $errorInfo = $stmt->errorInfo();

            if(isset($errorInfo[2])){
                $error = $errorInfo[2];
                echo $error;
            } else {
                echo "Reservations data added to de database.\n";
                send_email($body, $subject);

            }



        } catch(Exception $e) {
            $error = $e->getMessage();

        }

    } else {

        echo "<h1>We ain't got shit!</h1>";
    }
    
?>



