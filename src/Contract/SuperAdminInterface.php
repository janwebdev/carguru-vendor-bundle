<?php

namespace Carguru\VendorBundle\Contract;

interface SuperAdminInterface
{
    public const ROLE_ADMIN = "ROLE_ADMIN";

    public function isSuperAdmin(): bool;
}