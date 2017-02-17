<?php
include 'Verb.php';
$sql="SELECT * From board INNER JOIN modell ON board.modell_ID=modell.ID INNER JOIN ort ON board.ort_ID=ort.ID ORDER BY board.ID ASC";
$sql_Erg=$mysqli_query($Verb, $sql);
?>
#<!DOCTYPE html>
<html>
  <head>
    <title>Verwaltungsoberfläche für Pi- und Arduinoboards</title>
  </head>
  <body>
    <h1>Übersicht aller aktuellen Boards</h1>
    <table border="1px solid black">
      <tr><td>Boardtyp</td><td>Name</td><td>Ort</td><td>Verwendung</td><td>Karte</td><td>Gadgets</td></tr>
      <?php
      while($arr=mysqli_fetch_array($sql_Erg)){
        echo "<tr>";
        echo "<td>".$arr["modell.Bezeichnung"]."</td>";
        echo "<td>".$arr["board.Name"]."</td>";
        echo "<td>".$arr["ort.Name"]."</td>";
        echo "<td>".$arr["board.Verwendung"]."</td>";
        echo "<td>".$arr["board.Karte"]."</td>";
        echo "<td>".$arr["board.Gadgets"]."</td>";
        eche "</tr>";
      }
      ?>
    </table>
  </body>
</html>
