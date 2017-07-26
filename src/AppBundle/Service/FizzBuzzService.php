<?php

namespace AppBundle\Service;

use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class FizzBuzzService
{

    /**
     * Get an array of the FizzBuzz data
     *
     * @param $rangeStart
     * @param $rangeEnd
     * @param $triggers
     *
     * @return array
     */
    public function getFizzBuzzDataArray($rangeStart, $rangeEnd, array $triggers)
    {
        if(is_int($rangeStart) && is_int($rangeEnd)){
            if($rangeEnd > $rangeStart){

                $returnArray = [];

                for ($i = $rangeStart; $i <= $rangeEnd; $i++) {

                    foreach ($triggers as $trigger){
                        if($i % $trigger['modValue'] == 0 && $i != 0){
                            $returnArray[] = $trigger['replacement'];
                            continue 2;
                        }
                    }

                    // if the loop hasn't continued there have been no trigger matches so def
                    $returnArray[] = $i;

                }

                return $returnArray;

            }else{
                throw new InvalidArgumentException('Range end must be greater than range start');
            }

        }else{
            throw new InvalidArgumentException('Range values must be integers');
        }
    }

    /**
     * Use the getFizzBuzzDataArray method and build into a string response instead of array
     *
     * @param $rangeStart
     * @param $rangeEnd
     * @param array $triggers
     * @return string
     */
    public function getFizzBuzzString($rangeStart, $rangeEnd, array $triggers)
    {
        $fizzbuzzDataArray = $this->getFizzBuzzDataArray($rangeStart, $rangeEnd, $triggers);

        $returnString = '';

        // get last array element to check when adding spacing in loop
        $arrayKeys = array_keys($fizzbuzzDataArray);
        $lastArrayKey = array_pop($arrayKeys);

        foreach ($fizzbuzzDataArray as $key => $listElement){
            $returnString .= $listElement;
            if($lastArrayKey !== $key){
                $returnString .= ' ';
            }
        }

        return $returnString;

    }

}