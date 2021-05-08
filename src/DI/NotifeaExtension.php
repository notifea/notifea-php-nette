<?php

namespace Notifea\Nette\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Notifea\Clients\NotifeaClient;
use Notifea\Services\EmailService;
use Notifea\Services\SmsService;

class NotifeaExtension extends CompilerExtension
{

    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            'api_host' => Expect::string('https://api.notifea.com/v1'),
            'authorization' => Expect::string()->required(),
            'connect_timeout' => Expect::string('10'),
            'timeout' => Expect::string('30'),
        ]);
    }

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('client'))
            ->setFactory(NotifeaClient::class, [
                $this->config->api_host,
                $this->config->authorization,
                $this->config->connect_timeout,
                $this->config->timeout
            ]);

        $builder->addDefinition($this->prefix('emailService'))
            ->setFactory(EmailService::class, [
                $this->prefix('@client'),
            ]);

        $builder->addDefinition($this->prefix('smsService'))
            ->setFactory(SmsService::class, [
                $this->prefix('@client'),
            ]);
    }

}
