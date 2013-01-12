<?php

print "<table>";
print "<tr><th>sum</th><th>size</th><th>a</th><th>b</th></tr>";
for ($sum = 70; $sum >= 5; $sum--) {
    $divisionSizeCharacteristics = DivisionSizeCharacteristics::calculationDivisionSizeCharacteristics($sum);
    print "<tr><th class='sum'>$sum</th><th class='size'>$divisionSizeCharacteristics->divisionSize</th><th class='a'>$divisionSizeCharacteristics->noOfFullSizeDivisions</th><th class='b'>$divisionSizeCharacteristics->noOfSmallerDivisions</th></tr>\n";
}
print "</table>";

class DivisionSizeCharacteristics
{

    const MAX_DIVISIONS = 7;

    public $divisionSize;
    public $noOfFullSizeDivisions;
    public $noOfSmallerDivisions;

    function __construct($divisionSize, $noOfFullSizeDivisions, $noOfSmallerDivisions)
    {
        $this->divisionSize = $divisionSize;
        $this->noOfFullSizeDivisions = $noOfFullSizeDivisions;
        $this->noOfSmallerDivisions = $noOfSmallerDivisions;
    }

    static function calculationDivisionSizeCharacteristics($sum)
    {
        $divisionSizeValues = self::calculateDivisionSize($sum, array(8, 7, 6));
        if (empty($divisionSizeValues)) {
            $divisionSizeValues = self::calculateDivisionSize($sum, array(5));
        }
        if (empty($divisionSizeValues)) {
            $divisionSizeValues = self::calculateDivisionSize($sum, array(9));
        }
        if (empty($divisionSizeValues)) {
            $divisionSizeValues = self::calculateDivisionSize($sum, array(10));
        }
        return $divisionSizeValues;
    }

    static function calculateDivisionSize($sum, $allowedSizes)
    {
        for ($i = 0; $i <= DivisionSizeCharacteristics::MAX_DIVISIONS; $i++) {
            for ($j = 1; $j <= (DivisionSizeCharacteristics::MAX_DIVISIONS - $i); $j++) {
                foreach ($allowedSizes as $size) {
                    if ($j * $size + $i * ($size - 1) == $sum) {
                        return new DivisionSizeCharacteristics($size, $j, $i);
                    }
                }
            }
        }
        return null;
    }

}

?>