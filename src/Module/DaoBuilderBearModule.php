<?php

namespace Omelet\Module;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\DbalModule\DbalModule;

use Omelet\Builder\Configuration;
use Omelet\Builder\DaoBuilderContext;

class DaoBuilderBearModule extends AbstractModule {
    /**
     * @var Configuration
     */
    private $config;
    /**
     * @var array
     */
    private $interfaces;
    
    public function __construct(Configuration $config, array $interfaces)
    {
        $this->config = $config;
        $this->interfaces = $interfaces;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $context = new DaoBuilderContext($this->config);
        $this->bind(DaoBuilderContext::class)->toInstance($context);
        
        $this->install(new DbalModule($context->connectionString()));
        
        foreach ($this->interfaces as $intf) {
            $context->build($intf);

            $this->bind($intf)->to($context->getDaoClassName($intf))->in(Scope::SINGLETON);
        }
    }
}
