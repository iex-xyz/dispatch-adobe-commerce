<?php

namespace Dispatch\SalesChannel\Api;

/**
 * Interface ConfigurationManagementInterface
 *
 * This interface defines methods for managing configuration in a SalesChannel.
 */
interface ConfigurationManagementInterface
{
    /**
     * Set configuration for the SalesChannel.
     *
     * @return array
     */
    public function setConfiguration(): array;

    /**
     * Get configuration for the SalesChannel.
     *
     * @return array
     */
    public function getConfiguration(): array;
}
