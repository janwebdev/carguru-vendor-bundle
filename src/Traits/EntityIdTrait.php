<?php
namespace Carguru\VendorBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EntityIdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
	private int $id;

	public function getId(): int
	{
		return $this->id;
	}
}