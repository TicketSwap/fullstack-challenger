import { ReactNode } from 'react';
import { Header } from './Header';
import { Footer } from './Footer';

export function Layout({
  children,
  withSell,
}: {
  children: ReactNode;
  withSell?: boolean;
}) {
  return (
    <main className="max-w-3xl mx-auto p-4 my-4 grid gap-5">
      <Header withSell={withSell} />

      {children}

      <Footer />
    </main>
  );
}
