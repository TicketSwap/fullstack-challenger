import { Layout } from './Layout';
import { eventRoute, listingRoute } from '../Router';
import { Link } from '@tanstack/react-router';

export function Event() {
  const { name, imageUrl, listings } = eventRoute.useLoaderData();

  return (
    <Layout withSell>
      <img
        className="w-full rounded-lg"
        src={imageUrl}
        alt={`Image of ${name}`}
      />
      <h1 className="text-2xl">{name}</h1>

      {listings.length > 0 && (
        <div className="grid gap-2">
          <h2>Available tickets:</h2>

          {listings.map((listing) => (
            <Link
              key={listing.id}
              to={listingRoute.to}
              params={{ listingId: listing.id }}
              className="bg-gray-100 p-3 rounded-md hover:bg-gray-200 transition"
            >
              <span className="block text-sm">{listing.eventName}</span>
              Buy your ticket now for{' '}
              {Intl.NumberFormat('en', {
                style: 'currency',
                currency: 'EUR',
              }).format(listing.price / 100)}
            </Link>
          ))}
        </div>
      )}
    </Layout>
  );
}
