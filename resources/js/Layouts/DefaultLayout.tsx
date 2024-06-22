import {PropsWithChildren} from 'react';
import {Toaster} from "react-hot-toast";

export default function DefaultLayout({ children }: PropsWithChildren) {
    return (
        <>
          {children}
          <Toaster position="bottom-right" toastOptions={{
            style: {
              background: 'rgba(54,54,54,.85)',
              color: '#fff',
              backdropFilter: 'blur(15px)'
            },
            duration: 5000
          }} />

        </>
    );
}
