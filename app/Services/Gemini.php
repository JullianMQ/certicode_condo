<?php

namespace App\Services;

use GuzzleHttp\Client;

class Gemini
{
    protected $client;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
        ]);
    }

    public function generateText($prompt, $model = 'gemini-2.5-flash-lite')
    {
        $url = $this->baseUrl . $model . ':generateContent?key=' . env('GEMINI_API_KEY');

        $dataFiles = [
            storage_path('app/data/condos.json'),
            storage_path('app/data/bookings.json'),
            storage_path('app/data/maintenance.json'),
            storage_path('app/data/amenities.json'),
        ];

        $contextData = '';
        foreach ($dataFiles as $file) {
            if (file_exists($file)) {
                $json = json_decode(file_get_contents($file), true);
                $contextData .= json_encode($json, JSON_PRETTY_PRINT) . "\n\n";
            }
        }


        $systemInstruction = "You are a property management assistant.
        Only answer questions related to property management or based on the provided data.
        If the question is unrelated, reply with: 'I can only help with property management topics.'

        Here is the property data you must use:\n\n{$contextData}

        Question: {$prompt}";

        $response = $this->client->post($url, [
            'json' => [
                'contents' => [
                    ['parts' => [['text' => $systemInstruction]]]
                ]
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }
}
