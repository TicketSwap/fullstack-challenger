import { Logo } from './Logo';
import React from 'react';
import { sellEventRoute } from '../Router';
import { useNavigate } from '@tanstack/react-router';

export function Header({ withSell }: { withSell: boolean }) {
  const navigate = useNavigate();

  async function startSelling() {
    const response = await fetch('/api/sell/start', {
      method: 'post',
    });
    const data = await response.json();
    const { listingId } = data;

    await navigate({
      to: sellEventRoute.to,
      params: { listingId },
    });
  }

  return (
    <div className="flex gap-3 justify-between items-center">
      <Logo />

      {withSell && (
        <button
          className="bg-primary text-white rounded-md px-4 py-2 cursor-pointer hover:bg-primary/70 transition"
          onClick={startSelling}
        >
          Sell your ticket!
        </button>
      )}
    </div>
  );
}
