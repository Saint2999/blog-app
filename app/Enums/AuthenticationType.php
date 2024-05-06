<?php

namespace app\Enums;

enum AuthenticationType: string
{
    case Login = 'login';
    case Register = 'register';
}