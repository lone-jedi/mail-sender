<?php

class Sms
{
    static public function send(string $message, array $phones)
    {
        $data = json_encode([
            'phone' => $phones,
            'message' => $message,
            'src_addr' => 'YOUR_ADDR'
        ]);
        
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => SMS_URL,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . SMS_API_TOKEN,
                'Content-Type: application/json'
            ]
        ]);
        
        return curl_exec($ch);
    }
}