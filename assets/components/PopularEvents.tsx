import { eventRoute, homeRoute } from '../Router';
import { Link } from '@tanstack/react-router';

export function PopularEvents() {
  const { events } = homeRoute.useLoaderData();

  if (!events) {
    return null;
  }

  return (
    <div className="grid grid-cols-3 gap-2">
      <h2 className="text-xl font-medium col-span-3">Popular events</h2>

      {events.map((event) => (
        <Link
          to={eventRoute.to}
          params={{ eventId: event.id }}
          key={event.id}
          className="block hover:opacity-90 transition-opacity relative aspect-video rounded-lg overflow-hidden shadow-lg"
        >
          <div className="absolute inset-x-0 bottom-0 p-2 z-10 bg-linear-to-t from-gray-950/80 to-gray-950/0">
            <h2 className="text-sm text-primary-foreground">{event.name}</h2>
          </div>
          <img
            className="object-cover h-full w-full"
            src={event.imageUrl}
            alt={`Image of ${event.name}`}
          />
        </Link>
      ))}
    </div>
  );
}
