<?php
require 'Omatcho\AsciiTable.php';

$tableData = array(
    array(
        'Name' => 'Trixie',
        'Color' => 'Green',
        'Element' => 'Earth',
        'Likes' => 'Flowers',
        ),
    array(
        'Name' => 'Tinkerbell',
        'Element' => 'Air',
        'Likes' => 'Singning',
        'Color' => 'Blue',
        ),
    array(
        'Element' => 'Water',
        'Likes' => 'Dancing',
        'Name' => 'Blum',
        'Color' => 'Pink',
        ),
);

$acsiiTable = new \Omatcho\AsciiTable($tableData);
//print the ascii table
$acsiiTable->printAscii();
