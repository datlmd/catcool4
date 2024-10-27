import { Suspense, lazy, useEffect, useState } from "react";
// import "bootstrap/dist/css/bootstrap.min.css";
// import "font-awesome/css/font-awesome.min.css";
// import "bootstrap-icons/font/bootstrap-icons.css";

import { BrowserRouter, Routes, Route } from "react-router-dom";
import LayoutDefault from "./pages/Layouts/Default";
import PageHome from "./pages/Frontend/Home";
import PageNotFound from "./pages/Frontend/NotFound";
import Loading from "./components/UI/Loading";

const PageContact = lazy(() => import("./pages/Frontend/Contact"));
const PageAbout = lazy(() => import("./pages/Frontend/About"));

const BASE_URL = window.base_url;

//const [pageData, setPageData] = useState([]);

const App = () => {
  //const DATA = JSON.parse(window.page_data);
  const [pageData, setPageData] = useState([]);
  useEffect(() => {
    
    if (JSON.parse(window.page_data)) {
      setPageData(JSON.parse(window.page_data).template);
    }
  }, []);

  return (
    <BrowserRouter>
      <Routes>
        <Route
          path="/"
          element={<LayoutDefault {...pageData} />}>
          <Route index element={<PageHome />} />
          <Route
            path="about"
            element={
              <Suspense fallback={<Loading />}>
                <PageAbout />
              </Suspense>
            }
          />
          <Route
            path="contact"
            element={
              <Suspense fallback={<Loading />}>
                <PageContact />
              </Suspense>
            }
          />
          <Route path="*" element={<PageNotFound />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
};

export default App;

// Thêm một khoảng thời gian trì hoãn để bạn có thể thấy được loading state
function delayForDemo(promise) {
  return new Promise((resolve) => {
    setTimeout(resolve, 2000);
  }).then(() => promise);
}
