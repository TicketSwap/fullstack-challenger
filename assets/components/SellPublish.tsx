import React from 'react';
import { sellPublishRoute } from '../Router';
import { Layout } from './Layout';

export const SellPublish = function Index() {
  const data = sellPublishRoute.useLoaderData();

  return (
    <Layout>
      <div>
        <h1 className="text-2xl">Sell your ticket</h1>
        <p className="text-gray-600">Ready to publish?</p>
      </div>

      <div>
        <h3 className="font-bold">Event:</h3>
        <p>{data.eventName}</p>
        <h3 className="font-bold">Ticket:</h3>
        <p>Barcode: {data.tickets[0]?.barcode}</p>
        <h3 className="font-bold">Price:</h3>
        <p>€ {data.sellingPrice / 100}</p>
      </div>

      <button className="bg-primary text-foreground rounded-md px-4 py-2 cursor-pointer hover:bg-primary/70 transition">
        Publish!
      </button>
    </Layout>
  );
};
