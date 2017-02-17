<?php
include 'Verb.php';
//Eingabenprüfung
if(isset($_POST["Name"])){
$Name=$_POST["Name"];
$Modell_ID=$_POST["ModellID"];
$OrtID=$_POST["OrtID"];
$Beschreibung=$_POST["Beschreibung"];
$Verwendung=$_POST["Verwendung"];
$Karte=$_POST["Karte"];
$Gadgets=$_POST["Gadgets"];
$OK=true;

if(isset($_POST["OrtNeu"])){
  $OrtNeu=$_POST["OrtNeu"];
  //EINFÜGEN DES neuen Ortes, abrufen der ID und eintragen des neuen Boards
  $sql="INSERT INTO `ort` (`ID`, `Name`) VALUES (NULL, '".$OrtNeu."')";
  if(!$sql_Erg=mysqli_query($Verb, $sql)){die("Fehler beim Eintragen des neuen Ortes: ").mysqli_error($Verb);}
  $sql="SELECT ID FROM ort WHERE Name='".$OrtNeu."'";
  $OrtID=mysqli_fetch_array(mysqli_query($Verb, $sql))["ID"];
}
if ($Name=="") {$OK=false;echo "<span class='Error'>Bitte den Namen ausfüllen</span>";}
if ($Verwendung=="") {$OK=false;echo "<span class='Error'>Bitte die aktuelle Verwendung eintragen</span>";}
if ($Karte<0) {$OK=false;echo "<span class='Error'>Bitte keine negativen Kartengrößen...</span>";}
if (is_numeric($Gadgets)) {$OK=false;echo "<span class='Error'>Bitte keine numerischen Gadgets :O</span>";}
if($OK){
  //Eintragen der geprüften Eingaben. Bisher kein Schutz gegen Injections oder Cross-Site-Scripting
  $sql="INSERT INTO `board` (`ID`, `modell_ID`, `Name`, `ort_ID`, `Beschreibung`, `Verwendung`, `Karte`, `Gadgets`) VALUES (NULL, '".$Modell_ID."', '".$Name."', '".$OrtID."', '".$Beschreibung."', '".$Verwendung."', '".$Karte."', '')";
  if(!mysqli_query($Verb, $sql)){die("Fehler beim Eintragen: ".mysqli_error($Verb));}
  else{echo "<span class='OK'>Neues Board eingetragen</span>";}
}

}
////Seitengedöns
///Abrufen von Informationen aus der DB
//Modelle
$sql="Select ID, Bezeichnung FROM modell ORDER BY Bezeichnung ASC";
$modell_name=array();
$modell_id=array();
$sqlErg=  mysqli_query($Verb, $sql);
while ($row = mysqli_fetch_array($sqlErg)) {
    array_push($modell_id, $row["ID"]);
    array_push($modell_name, $row["Bezeichnung"]);
}
mysqli_free_result($sqlErg);

//Orte
$sql="Select ID, Name FROM ort ORDER BY Name ASC";
$ort_name=array();
$ort_id=array();
$sqlErg=  mysqli_query($Verb, $sql);
while ($row = mysqli_fetch_array($sqlErg)) {
    array_push($ort_id, $row["ID"]);
    array_push($ort_name, $row["Name"]);
}
mysqli_free_result($sqlErg);
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="style.css" rel="stylesheet">
    <meta charset="utf-8">
    <title>PiDuinos - New Board</title>
  </head>
  <body>
    <h1> Eintragen eines neuen Pi-/Arduino-Boards</h1>
    <form action="new_board.php" method="post">
      <select id="ModellID" name="ModellID">
          <?php
          $i=0;
          foreach ($modell_id as $value) {
              echo '<option value="'.$value.'"';
              if (isset($ModellID) && $ModellID===$value) {echo " selected";}
              echo '>'.$modell_name[$i].'</option>';
              $i++;
          }
          ?>
      </select><br/>

      <input type="text" name="Name" placeholder="Name des Boards" <?php if(isset($Name)){echo 'value="'.$Name.'"';} ?>> Name<br/>

      <select id="OrtID" name="OrtID">
          <?php
          $i=0;
          foreach ($ort_id as $value) {
              echo '<option value="'.$value.'"';
              if (isset($OrtID) && $OrtID===$value) {echo " selected";}
              echo '>'.$ort_name[$i].'</option>';
              $i++;
          }
          ?>
        </select><input type="text name="OrtNeu" placeholder="Neuen Ort speichern"><br/>
        <input type="text" name="Beschreibung" placeholder="Beschreibung des boards"<?php if(isset($Beschreibung)){echo 'value="'.$Beschreibung.'"';} ?>> Beschreibung<br/>
        <input type="text" name="Verwendung" placeholder="Aktuelle Verwendung" <?php if(isset($Verwendung)){echo 'value="'.$Verwendung.'"';} ?>> Verwendung<br/>
        <input type="number" name="Karte" placeholder="Kartengröße" <?php if(isset($Karte)){echo 'value="'.$Karte.'"';} ?>> Kartengröße in GB<br/>
        <input type="text" name="Gadgets" placeholder="Verwendete Gadgets" <?php if(isset($Gadgets)){echo 'value="'.$Gadgets.'"';} ?>> Gadgets<br/>
        <input type="submit" value="Bestätigen"><br/>
    </form>
  </body>
</html>
