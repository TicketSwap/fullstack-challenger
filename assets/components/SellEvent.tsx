import { sellEventRoute, sellTicketRoute } from '../Router';
import { InputWithLabel } from './InputWithLabel';
import { useNavigate } from '@tanstack/react-router';
import { Layout } from './Layout';

export const SellEvent = function Index() {
  const navigate = useNavigate();
  const params = sellEventRoute.useParams();

  async function handleSubmit(event) {
    event.preventDefault();
    await navigate({
      to: sellTicketRoute.to,
      params,
    });
  }

  return (
    <Layout>
      <div>
        <h1 className="text-2xl">Sell your ticket</h1>
        <p className="text-gray-600">Search and select your event</p>
      </div>

      <form className="grid gap-2" onSubmit={handleSubmit}>
        <InputWithLabel
          type="search"
          name="event"
          id="event"
          placeholder="Search for event"
          label="Event"
        />

        <button className="bg-primary text-foreground rounded-md px-4 py-2 cursor-pointer hover:bg-primary/70 transition">
          Save and next
        </button>
      </form>
    </Layout>
  );
};
