<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Money\Currency;
use Money\Money;

#[Entity]
class Listing
{
    #[Column(name: 'id', type: 'string')]
    #[Id]
    private string $id;

    #[JoinColumn(name: 'event_id', referencedColumnName: 'id', nullable: true)]
    #[ManyToOne(targetEntity: Event::class)]
    private ?Event $event;

    #[OneToMany(targetEntity: Ticket::class, mappedBy: 'listing', cascade: ['persist'], indexBy: 'id')]
    private Collection $tickets;

    #[Column(name: 'price', type: 'integer', nullable: true)]
    private ?int $price;

    #[Column(name: 'published', type: 'boolean')]
    private bool $published;
    
    public function __construct(string $id)
    {
        $this->id = $id;
        $this->event = null;
        $this->tickets = new ArrayCollection();
        $this->price = null;
        $this->published = false;
    }

    public function setEvent(Event $event) : void
    {
        $this->event = $event;
    }

    public function addTicket(Ticket $ticket) : void
    {
        $this->tickets->add($ticket);
    }

    public function setPrice(int $price) : void
    {
        $this->price = $price;
    }

    public function publish() : void
    {
        $this->published = true;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getEvent() : ?Event
    {
        return $this->event;
    }

    /**
     * @return list<Ticket>
     */
    public function getTickets() : array
    {
        return $this->tickets->toArray();
    }

    public function getPrice() : ?Money
    {
        if ($this->price === null) {
            return null;
        }

        return new Money($this->price, new Currency('EUR'));
    }

    public function isPublished() : bool
    {
        return $this->published;
    }
}
