<?php

namespace Carguru\VendorBundle\Contract;

interface CommunicationInterface
{
    public function getEmail(): string;
    public function getPhone(): ?string;
}