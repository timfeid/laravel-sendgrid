# Laravel Sendgrid

## Installation

* Remove `Illuminate\Mail\MailServiceProvider::class,` from your providers array in the `config/app.php` file.
* Add `Timfeid\LaravelSendgrid\Providers\MailServiceProvider::class` to your providers array in the `config/app.php` file.

## Usage

```php
    Mail::send('email.forgot-password', [], function ($mail) {
        // Added tracking functionality
        $mail->category('forgot-password');
        // Laravel functionality
        $mail->to('email@address.com');
        $mail->subject('Crazy subject');
    });
```