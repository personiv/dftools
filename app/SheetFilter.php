<?php

namespace App;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class SheetFilter implements IReadFilter {
    private $startRow = 0;
    private $columns = [];

    public function __construct($columns) {
        $this->columns = $columns;
    }

    public function readCell($column, $row, $worksheetName = '') {
        if (in_array(Coordinate::columnIndexFromString($column) - 1, $this->columns)) return true;
        return false;
    }
}