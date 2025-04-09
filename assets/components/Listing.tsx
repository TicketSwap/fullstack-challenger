import { Layout } from './Layout';
import { listingRoute } from '../Router';
import React from 'react';

export function Listing() {
  const { eventImageUrl, eventName, sellingPrice } =
    listingRoute.useLoaderData();

  return (
    <Layout withSell>
      <img
        className="w-full rounded-lg"
        src={eventImageUrl}
        alt={`Image of ${eventName}`}
      />
      <h1 className="text-2xl">Ticket for {eventName}</h1>

      <form className="grid gap-2">
        <span>
          Price:{' '}
          {Intl.NumberFormat('en', {
            style: 'currency',
            currency: 'EUR',
          }).format(sellingPrice / 100)}
        </span>
        <button className="bg-primary text-foreground rounded-md px-4 py-2 cursor-pointer hover:bg-primary/70 transition">
          Buy now!
        </button>
      </form>
    </Layout>
  );
}
