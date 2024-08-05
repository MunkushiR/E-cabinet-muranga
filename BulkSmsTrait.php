<?php

namespace App\Traits;

trait BulkSms
{
    private function sendMessage($phone_number, $message)
    {
        $url = 'https://sms.crowdcomm.co.ke/sms/v3/sendsms';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "api_key" => "mTUcfPk5aHCL4YDezBtQXiNw0pjO1Jqb2IM9gSryKsuRG6AW8h7lEVdFovx3nZ",
                "service_id" => 0,
                "mobile" => $phone_number,
                "response_type" => "json",
                "shortcode" => "CG_MURANGA",
                "message" => $message
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }

        curl_close($curl);
        return $response;
    }
}
