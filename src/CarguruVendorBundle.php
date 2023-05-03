<?php

namespace Carguru\VendorBundle;

use Carguru\VendorBundle\DependencyInjection\VendorExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CarguruVendorBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new VendorExtension();
    }
}