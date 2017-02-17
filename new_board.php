<?php
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
if ($Name=="") {$OK=false;echo "<span class='Error'>Bitte den Namen ausfüllen</span>";}
if ($Verwendung) {$OK=false;echo "<span class='Error'>Bitte die aktuelle Verwendung eintragen</span>";}
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
#<!DOCTYPE html>
<html>
  <head>
    <title>PiDuinos - New Board</title>
  </head>
  <body>
    <form action="new_board.php" method="post">
      <select id="ModellID" name="ModellID">
          <?php
          $i=0;
          foreach ($modell_id as $value) {
              echo '<option value="'.$value.'"';
              if ($ModellID===$value) {echo " selected";}
              echo '>'.$modell_name[$i].'</option>';
              $i++;
          }
          ?>
      </select>

      <input type="text" name="Name" placeholder="Name des Boards" <?php if(isset($Name)){echo 'value="'.$Name.'"';} ?>> Name

      <select id="OrtID" name="OrtID">
          <?php
          $i=0;
          foreach ($ort_id as $value) {
              echo '<option value="'.$value.'"';
              if ($OrtID===$value) {echo " selected";}
              echo '>'.$ort_name[$i].'</option>';
              $i++;
          }
          ?>
        </select>
        <input type="text" name="Beschreibung" placeholder="Beschreibung des boards" value="<?php if(isset($Beschreibung)){echo 'value="'.$Beschreibung.'"';} ?>> Beschreibung
        <input type="text" name="Verwendung" placeholder="Aktuelle Verwendung" value="<?php if(isset($Verwendung)){echo 'value="'.$Verwendung.'"';} ?>> Verwendung
        <input type="number" name="Karte" placeholder="Kartengröße" value="<?php if(isset($Karte)){echo 'value="'.$Karte.'"';} ?>> Kartengröße in GB
        <input type="text" name="Gadgets" placeholder="Verwendete Gadgets" <?php if(isset($Gadgets)){echo 'value="'.$Gadgets.'"';} ?>> Gadgets
    </form>
  </body>
</html>
