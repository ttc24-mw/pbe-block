import React from 'react';
import Header from '../components/Header';
import Navbar from '../components/Navbar';

export default function ImpressumPage (): React.JSX.Element {
  return (
    <>
      <Header />
      <Navbar />
      <main className='bg-blue-200 h-[400px] mt-4 p-4'>
        <p className='w-[70vw] mt-4'>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

        <div className="my-4">
          <strong>Lorem Ipsum</strong>
          <p>amet consetetur 17</p>
        </div>

        <p>55555 Sadipscing</p>
      </main>
    </>
  );
};