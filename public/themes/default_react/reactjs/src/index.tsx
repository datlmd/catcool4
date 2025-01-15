import './bootstrap'
import { createRoot } from 'react-dom/client'
import { createInertiaApp } from '@inertiajs/react' // Inertia.js for React

//const root = ReactDOM.createRoot(document.getElementById('app'))

// root.render(
//     <InertiaApp
//         initialPage={JSON.parse(document.getElementById('app').dataset.page)} // Passing page data from server
//         resolveComponent={(name) => import(`./Pages/${name}.tsx`).then((module) => module.default)} // Dynamic import for React components
//     />
// )

createInertiaApp({
    //title: (title) => `${title} - ${appName}`,
    resolve: (name) => import(`./Pages/${name}.tsx`).then((module) => module.default),
    setup({ el, App, props }) {
        //const root = createRoot(el);
        //const root = ReactDOM.createRoot(el)
        createRoot(el).render(<App {...props} />)
    },
    progress: {
        color: '#4B5563'
    }
})
