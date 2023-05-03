<?php

namespace Carguru\VendorBundle\Common\Contract;

interface SuperAdminInterface
{
    public const ROLE_ADMIN = "ROLE_ADMIN";

    public function isSuperAdmin(): bool;
}