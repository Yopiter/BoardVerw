<?php
include 'Verb.php';
$sql="SELECT modell.Bezeichnung, board.Name AS BoardName, ort.Name AS OrtsName, board.Verwendung, board.Karte, board.Gadgets From board INNER JOIN modell ON board.modell_ID=modell.ID INNER JOIN ort ON board.ort_ID=ort.ID ORDER BY board.ID ASC";
$sql_Erg=mysqli_query($Verb, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="style.css" rel="stylesheet">
    <meta charset="utf-8">
    <title>Verwaltungsoberfläche für Pi- und Arduinoboards</title>
  </head>
  <body>
    <h1>Übersicht aller aktuellen Boards</h1>
    <table border="1px solid black">
      <tr><td>Boardtyp</td><td>Name</td><td>Ort</td><td>Verwendung</td><td>Karte</td><td>Gadgets</td></tr>
      <?php
      while($arr=mysqli_fetch_array($sql_Erg)){
        echo "<tr>";
        echo "<td>".$arr["Bezeichnung"]."</td>";
        echo "<td>".$arr["BoardName"]."</td>";
        echo "<td>".$arr["OrtsName"]."</td>";
        echo "<td>".$arr["Verwendung"]."</td>";
        echo "<td>".$arr["Karte"]."</td>";
        echo "<td>".$arr["Gadgets"]."</td>";
        echo "</tr>";
      }
      ?>
    </table>
  </body>
</html>
