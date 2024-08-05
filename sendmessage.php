<?php
require_once 'BulkSmsTrait.php';

use App\Traits\BulkSms;

class SmsSender {
    use BulkSms;

    public $success_message = '';
    public $error_message = '';

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subject = trim($_POST['subject']);
            $date = trim($_POST['date']);
            $message = trim($_POST['message']);
            $recipients = array_map('trim', explode(',', $_POST['recipient'])); // Split and trim

            if (!empty($subject) && !empty($date) && !empty($message) && !empty($recipients)) {
                $has_errors = false;
                foreach ($recipients as $recipient) {
                    if ($this->isValidPhoneNumber($recipient)) {
                        $full_message = "Subject: $subject\nDate: $date\n\n$message";
                        $response = $this->sendMessage($recipient, $full_message);

                        if ($this->isSuccessResponse($response)) {
                            $this->success_message .= "SMS sent successfully to $recipient.<br>";
                        } else {
                            $this->error_message .= "Failed to send SMS to $recipient: $response<br>";
                            $has_errors = true;
                        }
                    } else {
                        $this->error_message .= "Invalid phone number format for $recipient.<br>";
                        $has_errors = true;
                    }
                }
                if (!$has_errors && empty($this->success_message)) {
                    $this->error_message = 'No SMS was sent. Please check your input.';
                }
            } else {
                $this->error_message = 'Subject, date, message, and recipient phone number are required.';
            }
        }
    }

    private function isValidPhoneNumber($phone_number) {
        // Validate phone number format
        return preg_match('/^\+254\d{9}$/', $phone_number);
    }

    private function isSuccessResponse($response) {
        // Check if response is successful
        $response_data = json_decode($response, true);
        return isset($response_data['status']) && $response_data['status'] === 'success';
    }
}

$sender = new SmsSender();
$sender->handleRequest();

$success_message = $sender->success_message;
$error_message = $sender->error_message;

// Function to send SMS (replace with your actual implementation)
function send_sms($phone_number, $message) {
    // Your SMS API logic here
    // Example:
    // $response = file_get_contents("https://api.example.com/send?to=$phone_number&message=" . urlencode($message));
    // return $response === 'success';
    return json_encode(['status' => 'success']); // Simulate success response
}
?>
