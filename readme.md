
# Laravel Sendgrid

## Installation

### `config/app.php`

```php
    // Remove or comment out:
    // Illuminate\Mail\MailServiceProvider::class,
    // Add
    Timfeid\LaravelSendgrid\LaravelSendgridServiceProvider::class,
```

### `config/services.php`
```php
    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY'),
    ],
```
### `.env`
```
SENDGRID_API_KEY=[your_api_key]
```
## Usage

```php
    Mail::send('email.forgot-password', [], function ($mail) {
        // Added category functionality
        $mail->category('forgot-password');
        // Added custom arguments functionality
        $mail->uniqueArgs(['user_id' => 1]);

        // Default Laravel functionality
        $mail->to('email@address.com');
        $mail->subject('Crazy subject');
    });
```