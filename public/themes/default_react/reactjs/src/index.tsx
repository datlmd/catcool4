import React from 'react'
import ReactDOM from 'react-dom/client'
import { InertiaApp } from '@inertiajs/inertia-react' // Inertia.js for React

const app = document.getElementById('app') // The div with id 'app' in your view

const root = ReactDOM.createRoot(document.getElementById('app'))

root.render(
    <InertiaApp
        initialPage={JSON.parse(document.getElementById('app').dataset.page)} // Passing page data from server
        resolveComponent={(name) => import(`./Pages/${name}.tsx`).then((module) => module.default)} // Dynamic import for React components
    />
)

// createInertiaApp({
//   title: (title) => `${title} - ${appName}`,
//   resolve: (name) =>
//     resolveComponent(
//           `./Pages/${name}.tsx`,
//           import.meta.glob('./Pages/**/*.tsx'),
//       ),
//   setup({ el, App, props }) {
//       //const root = createRoot(el);
//       const root = ReactDOM.createRoot(document.getElementById('app'))

//       root.render(<App {...props} />);
//   },
//   progress: {
//       color: '#4B5563',
//   },
// });
