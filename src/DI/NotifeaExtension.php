<?php

namespace Notifea\Nette\DI;

use Nette\DI\CompilerExtension;
use Notifea\Clients\NotifeaClient;
use Notifea\Services\EmailService;
use Notifea\Services\SmsSenderService;
use Notifea\Services\SmsService;

class NotifeaExtension extends CompilerExtension
{

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $apiHost = 'https://api.notifea.com/v1';
        if (!empty($this->config['api_host'])) {
            $apiHost = $this->config['api_host'];
        }

        $authorization = '';
        if (!empty($this->config['authorization'])) {
            $authorization = $this->config['authorization'];
        }

        $connectTimeout = 10;
        if (!empty($this->config['connect_timeout'])) {
            $connectTimeout = $this->config['connect_timeout'];
        }

        $timeout = 10;
        if (!empty($this->config['timeout'])) {
            $timeout = $this->config['timeout'];
        }

        $builder->addDefinition($this->prefix('client'))
            ->setFactory(NotifeaClient::class, [
                $apiHost,
                $authorization,
                $connectTimeout,
                $timeout
            ]);

        $builder->addDefinition($this->prefix('emailService'))
            ->setFactory(EmailService::class, [
                $this->prefix('@client'),
            ]);

        $builder->addDefinition($this->prefix('smsService'))
            ->setFactory(SmsService::class, [
                $this->prefix('@client'),
            ]);

        $builder->addDefinition($this->prefix('smsSenderService'))
            ->setFactory(SmsSenderService::class, [
                $this->prefix('@client'),
            ]);
    }

}
