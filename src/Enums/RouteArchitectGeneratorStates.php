<?php

namespace TeaAroma\RouteArchitect\Enums;


/**
 * The enum contains possible states of the 'RouteArchitectGenerator' class.
 */
enum RouteArchitectGeneratorStates: string
{
    case SUCCESS = '[%s] created successfully!';

    case ERROR = '[%s] created failed!';

    case DIRECTORY_CREATE_ERROR = 'Directory creation failed!';

    case FILE_EXIST = '[%s] already exists!';

    case FILE_CREATE_ERROR = 'File creation failed!';

    /**
     * Formats the message of state.
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
