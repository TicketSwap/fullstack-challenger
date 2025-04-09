<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Barcode;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Ticket
{
    #[Column(name: 'id', type: 'string')]
    #[Id]
    private string $id;

    #[JoinColumn(name: 'listing_id', referencedColumnName: 'id')]
    #[ManyToOne(targetEntity: Listing::class, inversedBy: 'tickets')]
    private Listing $listing;

    #[Column(name: 'barcode', type: 'string', length: 40)]
    private string $barcode;

    public function __construct(
        string $id,
        Listing $listing,
        Barcode $barcode,
    ) {
        $this->id = $id;
        $this->listing = $listing;
        $this->barcode = (string) $barcode;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getBarcode() : Barcode
    {
        return Barcode::fromString($this->barcode);
    }
}
