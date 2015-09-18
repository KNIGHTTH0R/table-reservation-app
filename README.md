This Web-App allow users to make a table reservations in a restaurant.

**Requirements** (what I use to test the app)
  * Apache 2.0
  * PHP 5.5.9-1
  * SQLite 3.8.2
  * Postfix

**Features:**
  - Store the reservations in a Database
  - Send reservations made via Email to the staff
  - Control-Panel: The staff can see, make, change or remove reservations

**Files:**
  - `index.html` contains the form and some JavaScript to validate the form
  - `process_reservation.php` contais the code needed to store the data into a Database and also to send it via Email to the staff.
  - `cp.php` is the control-panel

**TODO:**
 - check the [issues](https://github.com/brahiansoto/table-reservation-app/issues)
