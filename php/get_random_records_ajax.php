<?php
$host         = "localhost";
$username     = "postgres";
$password     = "root";
$dbname       = "postgis_24_sample";
$result = 0;

/* Create connection */
$conn = pg_connect("host=$host dbname=$dbname user=$username password=$password");
/* Check connection */
if (!$conn) {
     die("Connection to database failed: " . $conn->connect_error);
}
$sql = "select nom_com AS commune from \"fr-commune\" ORDER BY RANDOM() LIMIT 4;";
$result = pg_query($conn, $sql);
$resultArray = pg_fetch_all($result);
echo json_encode($resultArray);
?>
