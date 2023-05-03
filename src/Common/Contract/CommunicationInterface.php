<?php

namespace Carguru\VendorBundle\Common\Contract;

interface CommunicationInterface
{
    public function getEmail(): string;
    public function getPhone(): ?string;
}