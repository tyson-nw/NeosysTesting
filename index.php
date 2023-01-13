<?php
include "Character.php";
include "Monster.php";
include "Roller.php";
include "Console.php";

if(empty($_GET['character'])){
    $_GET['character'] = "";
}
if (empty($_GET['monster'])){
    $_GET['monster'] = "";
}

echo "<div><form><label for='character'>Character</label><select name='character'>";
echo "<option value=''></option>";
foreach ( glob("*.character") as $file ) {
    echo "<option value='$file'";
    if($file == $_GET['character']){
        echo " selected";
    }
    echo ">$file</option>"; 
}
echo "</select>";
echo "<label for='monster'>Monster</label><select name='monster'>";
echo "<option value=''></option>";
foreach ( glob("*.monster") as $file ) {
    echo "<option value='$file'";
    if($file == $_GET['monster']){
        echo " selected";
    }
    echo ">$file</option>"; 
}
echo "<input type='submit' value='Roll'/>";
echo "</form></div>";

if(empty($_GET['character']) || empty($_GET['monster'])){
    exit();
}

$_GET['rounds'] = 1000;
//read character file
$character = new Character(json_decode(file_get_contents($_GET['character']), true));
//read monster file
$monster = new Monster(json_decode(file_get_contents($_GET['monster']), true));

$current = NULL;
$wincount = array();
//for $n rounds

$character_wins = 0;
$character_wincount = [];
$monster_wins = 0;
$monster_wincount = [];

for($n=0; $n < $_GET['rounds']; $n++){
    //roll for initiative   
    if ($character->initiative() > $monster->react){
        $current = $character;
    }else{
        $current = $monster;
    }

    $rounds = 0;
    while( $character->current_hp > 0 && $monster->current_hp > 0){
       
        if(is_a($current, 'Character')){
            //echo "<h3>Character Attacks</h3>";
            // roll character attack vs monster Deflect and echo result
            $result = $character->attack($monster);
            //Console::CharacterAttack($result);
            //set next combatant
            $current = $monster;
        }else{
            //echo "<h3>Character Attacks</h3>";
            //roll character Deflect vs monster attack
            $result = $character->defend($monster);
            //Console::MonsterAttack($result);
            //set next combatant
            $current = $character;
        }
        $rounds++;
        //Console::Status($character, $monster);

    }

    //echo winner
    if($character->current_hp > 0){
        //echo "<p>$character->name Wins after $rounds rounds</p>"; 
        $character_wins ++;
        if(isset($character_wincount[$rounds])){
            $character_wincount[$rounds]++;
        }else{
            $character_wincount[$rounds] = 1;
        }
    }else{
        //echo "<p>$monster->name Wins after $rounds rounds</p>"; 
        $monster_wins ++;
        if(isset($monster_wincount[$rounds])){
            $monster_wincount[$rounds]++;
        }else{
            $monster_wincount[$rounds] = 1;
        }
    }
    $character->reset();
    $monster->reset();
    //tally winner
    
}

ksort($character_wincount);
ksort($monster_wincount);

echo "<h3>". $character->name. " wins $character_wins vs. ".$monster->name." wins $monster_wins</h3>";

echo "<table>\n";
echo "  <tr>\n";
echo "      <th>".$character->name. " wins $character_wins.</th>\n";
echo "      <th>".$monster->name. " wins $monster_wins.</th>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "      <td>\n";
echo "          <ul>";
foreach($character_wincount as $rounds=>$count){
   echo "           <li>$rounds rounds - $count times.</li>\n";
}
echo "          </ul>\n";
echo "      </td>\n";
echo "      <td>\n";
echo "          <ul>";
foreach($monster_wincount as $rounds=>$count){
   echo "           <li>$rounds rounds - $count times.</li>\n";
}
echo "          </ul>\n";
echo "         </td>\n";
echo "      </tr>\n";
echo "  </tr>\n";
echo "</table>\n";