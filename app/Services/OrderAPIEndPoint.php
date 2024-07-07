<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
/**
 * Send completed orders to this API end point.
 */
class OrderAPIEndPoint{

  protected $apiEndPoint;
  
  /**
   * Get API end point url from app config file
   */
  public function __construct()
  {
    $this->apiEndPoint = Config::get('app.apiEndPoint');
  }

  /**
   * Send order payload to api end point
   */
  public function send(array $data){

    $content = json_encode($data);
    $curl = curl_init($this->apiEndPoint);
    
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    /**Check for response header code for errors 
     * Commented this section because api enpoint return 404 instead of 200 or 201.
    */
    // if ( $status != 201 ) {
    //     die("Error: call to URL $this->apiEndPoint failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    // }

    curl_close($curl);

    return $json_response;
    
  } 


}