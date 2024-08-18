<?php
namespace App\Enums;

enum AuthType: string
{
    case OAUTH = 'oauth';
    case CREDENTIALS = 'credentials';
}
