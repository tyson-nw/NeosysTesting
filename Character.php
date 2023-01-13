<?php

class Character{
    public $name;
    public $react;
    public $deflect;
    public $soak;
    public $hp;
    public $current_hp;
    public $attack_name;
    public $attack_bonus;
    public $attack_damage;

    function __construct($character){
        $this->name = $character['name'];
        $this->react = $character['react'];
        $this->deflect = $character['deflect'];
        $this->soak = $character['soak'];
        $this->hp = $character['hp'];
        $this->current_hp = $this->hp;
        $this->attack_name = $character['attack_name'];
        $this->attack_bonus = $character['attack_bonus'];
        $this->attack_damage = $character['attack_damage'];
    }

    function initiative(){
        return Roller::Roll(12, $this->react);
    }

    function attack($monster){
        $result = array('attack'=>$this->attack_name);
        $result['roll'] = Roller::Roll(12, $this->attack_bonus);
        if($monster->deflect <  $result['roll']){
            $result['hit'] = TRUE;
            $result['damage'] = Roller::Roll($this->attack_damage['die'],$this->attack_damage['bonus']);
            $monster->takeDamage($result['damage']);
        }else{
            $result['hit'] = FALSE;
        }
        return $result;
    }

    function defend($monster){
        $result = array('attack'=>$monster->attack_name);
        $result['roll'] = Roller::Roll(12, $this->deflect);
        if($monster->attack_target > $result['roll']){
            $result['hit'] = TRUE;
            $result['damage'] = $monster->attack_damage;

            if($this->current_hp -= $result['damage'] > 0 ){
                $this->current_hp -= $result['damage'];
            }else{
                $this->current_hp -= 1;
            }

            

        }else{
            $result['hit'] = FALSE;
        }
        return $result;
    }

    function reset(){
        $this->current_hp = $this->hp;
    }
}