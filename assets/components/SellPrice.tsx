import React from 'react';
import { sellPriceRoute, sellPublishRoute } from '../Router';
import { InputWithLabel } from './InputWithLabel';
import { useNavigate } from '@tanstack/react-router';
import { Layout } from './Layout';

export const SellPrice = function Index() {
  const navigate = useNavigate();
  const params = sellPriceRoute.useParams();

  async function handleSubmit(event) {
    event.preventDefault();
    await navigate({
      to: sellPublishRoute.to,
      params,
    });
  }

  return (
    <Layout>
      <div>
        <h1 className="text-2xl">Sell your ticket</h1>
        <p className="text-gray-600">Fill in your price</p>
      </div>

      <form className="grid gap-2" onSubmit={handleSubmit}>
        <InputWithLabel
          type="number"
          name="price"
          id="price"
          placeholder="Fill in your price in euro"
          label="Ticket price"
        />

        <button className="bg-primary text-foreground rounded-md px-4 py-2 cursor-pointer hover:bg-primary/70 transition">
          Save and next
        </button>
      </form>
    </Layout>
  );
};
