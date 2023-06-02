<?php

namespace Carguru\VendorBundle\Domain\Clients;

use Doctrine\ORM\Mapping as ORM;
use Carguru\VendorBundle\Traits\EntityIdTrait;
use Carguru\VendorBundle\Traits\TimestampableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'client_driving_licence_images')]
class DrivingLicenceImage
{
    use EntityIdTrait, TimestampableTrait;

    #[ORM\ManyToOne(targetEntity: DrivingLicence::class, inversedBy: 'images')]
    #[ORM\JoinColumn(name: 'driving_licence_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private DrivingLicence $drivingLicence;

    #[ORM\Column(type: 'string', length: 255)]
    private string $fileName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $filePath;

    #[ORM\Column(type: 'integer')]
    private int $fileSize;

    #[ORM\Column(type: 'string', length: 5)]
    private string $side;

    public function getDrivingLicence(): DrivingLicence
    {
        return $this->drivingLicence;
    }

    public function setDrivingLicence(DrivingLicence $drivingLicence): void
    {
        $this->drivingLicence = $drivingLicence;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function setSide(int $side): void
    {
        $this->side = $side;
    }
}