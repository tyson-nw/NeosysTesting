<?php

class Console{
    static function MonsterAttack($result){
        echo "<p>Monster attacks, ";
        if($result['hit']){
            echo "hits, dealing " . $result['damage'];
        }else{
            echo "misses.";
        }
        echo "</p>";
    }

    static function CharacterAttack($result){
        echo "<p>Character attacks, ";
        if($result['hit']){
            echo "hits, dealing " . $result['damage'];
        }else{
            echo "misses.";
        }
        echo "</p>";
    }

    static function Status($character, $monster){
        echo "<p>Character: ".$character->current_hp."/".$character->hp."</br>";
        echo "Monster: ".$monster->current_hp."/".$monster->hp. "</p>";
    }
}