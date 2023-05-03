<?php

namespace Carguru\VendorBundle\Common\Traits;

trait ModelArrayHydratorTrait
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $array): self
    {
        $self = new self();
        foreach ($array as $key => $value) {
            $setter = (method_exists($self, 'set'.ucfirst($key))) ? 'set'.ucfirst($key) : false;
            if($setter) {
                $self->$setter($value);
            }
        }
        return $self;
    }
}