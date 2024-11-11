import ReactDOM from 'react-dom/client'
import './index.css'
import App from './App'
import { store } from './store/index'
import { Provider } from 'react-redux'

declare global {
  interface Window {
    path_url: any
  }
}

const root = ReactDOM.createRoot(document.getElementById('root'))

root.render(
  <>
    <Provider store={store}>
      <App />
    </Provider>
  </>
)
