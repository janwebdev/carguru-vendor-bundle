<?php

namespace Carguru\VendorBundle\Model;

final class ClientStatus
{
    public const STATUS_REGISTRATION   = 1;
    public const STATUS_NEW            = 2;
    public const STATUS_REGULAR        = 3;
    public const STATUS_REJECTED       = 4;
    public const STATUS_BLOCKED        = 5;
    public const STATUS_APPROVE_NEEDED = 6;
}