<?php

namespace App\Services\Mail;

/**
 * ZeptoMail transactional API (HTTP), separate from PHPMailer SMTP backup.
 * Mirrors the flow used in Resmenu: Zoho-enczapikey + JSON payload.
 */
final class ZeptoMailApiService
{
    public function isEnabled(): bool
    {
        $token = $this->normalizedToken();

        return $token !== '';
    }

    /**
     * @return array{ok: bool, http_code: int, curl_errno: int, request_id: ?string, error_message: ?string}
     */
    public function sendHtml(
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlBody,
        ?string $replyToEmail = null,
        ?string $replyToName = null,
        ?string $fromAddress = null,
        ?string $fromName = null,
    ): array {
        if (!function_exists('curl_init')) {
            return [
                'ok' => false,
                'http_code' => 0,
                'curl_errno' => 0,
                'request_id' => null,
                'error_message' => 'cURL extension not available',
            ];
        }

        $token = $this->normalizedToken();
        if ($token === '') {
            return [
                'ok' => false,
                'http_code' => 0,
                'curl_errno' => 0,
                'request_id' => null,
                'error_message' => 'ZEPTOMAIL_SENDMAIL_TOKEN not configured',
            ];
        }

        $url = trim((string) config('mail.zeptomail.url'));
        if ($url === '') {
            $url = 'https://api.zeptomail.com/v1.1/email';
        }

        $timeout = max(1, (int) config('mail.zeptomail.timeout_seconds'));

        $fromAddress = trim((string) ($fromAddress ?? config('mail.zeptomail.from_address')));
        if ($fromAddress === '') {
            $fromAddress = (string) config('mail.from.address');
        }

        $fromName = trim((string) ($fromName ?? config('mail.zeptomail.from_name')));
        if ($fromName === '') {
            $fromName = (string) config('mail.from.name');
        }

        $defaultReply = trim((string) config('mail.zeptomail.reply_to'));
        $replyToEmail = $replyToEmail !== null ? trim($replyToEmail) : $defaultReply;
        $replyToName = trim((string) ($replyToName ?? ''));

        $toName = trim($toName) !== '' ? $toName : $toEmail;

        $payload = [
            'from' => array_filter([
                'address' => $fromAddress,
                'name' => $fromName,
            ], static fn ($v) => $v !== ''),
            'to' => [[
                'email_address' => array_filter([
                    'address' => $toEmail,
                    'name' => $toName,
                ], static fn ($v) => $v !== ''),
            ]],
            'subject' => $subject,
            'htmlbody' => $htmlBody,
        ];

        if ($replyToEmail !== '') {
            $payload['reply_to'] = [array_filter([
                'address' => $replyToEmail,
                'name' => $replyToName,
            ], static fn ($v) => $v !== '')];
        }

        $attempts = 2;
        $responseBody = '';
        $curlErrno = 0;
        $httpCode = 0;
        $curlError = '';

        for ($attempt = 1; $attempt <= $attempts; $attempt++) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'accept: application/json',
                    'content-type: application/json',
                    'authorization: Zoho-enczapikey '.$token,
                ],
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
            ]);

            $responseBody = (string) curl_exec($curl);
            $curlErrno = (int) curl_errno($curl);
            $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = (string) curl_error($curl);
            curl_close($curl);

            $shouldRetry =
                ($attempt < $attempts)
                && (
                    $curlErrno !== 0
                    || $httpCode === 0
                    || $httpCode === 408
                    || $httpCode === 425
                    || $httpCode === 429
                    || ($httpCode >= 500 && $httpCode <= 599)
                );

            if (! $shouldRetry) {
                break;
            }
        }

        $requestId = null;
        $errorMessage = null;
        $decoded = null;
        if ($responseBody !== '') {
            $decoded = json_decode($responseBody, true);
            if (is_array($decoded)) {
                $requestId = $decoded['request_id'] ?? ($decoded['error']['request_id'] ?? null);
                $errorMessage = isset($decoded['error']['message']) && is_string($decoded['error']['message'])
                    ? $decoded['error']['message']
                    : null;
            }
        }

        if ($curlErrno !== 0) {
            return [
                'ok' => false,
                'http_code' => $httpCode,
                'curl_errno' => $curlErrno,
                'request_id' => $requestId,
                'error_message' => $curlError !== '' ? $curlError : ($errorMessage ?? 'ZeptoMail curl error'),
            ];
        }

        $ok = ($httpCode >= 200 && $httpCode < 300);
        if (! $ok && $errorMessage === null && is_array($decoded) && isset($decoded['message']) && is_string($decoded['message'])) {
            $errorMessage = $decoded['message'];
        }

        return [
            'ok' => $ok,
            'http_code' => $httpCode,
            'curl_errno' => $curlErrno,
            'request_id' => $requestId,
            'error_message' => $ok ? null : ($errorMessage ?? 'ZeptoMail HTTP error'),
        ];
    }

    private function normalizedToken(): string
    {
        $token = trim((string) config('mail.zeptomail.sendmail_token'));
        $token = preg_replace('/^zoho-enczapikey\s+/i', '', $token) ?? $token;

        return trim((string) $token);
    }
}
