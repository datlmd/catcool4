import { Suspense, lazy, useEffect, useState } from 'react'
// import 'bootstrap/dist/css/bootstrap.min.css'
// import 'font-awesome/css/font-awesome.min.css'
// import 'bootstrap-icons/font/bootstrap-icons.css'

import { BrowserRouter, Routes, Route } from 'react-router-dom'
import LayoutDefault from './views/Layouts/Default'
import HomeView from './views/Frontend/Home'
import PageNotFound from './views/Frontend/NotFound'
import Loading from './components/Loading/Loading'
import { sanitizeJSONString } from './utils/String'

const LoginView = lazy(() => import('./views/Account/Login'))
const ContactView = lazy(() => import('./views/Frontend/Contact'))
const AboutView = lazy(() => import('./views/Frontend/About'))

import { ILayoutView } from 'src/store/types'

const baseUrl = window.base_url
const pathUrl = window.path_url

const intLayoutView = {
  header_top: null,
  header_bottom: null,
  column_left: null,
  column_right: null,
  content_top: null,
  content_bottom: null,
  footer_top: null,
  footer_bottom: null
}

const App = () => {
  const [pageData, setPageData] = useState([])
  const [layouts, setLayouts] = useState<ILayoutView>(intLayoutView)

  useEffect(() => {
    if (window.page_data && window.page_data !== undefined) {
      let data = JSON.parse(sanitizeJSONString(window.page_data))

      setPageData(data)

      if (data.layouts !== undefined) {
        setLayouts(data.layouts)
      }
    } else {
      console.log('window.page_data is empty!!!')
    }

    setPageData({
      ...pageData
      // tokenName: window.csrf_name,
      // tokenValue: window.csrf_value,
    })
  }, [])

  const callbackLayout = (data: any) => {
    setLayouts(data)
    console.log('parennn')
  }

  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path={pathUrl} element={<LayoutDefault {...layouts} />}>
            <Route index element={<HomeView />} />
            <Route
              path={pathUrl + 'about'}
              element={
                <Suspense fallback={<Loading />}>
                  <AboutView callbackLayout={callbackLayout} />
                </Suspense>
              }
            />
            <Route
              path={pathUrl + 'contact'}
              element={
                <Suspense fallback={<Loading />}>
                  <ContactView callbackLayout={callbackLayout} />
                </Suspense>
              }
            />
            <Route
              path={pathUrl + 'account/login'}
              element={
                <Suspense fallback={<Loading />}>
                  <LoginView {...pageData} callbackLayout={callbackLayout} />
                </Suspense>
              }
            />
            <Route path='*' element={<PageNotFound />} />
          </Route>
        </Routes>
      </BrowserRouter>
    </>
  )
}

export default App

// Thêm một khoảng thời gian trì hoãn để bạn có thể thấy được loading state
// function delayForDemo(promise) {
//   return new Promise((resolve) => {
//     setTimeout(resolve, 2000)
//   }).then(() => promise)
// }
