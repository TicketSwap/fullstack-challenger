<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Event;
use App\Entity\Listing;
use App\Entity\Ticket;
use App\Model\Barcode;
use Doctrine\ORM\EntityManagerInterface;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fixtures',
    description: 'Inserts events and listings in the database'
)]
final class CreateFixturesCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Creating events and listings');

        $events = [
            new Event(
                Uuid::uuid4()->toString(),
                'Lowlands',
                30000,
                'https://cdn.ticketswap.com/public/202003/lowlands-festival-2020-biddinghuizen-21-august-2020.image.jpeg'
            ),
            new Event(
                Uuid::uuid4()->toString(),
                'Defqon.1',
                25000,
                'https://cdn.ticketswap.com/public/201912/8e0e134a-bdd0-49ef-8274-92e4d8b14c7a.jpeg'
            ),
            new Event(
                Uuid::uuid4()->toString(),
                'Tomorrowland',
                35000,
                'https://cdn.ticketswap.com/public/201911/harry-styles-ziggo-dome-06-may-2020.image.jpeg'
            ),
            new Event(
                Uuid::uuid4()->toString(),
                'Mysteryland',
                20000,
                'https://cdn.ticketswap.com/public/202003/2fefb873-c8b3-452c-a34c-6d81f24f9a0e.jpeg'
            ),
            new Event(
                Uuid::uuid4()->toString(),
                'Thunderdome',
                15000,
                'https://cdn.ticketswap.com/static/images/placeholders/festival-4.jpg'
            ),
        ];

        foreach ($events as $event) {
            $this->entityManager->persist($event);

            $io->text(sprintf('Created event: %s (%s)', $event->getId(), $event->getName()));

            $listing = new Listing(Uuid::uuid4()->toString());
            $listing->setEvent($event);
            $listing->addTicket(
                new Ticket(
                    Uuid::uuid4()->toString(),
                    $listing,
                    new Barcode('QR-Code', (string) rand(0000000000000, 9999999999999)),                )
            );
            $listing->addTicket(
                new Ticket(
                    Uuid::uuid4()->toString(),
                    $listing,
                    new Barcode('QR-Code', (string) rand(0000000000000, 9999999999999)),
                ),
            );
            $listing->setPrice((int) $event->getFaceValueTicketPrice()->getAmount());
            $listing->publish();

            $this->entityManager->persist($listing);
            $this->entityManager->flush();

            $io->text(sprintf('Created listing: %s', $listing->getId()));
        }

        $io->success('Successfully created 5 events');
        $io->success('Successfully created 5 listings');

        return Command::SUCCESS;
    }
}