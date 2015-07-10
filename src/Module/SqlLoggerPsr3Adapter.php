<?php

namespace Omelet\Module;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;

class SqlLoggerPsr3Adapter implements SQLLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $p = $params !== null ? sprintf('[%s]', implode(', ', $params)) : 'none)';
        $this->logger->debug("Query started :\n(sql) => \n{$sql}\n(parameters) => \n{$p}\n");
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        $this->logger->debug('Query stopped');
    }
}
