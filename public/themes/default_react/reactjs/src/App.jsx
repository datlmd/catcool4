import { Suspense, lazy, useEffect, useState } from "react";
// import "bootstrap/dist/css/bootstrap.min.css";
// import "font-awesome/css/font-awesome.min.css";
// import "bootstrap-icons/font/bootstrap-icons.css";

import { BrowserRouter, Routes, Route } from "react-router-dom";
import LayoutDefault from "./pages/Layouts/Default.jsx";
import PageHome from "./pages/Frontend/Home.jsx";
import PageNotFound from "./pages/Frontend/NotFound.jsx";
import Loading from "./components/Loading/Loading.jsx";
import { sanitizeJSONString } from "./utils/String.js";

const PageContact = lazy(() => import("./pages/Frontend/Contact.jsx"));
const PageAbout = lazy(() => import("./pages/Frontend/About.jsx"));

const baseUrl = window.base_url;
const pathUrl = window.path_url;

const App = () => {
  const [pageData, setPageData] = useState([]);

  useEffect(() => {
    if (window.page_data && window.page_data !== undefined) {      
      setPageData(JSON.parse(sanitizeJSONString(window.page_data)));
    } else {
      console.log("window.page_data is empty!!!");
    }
  }, []);

  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path={pathUrl} element={<LayoutDefault {...pageData.layouts} />}>
            <Route index element={<PageHome />} />
            <Route
              path={pathUrl + "about"}
              element={
                <Suspense fallback={<Loading />}>
                  <PageAbout />
                </Suspense>
              }
            />
            <Route
              path={pathUrl + "contact"}
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
    </>
  );
};

export default App;

// Thêm một khoảng thời gian trì hoãn để bạn có thể thấy được loading state
function delayForDemo(promise) {
  return new Promise((resolve) => {
    setTimeout(resolve, 2000);
  }).then(() => promise);
}
