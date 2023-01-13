<?php

class Roller{
    public static function Roll($die, $bonus= 0){
        return rand(1,$die) + $bonus;
    }
}