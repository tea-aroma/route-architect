<?php

namespace TeaAroma\RouteArchitect\Enums;


/**
 * The enum contains all possible modes for the group name of sequences.
 */
enum RouteArchitectSequencesGroupNameModes: string
{
    case ONLY_BASE = 'only_base';

    case EVERY_GROUP = 'every_group';
}
