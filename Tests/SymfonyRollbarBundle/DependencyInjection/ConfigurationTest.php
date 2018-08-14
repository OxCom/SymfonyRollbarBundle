<?php

namespace SymfonyRollbarBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use SymfonyRollbarBundle\DependencyInjection\Configuration;
use SymfonyRollbarBundle\DependencyInjection\SymfonyRollbarExtension;

/**
 * Class ConfigurationTest
 *
 * @package SymfonyRollbarBundle\Tests\DependencyInjection
 */
class ConfigurationTest extends KernelTestCase
{
    public function testParameters()
    {
        static::bootKernel();
        $container = static::$kernel->getContainer();

        $config           = $container->getParameter(SymfonyRollbarExtension::ALIAS . '.config');
        $defaultErrorMask = E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR;

        $exclude   = Configuration::$exclude;
        $exclude[] = '\SymfonyRollbarBundle\Tests\Fixtures\MyAwesomeException';
        $exclude[] = '\ParseError';
        $exclude[] = '\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface';

        $exceptionRates = [
            '\Symfony\Component\Security\Core\Exception\AccessDeniedException'                      => [
                'rate' => 0.1,
            ],
            '\Symfony\Component\HttpKernel\Exception\NotFoundHttpException'                         => [
                'rate' => 0.5,
            ],
            '\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException'                     => [
                'rate' => 0.5,
            ],
            '\Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException' => [
                'rate' => 1,
            ],
        ];

        $default = [
            'enable'     => true,
            'exclude'    => $exclude,
            'rollbar'    => [
                'access_token'                   => 'SOME_ROLLBAR_ACCESS_TOKEN_123456',
                'agent_log_location'             => static::$kernel->getLogDir() . '/rollbar.log',
                'base_api_url'                   => Configuration::API_ENDPOINT,
                'branch'                         => Configuration::BRANCH,
                'capture_error_stacktraces'      => true,
                'checkIgnore'                    => '\SymfonyRollbarBundle\Tests\Fixtures\CheckIgnoreProvider',
                'code_version'                   => '',
                'enable_utf8_sanitization'       => true,
                'environment'                    => static::$kernel->getEnvironment(),
                'error_sample_rates'             => [],
                'handler'                        => Configuration::HANDLER_BLOCKING,
                'include_error_code_context'     => false,
                'include_exception_code_context' => false,
                'included_errno'                 => $defaultErrorMask,
                'logger'                         => null,
                'person'                         => [],
                'person_fn'                      => '\SymfonyRollbarBundle\Tests\Fixtures\PersonProvider',
                'root'                           => static::$kernel->getRootDir(),
                'scrub_fields'                   => Configuration::$scrubFieldsDefault,
                'shift_function'                 => true,
                'timeout'                        => 3,
                'report_suppressed'              => false,
                'use_error_reporting'            => false,
                'proxy'                          => null,
                'allow_exec'                     => true,
                'endpoint'                       => Configuration::API_ENDPOINT,
                'custom'                         => [],
                'exception_sample_rates'         => $exceptionRates,
                'fluent_host'                    => '127.0.0.1',
                'fluent_port'                    => 24224,
                'fluent_tag'                     => 'rollbar',
                'host'                           => null,
                'scrub_whitelist'                => null,
                'send_message_trace'             => false,
                'include_raw_request_body'       => false,
                'local_vars_dump'                => false,
            ],
            'rollbar_js' => [
                'accessToken'                => 'SOME_ROLLBAR_ACCESS_TOKEN_654321',
                'payload'                    => ['environment' => static::$kernel->getEnvironment()],
                'enabled'                    => true,
                'captureUncaught'            => true,
                'uncaughtErrorLevel'         => Configuration::JS_UNCAUGHT_LEVEL,
                'captureUnhandledRejections' => true,
                'ignoredMessages'            => [],
                'verbose'                    => false,
                'async'                      => true,
                'autoInstrument'             => Configuration::$autoInstrument,
                'itemsPerMinute'             => Configuration::JS_ITEMS_PER_MINUTE,
                'maxItems'                   => Configuration::JS_MAX_ITEMS,
                'scrubFields'                => Configuration::$scrubFieldsDefault,
            ],
        ];

        $this->assertNotEmpty($config);
        $this->assertEquals($default, $config);
    }

    public function testEmptyConfiguration()
    {
        static::bootKernel(['environment' => 'test_empty']);

        $container = static::$kernel->getContainer();
        $config    = $container->getParameter(SymfonyRollbarExtension::ALIAS . '.config');

        $this->assertArrayHasKey('enable', $config);
        $this->assertArrayHasKey('exclude', $config);
        $this->assertArrayHasKey('rollbar', $config);
    }
}
