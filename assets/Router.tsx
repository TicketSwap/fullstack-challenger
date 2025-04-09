import {
  createRootRoute,
  createRoute,
  createRouter,
} from '@tanstack/react-router';
import { Home } from './components/Home';
import { SellEvent } from './components/SellEvent';
import { Event } from './components/Event';
import { SellTicket } from './components/SellTicket';
import { SellPrice } from './components/SellPrice';
import { SellPublish } from './components/SellPublish';
import { Listing } from './components/Listing';

const rootRoute = createRootRoute();

const getEvents = async () => {
  const response = await fetch('/api/events');

  return await response.json();
};

const getEvent = async ({ params }) => {
  const response = await fetch(`/api/event/${params.eventId}`);

  return await response.json();
};

const getListing = async ({ params }) => {
  const response = await fetch(`/api/sell/${params.listingId}`);

  return await response.json();
};

export const homeRoute = createRoute({
  getParentRoute: () => rootRoute,
  path: '/',
  loader: getEvents,
  component: Home,
});

export const sellEventRoute = createRoute({
  getParentRoute: () => rootRoute,
  path: '/sell/$listingId/event',
  loader: getListing,
  component: SellEvent,
});

export const sellTicketRoute = createRoute({
  getParentRoute: () => rootRoute,
  path: '/sell/$listingId/ticket',
  loader: getListing,
  component: SellTicket,
});

export const sellPriceRoute = createRoute({
  getParentRoute: () => rootRoute,
  path: '/sell/$listingId/price',
  loader: getListing,
  component: SellPrice,
});

export const sellPublishRoute = createRoute({
  getParentRoute: () => rootRoute,
  path: '/sell/$listingId/publish',
  loader: getListing,
  component: SellPublish,
});

export const listingRoute = createRoute({
  getParentRoute: () => rootRoute,
  path: '/listing/$listingId',
  loader: getListing,
  component: Listing,
});

export const eventRoute = createRoute({
  getParentRoute: () => rootRoute,
  path: '/event/$eventId',
  loader: getEvent,
  component: Event,
});

const routeTree = rootRoute.addChildren([
  homeRoute,
  sellEventRoute,
  sellTicketRoute,
  sellPriceRoute,
  sellPublishRoute,
  listingRoute,
  eventRoute,
]);

export const router = createRouter({ routeTree });
