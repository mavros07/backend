<?php

namespace App\Services\Mail;

use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Outbound mail: ZeptoMail API first (when configured), then PHPMailer SMTP backup.
 * All settings come from .env via config/mail.php (Resmenu-style chain).
 */
class OutboundMailService
{
    private readonly ZeptoMailApiService $zepto;

    private readonly PhpMailerService $phpmailer;

    public function __construct(ZeptoMailApiService $zepto, PhpMailerService $phpmailer)
    {
        $this->zepto = $zepto;
        $this->phpmailer = $phpmailer;
    }

    public function send(
        string $toEmail,
        string $toName,
        string $subject,
        string $html,
        ?string $replyToEmail = null,
        ?string $replyToName = null,
    ): void {
        if ($this->zepto->isEnabled()) {
            $result = $this->zepto->sendHtml($toEmail, $toName, $subject, $html, $replyToEmail, $replyToName);
            if (! empty($result['ok'])) {
                return;
            }

            Log::warning('ZeptoMail send failed; trying PHPMailer backup', [
                'http_code' => $result['http_code'] ?? null,
                'curl_errno' => $result['curl_errno'] ?? null,
                'request_id' => $result['request_id'] ?? null,
                'error_message' => $result['error_message'] ?? null,
            ]);
        }

        if ($this->phpmailer->isConfigured()) {
            $this->phpmailer->send($toEmail, $toName, $subject, $html, $replyToEmail, $replyToName);

            return;
        }

        throw new RuntimeException(
            'Mail is not configured: set ZEPTOMAIL_SENDMAIL_TOKEN for ZeptoMail API, or set MAIL_PHPMAILER_* for SMTP backup.'
        );
    }
}
