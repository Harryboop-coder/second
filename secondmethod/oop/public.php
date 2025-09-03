<?php
class Circle {
    public $radius;
    public $pi = 3.142;  

    public function arcLength($angle) {
        return ($angle / 360) * (2 * $this->pi * $this->radius);
    }

    
    public function chordLength($angle) {

        $radians = deg2rad($angle / 2);
        return 2 * $this->radius * sin($radians);
    }
}

$circle = new Circle();

$circle->radius = 7;

$arc = $circle->arcLength(70);

$chord = $circle->chordLength(70);

echo "Minor Arc PQ = " . round($arc, 1) . " cm<br>";
?>