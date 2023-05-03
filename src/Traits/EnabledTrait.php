<?php

namespace Carguru\VendorBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EnabledTrait
{
    #[ORM\Column(name: 'is_enabled', type: 'boolean', options: ["default"=>"true"])]
    protected bool $enabled = true;

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled === true;
    }

	public function isDisabled(): bool
	{
		return $this->enabled === false;
	}

    public function enable(): self
    {
        $this->enabled = true;

        return $this;
    }

    public function disable() : self
    {
        $this->enabled = false;

        return $this;
    }
}