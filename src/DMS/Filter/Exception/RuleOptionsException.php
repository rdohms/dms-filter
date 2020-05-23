<?php

namespace DMS\Filter\Exception;

/**
 * Base Exception for errors with rule options
 *
 * @package DMS
 * @subpackage Filter
 * @category Exception
 */
class RuleOptionsException extends FilterException
{
    /**
     * @var array
     */
    private array $options;

    /**
     * Constructor
     *
     * @param string $message
     * @param array $options
     */
    public function __construct($message, array $options)
    {
        parent::__construct($message);

        $this->options = $options;
    }

    /**
     * Retrieve options that triggered exception
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
