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
     * @return string
     */
    public function getFizzBuzzDataArray($rangeStart, $rangeEnd)
    {
        if(is_int($rangeStart) && is_int($rangeEnd)){
            if($rangeEnd > $rangeStart){

                $returnArray = [];

                for ($i = $rangeStart; $i <= $rangeEnd; $i++) {

                    // we're allowing all integers in the range, including and negative integers and 0 so we must handle 0
                    if ($i % 3 == 0 && $i % 5 == 0 && $i != 0) {

                        $returnArray[] = 'fizzbuzz';

                    } elseif ($i % 3 == 0 && $i != 0) {

                        $returnArray[] = 'fizz';

                    } elseif ($i % 5 == 0 && $i != 0) {

                        $returnArray[] = 'buzz';

                    } else {
                        $returnArray[] = $i;
                    }

                }

                return $returnArray;

            }else{
                throw new InvalidArgumentException('Range end must be greater than range start');
            }
        }else{
            throw new InvalidArgumentException('Range values must be integers');
        }
    }

}