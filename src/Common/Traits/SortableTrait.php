<?php

namespace Carguru\VendorBundle\Common\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait SortableTrait
{
    #[Gedmo\SortablePosition]
    #[ORM\Column(type: 'integer')]
    protected ?int $position = null;

    public function getPosition():?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}