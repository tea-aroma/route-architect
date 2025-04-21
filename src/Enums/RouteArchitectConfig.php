<?php

namespace TeaAroma\RouteArchitect\Enums;


/**
 * The enum contains all possible configurations of this package.
 */
enum RouteArchitectConfig: string
{
    case AUTO_SCAN = 'auto_scan';

    case URL_VARIABLE_TEMPLATE = 'url_variable_template';

    case URL_DELIMITER = 'url_delimiter';

    case URL_SEGMENT_DELIMITER = 'url_segment_delimiter';

    case ROUTE_NAME_DELIMITER = 'route_name_delimiter';

    case ACTION_DELIMITER = 'action_delimiter';

    /**
     * Gets the value from configurations.
     *
     * @return string
     */
    public function get_config(): string
    {
        return config('route-architect.' . $this->value);
    }
}
