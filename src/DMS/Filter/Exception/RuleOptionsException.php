<?php
declare(strict_types=1);

namespace DMS\Filter\Exception;

/**
 * Base Exception for errors with rule options
 */
class RuleOptionsException extends FilterException
{
    /** @var string[] */
    private array $options;

    /**
     * Constructor
     *
     * @param string[] $options
     */
    public function __construct(string $message, array $options)
    {
        parent::__construct($message);

        $this->options = $options;
    }

    /**
     * Retrieve options that triggered exception
     *
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
