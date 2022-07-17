<?php

namespace AscentCreative\CMS\Util;

class SplitAndRound {
   
   /**
    * 
    * Convenience function - sometimes we just want to split evenly across a set number of shares.
    * However, rounding may still be required, so this class can help with that.
    * This function calcs the splits needed and then calls the main process function
    *
    * @param float $value
    * @param int $count
    * @param int $dp=2
    * 
    * @return array
    */
    static function processEqually(float $value, int $count, int $dp=2) : array {

        $splits = [];
        for($i = 0; $i < $count; $i++) {
            $splits[] = 100 / $count;
        }

        return SplitAndRound::process($value, $splits, $dp);
    }

   /**
    * @param float $value - The total value
    * @param array $splits - The percentages to split across
    * @param 
    * @param int $dp=2 - The DP to round
    * 
    * @return array - the corresponding split values
    */
    static function process(float $value, array $splits, int $dp=2) : array {

        $out = array();
        $ttl = 0;

        $splits = collect($splits)->transform(function($item) {
            return is_null($item) ? 1 : $item;
        });
        
        // dump($value);
        // dump($splits);
        $totalShares = collect($splits)->sum();
        // dump($totalShares);

        /**
         * Step one - roughly split and round the items
         */
        foreach($splits as $key=>$split) {

            $item = round($value * ($split / $totalShares), $dp);
            $ttl += $item;
            $out[$key] = $item;

        }

    
        $items = collect($out)->sortDesc();

       // dump($items);

        /**
         * Step two - account for rounding errors
         */
        // find the rounding difference
        $diff = round($value - $ttl, $dp);
        if ($diff < 0) {
            $sign = 'neg';
            $diff = $diff * -1;
            $items = $items->reverse(); 
        } else {
            $sign = 'pos';
            
        }

        // the pot will decrease as we assign it.
        $pot = $diff;

      
         /* there's a weakness where the pot may round up to 0.01, but extra shares will round down to 0.00
                causing a loop as the pot will never decrease.

                In that case, apply 0.01 to the first item and decrease the pot to break the loop.
            */

        if(round($value, $dp) > 0 && round($value / count($items), $dp) == 0) {

            $keys = $items->keys();
            $items[$keys[0]] += round($pot, $dp);

        } else {

            // while rounding pot value > 0
            while(round($pot, $dp) > 0) {

                foreach($items as $key=>$val) {

                    if(round($pot, $dp) > 0) { // && $i < count($out)) {

                        $rate = $items[$key] / $value;
                        $extra = ceil($diff * $rate * 100) / 100;

                        if ($sign == 'pos') {
                            $items[$key] = $items[$key] + $extra;
                        } else {
                            $items[$key] = $items[$key] - $extra;
                        }

                        $pot -= $extra;

                    }
            
                }

            }

        }

        // reassign the updated values to the original output;

        // dump($items);

        foreach($items as $key=>$val) {
            $out[$key] = $val;
        }
 

        return $out;

    }


}