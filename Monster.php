<?php

class Monster{

    public $name;
    public $react;
    public $deflect;
    public $soak;
    public $hp;
    public $current_hp;
    public $attack_name;
    public $attack_target;
    public $attack_damage;

    function __construct($monster){
        $this->name = $monster['name'];
        $this->react = $monster['react'];
        $this->deflect = $monster['deflect'];
        $this->soak = $monster['soak'];
        $this->hp = $monster['hp'];
        $this->current_hp = $this->hp;
        $this->attack_name = $monster['attack_name'];
        $this->attack_target = $monster['attack_target'];
        $this->attack_damage = $monster['attack_damage'];
    }

    function takeDamage($damage){
        if($damage-$this->soak > 0){
            $this->current_hp -= $damage;
        }else{
            $this->current_hp--;
        }
        
    }

    function reset(){
        $this->current_hp = $this->hp;
    }
}