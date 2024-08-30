"use client";
import React, { useEffect } from 'react';
import Hammer from 'hammerjs';
import { useRouter } from 'next/navigation';

const SwipeHandler = ({ onSwipeLeft, onSwipeRight, children }) => {
  const router = useRouter();

  useEffect(() => {
    const mc = new Hammer.Manager(document.body);
    mc.add(new Hammer.Swipe({ direction: Hammer.DIRECTION_HORIZONTAL }));

    const handleSwipeLeft = () => {
      if (onSwipeLeft) onSwipeLeft();
    };

    const handleSwipeRight = () => {
      if (onSwipeRight) onSwipeRight();
    };

    mc.on('swipeleft', handleSwipeLeft);
    mc.on('swiperight', handleSwipeRight);

    return () => {
      mc.off('swipeleft', handleSwipeLeft);
      mc.off('swiperight', handleSwipeRight);
      mc.destroy();
    };
  }, [onSwipeLeft, onSwipeRight]);

  return <>{children}</>;
};

export default SwipeHandler;
