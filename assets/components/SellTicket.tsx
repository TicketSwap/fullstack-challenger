import React from 'react';
import { sellPriceRoute, sellTicketRoute } from '../Router';
import { InputWithLabel } from './InputWithLabel';
import { useNavigate } from '@tanstack/react-router';
import { Layout } from './Layout';

export const SellTicket = function Index() {
  const navigate = useNavigate();
  const params = sellTicketRoute.useParams();

  async function handleSubmit(event) {
    event.preventDefault();

    await navigate({
      to: sellPriceRoute.to,
      params,
    });
  }

  return (
    <Layout>
      <div>
        <h1 className="text-2xl">Sell your ticket</h1>
        <p className="text-gray-600">Fill in your ticket barcode</p>
      </div>

      <form className="grid gap-2" onSubmit={handleSubmit}>
        <InputWithLabel
          type="text"
          name="barcode"
          id="barcode"
          placeholder="Barcode"
          label="Ticket"
        />

        <button className="bg-primary text-foreground rounded-md px-4 py-2 cursor-pointer hover:bg-primary/70 transition">
          Save and next
        </button>
      </form>
    </Layout>
  );
};
