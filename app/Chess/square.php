<?php namespace App\Chess;

/*
 * Contains functions and constants to work with squares
 */

/*
 * A square format that gives every square a number ranging from 0 to 63
 */
define('App\Chess\SQUARE_FORMAT_INT', 0);
/*
 * SAN square format, e.g. 'e4'
 */
define('App\Chess\SQUARE_FORMAT_STRING', 1);
/*
 * A square formar where each sqaure is an array.
 *
 * The array has the form [$fileNumber, $rankNumber].
 * Both file and rank range from 0 to 7.
 * For the file a is 0 and h is 7.
 */
define('App\Chess\SQUARE_FORMAT_ARRAY', 2);

/*
 * The numeric value of a1
 */
define('App\Chess\SQUARE_A1', 0);

/*
 * The numeric value of b1
 */
define('App\Chess\SQUARE_B1', 1);

/*
 * The numeric value of c1
 */
define('App\Chess\SQUARE_C1', 2);

/*
 * The numeric value of d1
 */
define('App\Chess\SQUARE_D1', 3);

/*
 * The numeric value of e1
 */
define('App\Chess\SQUARE_E1', 4);

/*
 * The numeric value of f1
 */
define('App\Chess\SQUARE_F1', 5);

/*
 * The numeric value of g1
 */
define('App\Chess\SQUARE_G1', 6);

/*
 * The numeric value of h1
 */
define('App\Chess\SQUARE_H1', 7);


/*
 * The numeric value of a8
 */
define('App\Chess\SQUARE_A8', 56);

/*
 * The numeric value of b8
 */
define('App\Chess\SQUARE_B8', 57);

/*
 * The numeric value of c8
 */
define('App\Chess\SQUARE_C8', 58);

/*
 * The numeric value of d8
 */
define('App\Chess\SQUARE_D8', 59);

/*
 * The numeric value of e8
 */
define('App\Chess\SQUARE_E8', 60);

/*
 * The numeric value of f8
 */
define('App\Chess\SQUARE_F8', 61);

/*
 * The numeric value of g8
 */
define('App\Chess\SQUARE_G8', 62);

/*
 * The numeric value of h8
 */
define('App\Chess\SQUARE_H8', 63);

/**
 * converts formats like array(1, 3) to an integer.
 *
 * Be careful: this function can return 0 or false, so use === to check the result
 *
 * @param array $square the square to convert as an array ([$fileNumber, $rankNumber], both starting at 0)
 *
 * @return int an integer; bit 0 to 2 are the file number, bit 3 to 5 are the rank number and bit 6 and 7 are always zero (in LSB 0); returns false on failure
 */
function array2square($square)
{
    // check if the argument is an  array
    if (!is_array($square)) {
        return false;
    }

    //check if the array has two elements
    if (!(count($square) == 2)) {
        return false;
    }

    // check if one of the coordinates is no integer
    if (!is_int($square[0])
     || !is_int($square[1])) {
        return false;
    }

    // check if one of the  coordinates is outside the allowed range
    if ($square[0] > 7
     || $square[0] < 0
     || $square[1] > 7
     || $square[1] < 0) {
        return false;
    }

    return $square[0] + $square[1] * 8; // $square[0] is the file number and $square[1] the rank number; use * 8 to shift rank number by three places
}

/**
 * converts formats like 'a4' to an integer.
 *
 * Be careful: this function can return 0 or false, so use === to check the result
 *
 * @param string $square the square to convert in SAN format , e.g. 'e4'
 *
 * @return int an integer; bit 0 to 2 are the file number, bit 3 to 5 are the rank number and bit 6 and 7 are always zero (in LSB 0); returns false on failure
 */
function string2square($square)
{
    $regExpResult = preg_match('/[a-h][1-8]/', $square);

    if ($regExpResult === false) { // error occurred in preg_match
        return false; // @codeCoverageIgnore
    }

    if ($regExpResult === 0) { // $square has no valid syntax
        return false;
    }

    $fileNumber = 0;
    switch (substr($square, 0, 1)) {
        case 'a': $fileNumber = 0; break;
        case 'b': $fileNumber = 1; break;
        case 'c': $fileNumber = 2; break;
        case 'd': $fileNumber = 3; break;
        case 'e': $fileNumber = 4; break;
        case 'f': $fileNumber = 5; break;
        case 'g': $fileNumber = 6; break;
        case 'h': $fileNumber = 7; break;
        default: return false; // @codeCoverageIgnore
                               // should actually never happen, since we already used preg_match
    }

    return $fileNumber + ((int) substr($square, 1, 1) - 1) * 8; // put together the return value; see phpdoc for more details
}

/**
 * converts integers created by string2square()/array2square() to arrays like [$fileNumber, $rankNumber], with file and rank count starting at 0.
 *
 * @param int $square the square to convert
 *
 * @return array the square as an array
 */
function square2array($square)
{
    if (!is_int($square)) {
        return false;
    }

    if (($square > 63)
     || ($square < 0)) {
        return false;
    }

    return [($square & 7), (($square & 56) / 8)]; // hint: 56 is 2^5 + 2^4 + 2^3
}

/**
 * converts integers created by string2square() to readable  strings like 'a4'.
 *
 * @param int $square the square to convert
 *
 * @return string the square as a string; false on failure
 */
function square2string($square)
{
    if (!is_int($square)) {
        return false;
    }

    if (($square > 63)
     || ($square < 0)) {
        return false;
    }

    $file = '';
    switch ($square & 7) { // get the three least significant bits
        case 0: $file = 'a'; break;
        case 1: $file = 'b'; break;
        case 2: $file = 'c'; break;
        case 3: $file = 'd'; break;
        case 4: $file = 'e'; break;
        case 5: $file = 'f'; break;
        case 6: $file = 'g'; break;
        case 7: $file = 'h'; break;
        default: return false; // @codeCoverageIgnore
                               // should never happen
    }

    return $file.(string) ((($square & 56) / 8 + 1)); // take the three bits where the rank is saved and divide by 8; hint: 56 is 2^5 + 2^4 + 2^3
}

/**
 * checks if a square in SQUARE_FORMAT_INT is valid.
 *
 * @param int $square The square to validate
 *
 * @return bool true if the square is valid, false if it isn't
 */
function validateSquare($square)
{
    if (!(is_int($square))) {
        return false;
    }

    if (($square > 63)
     || ($square < 0)) {
        return false;
    }

    return true;
}

/**
 * get the rank of a square.
 *
 * @param int $square The square to parse in SQUARE_FORMAT_INT
 *
 * @return int The rank of the square, from 0 (1st rank) to 7 (8th rank)
 */
function getRank($square)
{
    if (!validateSquare($square)) {
        return false;
    }

    return ($square & 56) / 8;
}


/**
 * get the file of a square.
 *
 * @param int $square The square to parse in SQUARE_FORMAT_INT
 *
 * @return int The file of the square, from 0 (a-file) to 7 (h-file)
 */
function getFile($square)
{
    if (!validateSquare($square)) {
        return false;
    }

    return $square & 7;
}
