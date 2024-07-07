<?php
namespace App\Services;
/**
 * Select a random id from 1 - 10 and return
 */
class ProcessIdSelector{

   protected $idPool = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

   /**
    * Pick a random process ID from the pool.
    *
    * @return int
    */
   public function getId()
   {
       return $this->idPool[array_rand($this->idPool)];
   }
}