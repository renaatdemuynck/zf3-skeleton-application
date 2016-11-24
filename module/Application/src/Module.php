<?php
namespace Application;

use Zend\Config\Config;
use Zend\Mvc\MvcEvent;
use Locale;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $locale = Locale::getPrimaryLanguage(Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']));
        $translator = $e->getApplication()->getServiceManager()->get('MvcTranslator');
        $translator->setLocale($locale);
    }

    public function getConfig()
    {
        $config = new Config(include __DIR__ . '/../config/module.config.php');
        $files = glob(__DIR__ . '/../config/autoload/*.config.php');
        
        foreach ($files as $file) {
            $config->merge(new Config(include $file));
        }
        
        return $config;
    }
}
