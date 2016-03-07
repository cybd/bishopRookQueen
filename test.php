<?php

$diagValidate = new Validator();
$diagValidate->add('diag');

$straightValidate = new Validator();
$straightValidate->add('straight');

$diagAndStraightValidate = new Validator();
$diagAndStraightValidate->add('diag');
$diagAndStraightValidate->add('straight');

class Validator {
    private $v = [];
    public function add($name) {
        switch ($name) {
            case 'diag':
                $this->v[] = new DiagonalValidate()
                break;
            case 'straight':
                $this->v[] = new StraightValidate();
                break;
            default:
                throw new Exception("Error Processing Request");
        }
    }
}

interface MovementValidate {
    public function check($a, $b);
}

class DiagonalValidate implements MovementValidate {
    /* @return bool */
    public function check($a, $b) {
        return
            (abs(ord($a[0]) - ord($b[0])) == abs($a[1] - $b[1]));
    }
}

class StraightValidate implements MovementValidate {
    /* @return bool */
    public function check($a, $b) {
        return
            ($a[0] == $b[0]) ||
                ($a[1] == $b[1]);
    }
}



interface Movable {
    public function move($a, $b);
}

abstract class ChessFigure implements Movable {
    private $color;
    private $position;
    private $validator;

    public function __construct(MovementValidate $validator) {
        $this->validator = $validator;
    }

    /* @return bool */
    public function move($a, $b) {
        return $this->validator->check($a, $b);
    }
}

class Bishop extends ChessFigure {

}

class Rook extends ChessFigure {

}

class Queen extends ChessFigure {

}

// test code
$bishop = new Bishop(
    new DiagonalValidate()
);
$rook = new Rook(
    new StraightValidate()
);
$queen = new Queen(
    new DiagonalAndStraightValidate()
);

// E2 - C4

// 67 - 69 = -2
// 2 - 4 = -2

assert($bishop->move('E2', 'E4') === false); //
assert($bishop->move('E2', 'C4') === true);
assert($rook->move('E2', 'E4') === true);
assert($rook->move('E2', 'C4') === false);
assert($queen->move('E2', 'E4') === true);
assert($queen->move('E2', 'C4') === true);
