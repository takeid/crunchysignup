<?php

namespace CrunchySignup;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements 
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
//            'Zend\Loader\ClassMapAutoloader' => array(
//                __DIR__ . '/autoload_classmap.php',
//            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'ZfcUser\Authentication\Adapter\Db' => 'CrunchySignup\Authentication\Adapter\Db',
            ),
            // Defined aliases with Dependency Injection
            'factories' => array(
                // options object with options from crunchysignup.global.php
                'crunchysignup_module_options' => function($sm) {
                    $config = $sm->get('Configuration');
                    return new Options\ModuleOptions($config['crunchysignup']);            
                },
                // define service
                'crunchysignup_ev_service' => function($sm) {
                    $obj = new Service\Signup();
                    $obj->setServiceLocator($sm);
                    $obj->setSignupMapper($sm->get('crunchysignup_ev_modelmapper'));
                    $obj->setMessageRenderer($sm->get('Zend\View\Renderer\PhpRenderer'));
                    $obj->setMessageTransport($sm->get('Zend\Mail\Transport\Sendmail'));
                    $obj->setEmailMessageOptions($sm->get('crunchysignup_module_options'));
                    return $obj;
                },
                // define mapper        
                'crunchysignup_ev_modelmapper_zenddb' => function($sm) {
                    $obj = new Mapper\Signup\ZendDb();
                    $obj->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                    $obj->setEntityPrototype(new Entity\User());
                    $obj->setHydrator(new \ZfcUser\Mapper\UserHydrator());
                    return $obj;
                },
                // define mail transport
                'Zend\Mail\Transport\Sendmail' => function($sm) {
                    return new \Zend\Mail\Transport\Sendmail();
                }
            )
        );
    }

}
