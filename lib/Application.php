<?php

namespace OCA\Jsloader;

use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\EventDispatcher\IEventDispatcher;
use OC\Security\CSP\ContentSecurityPolicy;

class Application implements IBootstrap {

    public function register(IRegistrationContext $context): void {
        // Rien à enregistrer ici
    }

    public function boot(IBootContext $context): void {
        $dispatcher = $context->getAppContainer()->query(IEventDispatcher::class);

        $dispatcher->addListener(BeforeTemplateRenderedEvent::class, function (BeforeTemplateRenderedEvent $event) {
            $config = \OC::$server->getConfig();
            $snippet = $config->getAppValue('jsloader', 'snippet', '');

            if ($snippet !== '') {
                $urlGen = \OC::$server->getURLGenerator();
                $nonce = \OC::$server->getContentSecurityPolicyNonceManager()->getNonce();

                $linkToJs = $urlGen->linkToRoute('jsloader.JS.script', [
                    'v' => $config->getAppValue('jsloader', 'cachebuster', '0'),
                ]);

                $event->addHeader('script', [
                    'src' => $linkToJs,
                    'nonce' => $nonce,
                ]);

                $url = $config->getAppValue('jsloader', 'url', '');
                if ($url !== '') {
                    $CSPManager = \OC::$server->getContentSecurityPolicyManager();
                    $policy = new ContentSecurityPolicy();
                    $policy->addAllowedScriptDomain($url);
                    $policy->addAllowedImageDomain($url);
                    $policy->addAllowedConnectDomain($url);
                    $CSPManager->addDefaultPolicy($policy);
                }
            }
        });
    }
}
