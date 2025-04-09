<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Money\Money;

#[Entity]
class Event
{
    #[Column(name: 'id', type: 'string')]
    #[Id]
    private string $id;

    #[Column(name: 'name')]
    private string $name;

    #[Column(name: 'face_value_ticket_price', type: 'integer')]
    private int $faceValueTicketPrice;

    #[Column(name: 'image_url', type: 'string')]
    private string $imageUrl;

    public function __construct(
        string $id,
        string $name,
        int $faceValueTicketPrice,
        string $imageUrl,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->faceValueTicketPrice = $faceValueTicketPrice;
        $this->imageUrl = $imageUrl;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getFaceValueTicketPrice() : Money
    {
        return Money::EUR($this->faceValueTicketPrice);
    }

    public function getImageUrl() : string
    {
        return $this->imageUrl;
    }
}