# notifea-php-nette
Nette wrapper for PHP language for Notifea services.

[Notifea](https://notifea.com) provides clients very user-friendly way of sending transactional emails
and sms to their users.

This package is a Nette wrapper for [Notifea PHP package](https://github.com/notifea/notifea-php).

## Minimum requirements

This package will require you to use:
- PHP 7.0 or higher
- [guzzlehttp/guzzle](https://github.com/guzzle/guzzle) 6.0 or higher
- ext-json

## Installation

To install the SDK you need to be using [Composer]([https://getcomposer.org/)
in your project. To install it please see the [docs](https://getcomposer.org/download/).

After you installed [Composer]([https://getcomposer.org/) install the SDK

```shell script
composer require notifea/notifea-php-nette
```

Start by registering `Notifea\Nette\DI\NotifeaExtension` in your config `neon` file

```neon
extensions:
    notifea: Notifea\Nette\DI\NotifeaExtension
```

You are only required to set `authorization` config key. Value can be generated in
[access-tokens](https://app.notifea.com/access-tokens) section.

```neon
extensions:
    notifea: Notifea\Nette\DI\NotifeaExtension

notifea:
    authorization: "Bearer {token}"
```

There are few more optional parameters you can specify.

```neon
extensions:
    notifea: Notifea\Nette\DI\NotifeaExtension

notifea:
    api_host: "https://api.notifea.com/v1"
    authorization: "Bearer {token}"
    connect_timeout: 10
    timeout: 30
```

### Versions

This package currently supports:
- nette 2.4 using tag ^0.0.1
- nette 3.0 using tag ^1.0.0

To add support for other versions please get in touch with us.

## Usage

This packages provides a convenient dependency injection layer
for `Notifea\Services\EmailService`, `Notifea\Services\SmsService` and `Notifea\Services\SmsSenderService` implemented in our
core [Notifea PHP package](https://github.com/notifea/notifea-php) so they can be easily used anywhere in
your Nette application.

One could inject them like this:

```php
class UserPresenter extends Nette\Application\UI\Presenter
{
    /** @var EmailService */
    protected $emailService;

    /** @var SmsService */
    protected $smsService;
    
    /** @var SmsSenderService */
    protected $smsSenderService;

    /**
     * UserPresenter constructor.
     * @param EmailService $emailService
     * @param SmsService $smsService
     * @param SmsSenderService $smsSenderService
     */
    public function __construct(
        EmailService $emailService,
        SmsService $smsService,
        SmsSenderService $smsSenderService
    ) {
        $this->emailService = $emailService;
        $this->smsService = $smsService;
        $this->smsSenderService = $smsSenderService;
    }

    public function actionSendEmail()
    {
        // .. your business logic
        $email = new Email();
        // ... 
        $sentEmail = $this->emailService->sendEmail($email);
    }

    public function actionSendSms()
    {
        // .. your business logic
        $sms = new Sms();
        // ... 
        $sentSms = $this->smsService->sendSms($sms);
    }
    
    public function actionCreateSmsSender()
    {
        // .. your business logic
        $smsSender = new SmsSender();
        // ... 
        $createdSmsSender = $this->smsSenderService->createSmsSender($smsSender);
    }

}
```

`EmailService` contains these methods:
- getEmails()
- getEmail(string $emailUuid)
- sendEmail(Email $email)
- deleteEmail(string $emailUuid)

`SmsService` contains these methods:
- getSmss()
- getSms(string $smsUuid)
- sendSms(Sms $sms)
- deleteSms(string $smsUuid)

`SmsSenderService` contains these methods:

- getSmsSenders()
- getSmsSender(string $smsSenderUuid)
- createSmsSender(SmsSender $smsSender)
- updateSmsSender(SmsSender $smsSender)
- deleteSmsSender(string $smsSenderUuid)

To find more detailed documentation about each method, check out our core [Notifea PHP package](https://github.com/notifea/notifea-php)

## Community

- [Documentation](https://docs.notifea.com)
- [Report issues](https://github.com/notifea/notifea-php/issues)

## Contributing

Dependencies are managed through `composer`:

```
$ composer install
```

Tests can be run via phpunit:

```
$ vendor/bin/phpunit
```
