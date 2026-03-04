<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.whatsapp.url');
        $this->username = config('services.whatsapp.username');
        $this->password = config('services.whatsapp.password');
    }

    /**
     * Send a text message via WhatsApp
     */
    public function sendMessage($phone, $message)
    {
        $phone = $this->formatPhone($phone);

        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->post($this->baseUrl . '/send/message', [
                    'phone' => $phone,
                    'message' => $message,
                ]);

            if (!$response->successful()) {
                Log::error('WhatsApp message failed: ' . $response->body());
                throw new \Exception('Failed to send WhatsApp message. Response: ' . $response->body());
            }

            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp message exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send a file via WhatsApp
     */
    public function sendFile($phone, $filePath, $caption = '')
    {
        $phone = $this->formatPhone($phone);

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("File tidak ditemukan: {$filePath}");
            }

            $fileContent = file_get_contents($filePath);
            $fileName = basename($filePath);

            $response = Http::withBasicAuth($this->username, $this->password)
                ->timeout(60)
                ->attach('file', $fileContent, $fileName)
                ->post($this->baseUrl . '/send/file', [
                    'phone' => $phone,
                    'caption' => $caption,
                ]);

            Log::info('WhatsApp file response: ' . $response->status() . ' - ' . $response->body());

            if (!$response->successful()) {
                Log::error('WhatsApp file send failed: ' . $response->body());
                throw new \Exception('Failed to send WhatsApp file. Response: ' . $response->body());
            }

            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp file exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Format phone number to ending with @s.whatsapp.net
     */
    protected function formatPhone($phone)
    {
        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Replace leading 0 with 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Add suffix if not present
        if (!str_ends_with($phone, '@s.whatsapp.net')) {
            $phone .= '@s.whatsapp.net';
        }

        return $phone;
    }
}
