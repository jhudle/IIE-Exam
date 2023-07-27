<?php

class ConstructorClass {
    private $data;

    public function __construct($array) {
        $this->data = $array;
    }

    public function bubbleSort() {
        $length = count($this->data);
        for ($i = 0; $i < $length - 1; $i++) {
            for ($j = 0; $j < $length - $i - 1; $j++) {
                if ($this->data[$j] > $this->data[$j + 1]) {
                    $temp = $this->data[$j];
                    $this->data[$j] = $this->data[$j + 1];
                    $this->data[$j + 1] = $temp;
                }
            }
        }
    }

    public function getMedian() {
        $length = count($this->data);
        $middleIndex = floor($length / 2);
        return ($length % 2 === 0) ? ($this->data[$middleIndex - 1] + $this->data[$middleIndex]) / 2 : $this->data[$middleIndex];
    }

    public function getLargestValue() {
        return end($this->data);
    }

    public function getData() {
        return $this->data;
    }
}


class MainClass {
    public function useConstructorClass($array) {
        $constructorObj = new ConstructorClass($array);
        $constructorObj->bubbleSort();
        $sortedArray = $constructorObj->getData(); // Get the sorted array from ConstructorClass

        $median = $constructorObj->getMedian();
        $largestValue = $constructorObj->getLargestValue();

        echo "Sorted Array: ".implode(", ", $sortedArray)."<br/>";
        echo "Median: ".$median."<br/>";
        echo "Largest Value: ".$largestValue."<br/>";
    }
}

$mainObj = new MainClass();
$dataArray = [5, 2, 8, 1, 3, 7];
$mainObj->useConstructorClass($dataArray);

?>