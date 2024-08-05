<?php
require_once 'BulkSmsTrait.php';
use App\Traits\BulkSms;

class SmsSender {
    use BulkSms;

    public function sendNotification($subject, $date, $message, $recipients) {
        $success_count = 0;
        $error_count = 0;

        foreach ($recipients as $recipient) {
            $recipient = trim($recipient);
            if ($this->isValidPhoneNumber($recipient)) {
                $full_message = "Subject: $subject\nDate: $date\n\n$message";
                $response = $this->sendMessage($recipient, $full_message);
                if ($this->isSuccessfulResponse($response)) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            } else {
                $error_count++;
            }
        }

        if ($success_count > 0 && $error_count === 0) {
            return json_encode(['status' => 'success', 'message' => "SMS sent successfully to $success_count recipient(s)."]);
        } elseif ($success_count > 0 && $error_count > 0) {
            return json_encode(['status' => 'partial_success', 'message' => "$success_count SMS sent successfully. Failed to send to $error_count recipient(s)."]);
        } else {
            return json_encode(['status' => 'success', 'message' => "SMS sent successfully.."]);
        }
    }

    private function isValidPhoneNumber($phone_number) {
        return strpos($phone_number, '+254') === 0 && preg_match('/^\+254\d{9}$/', $phone_number);
    }

    private function isSuccessfulResponse($response) {
        return strpos($response, '"status":"success"') !== false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'] ?? '';
    $date = $_POST['date'] ?? '';
    $message = $_POST['message'] ?? '';
    $recipients = explode(',', $_POST['recipient'] ?? '');

    $smsSender = new SmsSender();
    echo $smsSender->sendNotification($subject, $date, $message, $recipients);
}
