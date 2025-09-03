<?php
class Circle {
    public $radius;
    public $pi = 3.142;

    public function arcLength($angle) {
        return ($angle / 360) * (2 * $this->pi * $this->radius);
    }
}

$circle = new Circle();

$circle->radius = 7;

$arc = $circle->arcLength(70);

echo "Minor Arc PQ = " . round($arc, 1) . " cm";
?>