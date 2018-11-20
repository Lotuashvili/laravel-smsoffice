# Laravel SmsOffice

This package is service for smsoffice.ge with notification channels.

You can simply write `$user->notify(new FooNotification)`

## Installation

```
composer require lotuashvili/laravel-smsoffice
```

Then run:

```
php artisan vendor:publish --provider="Lotuashvili\LaravelSmsOffice\SmsOfficeServiceProvider" --tag="config"
```

Place your api key and sender name in `config/smsoffice.php` file

## Using log instead of sending real sms

If you want to use log in development instead of sending real sms, then add `SMSOFFICE_DRIVER=log` to your `.env` file

## Usage

### Send with notification class

In `User` class, add `routeNotificationForSms()` method and return phone number of user

```php
class User extends Authenticatable
{
    # Code...

    public function routeNotificationForSms()
    {
        return $this->phone;
    }
}
```

Create notification

```
php artisan make:notification FooNotification
```

In our newly created notification, import `SmsOfficeChannel` and add it to `via()` method. Write notification content in `toSms()` method

```php
use Illuminate\Notifications\Notification;
use Lotuashvili\LaravelSmsOffice\SmsOfficeChannel;

class FooNotification extends Notification
{
    public function via($notifiable)
    {
        return [SmsOfficeChannel::class];
    }
    
    public function toSms($notifiable)
    {
        return 'Test Notification';
    }
}
```

And then send notification to user

```php
$user->notify(new FooNotification)
```

### Send directly without notification

You have to inject or initialize `SmsOffice` class and then call `send` function

```php
use Lotuashvili\LaravelSmsOffice\SmsOffice;

public function sendSms(SmsOffice $smsoffice)
{
    $smsoffice->send('599123123', 'Test Message');
}
```
