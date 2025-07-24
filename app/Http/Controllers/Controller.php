<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

 /**
 * @OA\Info(
 *     title="Forever Medspa",
 *     version="1.0.0",
 *     description="All API Related to Giftcards",
 *     termsOfService="test",
 *     contact={
 *         "name": "Forever Medspa",
 *         "url": "https://forevermedspanj.com",
 *         "email": "info@forevermedspanj.com"
 *     },
 *     license={
 *         "name": "License",
 *         "url": "https://forevermedspanj.com/license"
 *     }
 * )
 *  * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */


    public function upload_single_image($file,$folder)
    {
    	$data = $file->getClientOriginalName();
	    $file->move(public_path('images/'.$folder."/"), $data);
    	return url('/').'/images/'.$folder."/".$data;
    }

    public function delete_image($name,$folder){
		
		if(file_exists(public_path('images/'.$folder."/").$name)){
                unlink(public_path('images/'.$folder."/".$name));
                return true;
        }else{
               return false;
        } 

	}

//  For Get API
function getAPI($apiName){
        // dd(env('API_URL').$apiName);
        $curl = curl_init();
        
                curl_setopt_array($curl, array(
                CURLOPT_URL => env('API_URL').$apiName,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                    'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8',
                    'Cache-Control: no-cache',
                    'Connection: keep-alive',
                    'DNT: 1',
                    'Pragma: no-cache',
                    'Upgrade-Insecure-Requests: 1',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36'
                ),
                ));
        
                $response = curl_exec($curl);
                curl_close($curl);
        
        
                $responseArray = json_decode($response, true);
                // dd($responseArray);
                return $responseArray;
        
        
            }
     // For Post getAPI    

 function postAPI($apiName,$data){

        // dd(env('API_URL').$apiName);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => env('API_URL').$apiName,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$data,
          CURLOPT_HTTPHEADER => array(
            'Accept: */*',
            'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-Type: application/json',
            'DNT: 1',
            'Pragma: no-cache',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
            'X-Requested-With: XMLHttpRequest'
          ),
        ));
       
        $response = curl_exec($curl);
        
        curl_close($curl);
        $responseArray = json_decode($response, true);
                return $responseArray;
        
            }
    //  Image Upload API
    function ImageAPI($apiName, $data) {
      // Initialize cURL session
      $curl = curl_init();
  
      // Set cURL options
      curl_setopt_array($curl, array(
          CURLOPT_URL => env('API_URL') . $apiName, // API URL
          CURLOPT_RETURNTRANSFER => true, // Return the response as a string
          CURLOPT_ENCODING => '', // Enable compression
          CURLOPT_MAXREDIRS => 10, // Follow up to 10 redirects
          CURLOPT_TIMEOUT => 0, // No timeout
          CURLOPT_FOLLOWLOCATION => true, // Follow redirects
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
          CURLOPT_CUSTOMREQUEST => 'POST', // Request method
          CURLOPT_POSTFIELDS => $data, // POST data
          CURLOPT_HTTPHEADER => array(
              'Authorization: Basic Og==' // Example authorization header
          ),
      ));
  
      // Execute cURL request
      $response = curl_exec($curl);
  
      // Check for errors
      if(curl_errno($curl)) {
          // Handle cURL error
          $error_message = curl_error($curl);
          // You may want to log or handle the error appropriately
          return "cURL Error: " . $error_message;
      }
  
      // Close cURL session
      curl_close($curl);
  
      // Return API response
      return $response;
  }
  

  }

