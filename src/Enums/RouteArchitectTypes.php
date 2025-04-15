<?php

namespace TeaAroma\RouteArchitect\Enums;


/**
 * The enum contains all possible types of the 'RouteArchitect' class.
 */
enum RouteArchitectTypes: string
{
    case GET = 'get';

    case POST = 'post';

    case PUT = 'put';

    case PATCH = 'patch';

    case DELETE = 'delete';

    case OPTIONS = 'options';
}
