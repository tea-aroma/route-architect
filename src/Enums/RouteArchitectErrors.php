<?php

namespace TeaAroma\RouteArchitect\Enums;


/**
 * The enum contains all possible messages of errors.
 */
enum RouteArchitectErrors: string
{
    case METHOD_NOT_OVERIDE = 'The method \'%s\' is not overridden in nested classes of \'%s\' class.';

    case UNDEFINED_CLOSURE = 'Failed to get closure for method \'%s\'';

    case UNDEFINED_METHOD = 'The \'%s\' method is not defined in \'%s\' class.';

    /**
     * Formats the message of error.
     *
     * @param string ...$args
     *
     * @return string
     */
    public function format(string ...$args): string
    {
        return sprintf($this->value, ...$args);
    }
}
