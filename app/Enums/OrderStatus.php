<?php
namespace App\Enums;

enum OrderStatus:string{
  case PROCESSING = 'Processing';
  case COMPLETED = 'Completed';
  case FAILED = 'Failed';
}