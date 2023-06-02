<?php

namespace Carguru\VendorBundle\Domain\Clients;

use Doctrine\ORM\Mapping as ORM;
use Carguru\VendorBundle\Traits\EntityIdTrait;
use Carguru\VendorBundle\Traits\TimestampableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'client_selfies')]
class Picture
{
    use EntityIdTrait, TimestampableTrait;

    #[ORM\OneToOne(inversedBy: 'picture', targetEntity: Client::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Client $client;

    #[ORM\Column(type: 'string', length: 255)]
    private string $fileName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $filePath;

    #[ORM\Column(type: 'integer')]
    private int $fileSize;

    #[ORM\Column(name: 'is_approved', type: 'boolean', options: ["default"=>"false"])]
    private bool $isApproved = false;

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
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

    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): void
    {
        $this->isApproved = $isApproved;
    }
}