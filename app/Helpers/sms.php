<?php

if (!function_exists('sendSMS')) {

    function sendSMS($mobile, $message, $templateId)
    {
        $apiKey = env('SMS_API_KEY');

        $senderId = "ANNISK";

        $url = "https://sms.creativepoint.in/api/push.json";

        $data = [
            'apikey'   => $apiKey,
            'sender'   => $senderId,
            'mobileno' => '91' . $mobile,
            'text'     => $message,
            'tempid'   => $templateId,
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url . '?' . http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        \Log::info('SMS RESPONSE: ' . $response);

        return $response;
    }
}