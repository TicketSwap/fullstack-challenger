# Fullstack Challenger

Howdy and welcome to the TicketSwap fullstack challenger! 💫

In this repository you will find a small web app that allows users to browse music events, and to create listings for those events. It is built with Symfony and React, and uses SQLite as a database.

Most of the code is already written, but some things need to be finished, fixed, and improved. This is where you step in!

## Setup

### Prerequisites

- Have PHP 8.2 or higher installed
- Have Composer installed
- Have the Symfony CLI installed
- Have Node 20+ or higher installed

### Run the backend

- `composer install`
- `symfony server:start`
- `php bin/console doctrine:database:create`
- `php bin/console doctrine:schema:update --force`

To insert event data, run `php bin/console app:fixtures`
If you need to clear the database, `php bin/console doctrine:database:drop --force`.

### Run the frontend

- `npm install`
- `npm run watch`

Your can view the web app on `localhost:8000`.

## Your work 

Here are the product requirements for this mini web app:

- Users can access event pages from the homepage.
- Users can access published listings from event pages.
- Users can create listings, which means:
  - They can search for and select an event
  - They can add one or more tickets
    - Adding a ticket is done by manually entering a barcode value
    - However, if the barcode already exists on our platform for this event, it cannot be added
    - Only QR-Codes are supported in this mini version
  - They can choose their selling price
    - However, the price should not be more than 20% above face value for the selected event
    - Only prices in euros are supported in this mini version
  - Finally, they can publish their listing.

What we expect from you:
- The above requirements should be met.
- Attention should be given to the user experience, to make it intuitive and complete, including error states.
- Last but not least, both the backend and frontend code should meet the quality standards you deem necessary for it to be deployed to thousands of users, and easily maintained by a team of colleagues 😄

## Handing in the assessment

When you are done and all your work is commited, zip your assessment (.git folder included) and send it to us in reply to the email you got with this assessment, via a file sharing service like WeTransfer.

If you have any questions, please reach out at angele@ticketswap.com and rob@ticketswap.com (please cc us both).

Good luck! 🚀
