import React from 'react';
import { PopularEvents } from './PopularEvents';
import { Layout } from './Layout';

export const Home = function Index() {
  return (
    <Layout withSell>
      <div>
        <h1 className="text-2xl">Welcome to the full-stack challenger! 🚀</h1>
        <p className="text-gray-500">
          More than 15,200,000 happy fans from 42 different countries!
        </p>
      </div>

      <PopularEvents />
    </Layout>
  );
};
