<?php

namespace AppBundle\Service;

use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class FizzBuzzService
{

    /** the default triggers to be used for replacements */
    private $defaultTriggers;

    /**
     * the order to display the counts when reporting
     * todo make report order configurable as a dependency or optional setter
     */
    private static $reportOrder = [
        'fizz' => 1,
        'buzz' => 2,
        'fizzbuzz' => 3,
        'lucky' => 4,
        'integer' => 5
    ];

    public function __construct()
    {
        // todo triggers are complex enough that they warrant a structured definition so they can be built before passing
        $this->defaultTriggers = [
            [
                'replacement' => 'lucky',
                'function' => function($i){
                    return (preg_match('/3/', (string) $i));
                }
            ],
            [
                'replacement' => 'fizzbuzz',
                'function' => function($i){
                    return ($i % 15 == 0 && $i != 0);
                }
            ],
            [
                'replacement' => 'fizz',
                'function' => function($i){
                    return ($i % 3 == 0 && $i != 0);
                }
            ],
            [
                'replacement' => 'buzz',
                'function' => function($i){
                    return ($i % 5 == 0 && $i != 0);
                }

            ],
        ];
    }

    /**
     * Get an array of the FizzBuzz data
     *
     * @param $rangeStart
     * @param $rangeEnd
     * @param $triggers
     *
     * @return array
     */
    public function getFizzBuzzDataArray($rangeStart, $rangeEnd, array $triggers = null)
    {
        // set defaults for triggers if none are passed
        if(is_null($triggers)){
            $triggers = $this->defaultTriggers;
        }

        // check arguments are valid
        if(is_int($rangeStart) && is_int($rangeEnd)){
            if($rangeEnd > $rangeStart){

                $returnArray = ['data' => [], 'counts' => ['integer' => 0]];

                for ($i = $rangeStart; $i <= $rangeEnd; $i++) {

                    foreach ($triggers as $trigger) {
                        if(!array_key_exists($trigger['replacement'], $returnArray['counts'])){
                            $returnArray['counts'][$trigger['replacement']] = 0;
                        }
                        if ($trigger['function']($i)) {
                            $returnArray['data'][] = $trigger['replacement'];
                            $returnArray['counts'][$trigger['replacement']]++;
                            // stop foreach execution and continue next for loop
                            continue 2;
                        }
                    }

                    // if the loop hasn't continued there have been no trigger matches so default to integer
                    $returnArray['data'][] = $i;
                    $returnArray['counts']['integer']++;

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
    public function getFizzBuzzString($rangeStart, $rangeEnd, array $triggers = null)
    {
        $fizzbuzzDataArray = $this->getFizzBuzzDataArray($rangeStart, $rangeEnd, $triggers);

        $returnString = '';

        // get last array element to check when adding spacing in loop
        $arrayKeys = array_keys($fizzbuzzDataArray['data']);
        $lastArrayKey = array_pop($arrayKeys);

        foreach ($fizzbuzzDataArray['data'] as $key => $listElement){
            $returnString .= $listElement;
            if($lastArrayKey !== $key){
                $returnString .= ' ';
            }
        }

        // sort counts value for report based on default report order
        uksort($fizzbuzzDataArray['counts'], function($a, $b){
            return (self::$reportOrder[$a] < self::$reportOrder[$b]) ? -1 : 1;
        });

        // loop through counts for report
        foreach ($fizzbuzzDataArray['counts'] as $label => $count){
            $returnString .= "\n" . $label . ': ' . $count;
        }

        return $returnString;

    }

}