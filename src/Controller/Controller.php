<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Listing;
use App\Entity\Ticket;
use App\Model\Barcode;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class Controller extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', name: 'home', methods: ['GET'])]
    #[Route('/sell/{id}/event', name: 'sell-event', methods: ['GET'])]
    #[Route('/sell/{id}/ticket', name: 'sell-ticket', methods: ['GET'])]
    #[Route('/sell/{id}/price', name: 'sell-price', methods: ['GET'])]
    #[Route('/sell/{id}/publish', name: 'sell-publish', methods: ['GET'])]
    #[Route('/listing/{id}', name: 'listing', methods: ['GET'])]
    #[Route('/event/{id}', name: 'event', methods: ['GET'])]
    public function getHomeAction(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/api/events', name: 'get-events', methods: ['GET'])]
    public function getEventsAction(): Response
    {
        $events = $this->entityManager->getRepository(Event::class)->findBy([], [], 3);

        return new JsonResponse(
            [
                'events' => array_map(
                    fn(Event $event) => [
                        'id' => $event->getId(),
                        'name' => $event->getName(),
                        'imageUrl' => $event->getImageUrl(),
                    ],
                    $events
                ),
            ],
            200,
        );
    }

    #[Route('/api/event/{eventId}', name: 'get-event', methods: ['GET'])]
    public function getEventAction(string $eventId): Response
    {
        $event = $this->entityManager->find(Event::class, $eventId);
        $listings = $this->entityManager->getRepository(Listing::class)->findBy([
            'event' => $eventId,
        ]);

        return new JsonResponse(
            [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'imageUrl' => $event->getImageUrl(),
                'listings' => array_map(
                    fn(Listing $listing) => [
                        'id' => $listing->getId(),
                        'price' => $listing->getPrice()?->getAmount(),
                        'eventName' => $listing->getEvent()->getName(),
                    ],
                    $listings
                ),
            ],
            200,
        );
    }

    #[Route('/api/sell/{listingId}', name: 'get-listing', methods: ['GET'])]
    public function getListingAction(string $listingId): Response
    {
        $listing = $this->entityManager->find(Listing::class, $listingId);

        return new JsonResponse(
            [
                'listingId' => $listing->getId(),
                'eventId' => $listing->getEvent()?->getId(),
                'eventName' => $listing->getEvent()?->getName(),
                'eventImageUrl' => $listing->getEvent()?->getImageUrl(),
                'sellingPrice' => $listing->getPrice()?->getAmount(),
                'faceValueTicketPrice' => $listing->getEvent()?->getFaceValueTicketPrice()->getAmount(),
                'tickets' => array_map(
                    fn(Ticket $ticket) => [
                        'id' => $ticket->getId(),
                        'barcode' => (string) $ticket->getBarcode(),
                    ],
                    $listing->getTickets()
                ),
                'isPublished' => $listing->isPublished(),
            ],
            200,
        );
    }

    #[Route('/api/sell/start', name: 'start-listing', methods: ['POST'])]
    public function startAction(): Response
    {
        $listing = new Listing(
            Uuid::uuid4()->toString(),
        );

        $this->entityManager->persist($listing);
        $this->entityManager->flush();

        return new JsonResponse(
            [
                'listingId' => $listing->getId(),
            ],
            200,
        );
    }

    #[Route('/api/sell/{listingId}/choose-event', name: 'choose-event', methods: ['POST'])]
    public function chooseEventAction(string $listingId, Request $request): Response
    {
        $requestBody = json_decode($request->getContent(), true);

        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->find($listingId);

        $event = $this->entityManager
            ->getRepository(Event::class)
            ->find($requestBody['eventId']);

        $listing->setEvent($event);

        $this->entityManager->persist($listing);
        $this->entityManager->flush();

        return new JsonResponse(null, 200);
    }

    #[Route('/api/sell/{listingId}/add-ticket', name: 'add-ticket', methods: ['POST'])]
    public function addTicketAction(string $listingId, Request $request): Response
    {
        $requestBody = json_decode($request->getContent(), true);

        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->find($listingId);

        $listing->addTicket(
            new Ticket(
                Uuid::uuid4()->toString(),
                $listing,
                new Barcode('QR-Code', $requestBody['barcode']),
            )
        );

        $this->entityManager->persist($listing);
        $this->entityManager->flush();

        return new JsonResponse(null, 200);
    }

    #[Route('/api/sell/{listingId}/price', name: 'set-price', methods: ['POST'])]
    public function setPrice(string $listingId, Request $request): Response
    {
        $requestBody = json_decode($request->getContent(), true);

        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->find($listingId);

        $listing->setPrice($requestBody['price']);

        $this->entityManager->persist($listing);
        $this->entityManager->flush();

        return new JsonResponse(null, 200);
    }

    #[Route('/api/sell/{listingId}/publish', name: 'publish', methods: ['POST'])]
    public function publish(string $listingId): Response
    {
        $listing = $this->entityManager
            ->getRepository(Listing::class)
            ->find($listingId);

        $listing->publish();

        $this->entityManager->persist($listing);
        $this->entityManager->flush();

        return new JsonResponse(null, 200);
    }
}