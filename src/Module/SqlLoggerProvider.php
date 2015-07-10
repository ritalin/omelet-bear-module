<?php

namespace Omelet\Module;

use Doctrine\DBAL\Driver\Connection;
use Ray\Di\ProviderInterface;
use Ray\Di\Di\Named;
use Psr\Log\LoggerInterface;

class SqlLoggerProvider implements ProviderInterface
{
    /**
     * @var Connection
     */
    private $conn;
    
    /**
     * @Named("conn=SqlLogger, logger=SqlLogger")
     */
    public function __construct(Connection $conn, LoggerInterface $logger = null)
    {
        $this->conn = $conn;
        
        if($logger !== null) {
            $this->conn->getConfiguration()->setSQLLogger(new SqlLoggerPsr3Adapter($logger));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->conn;
    }
}
