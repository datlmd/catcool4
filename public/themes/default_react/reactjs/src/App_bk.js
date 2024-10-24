
import { lazy } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import LayoutDefault from "./pages/Layouts/Default";
import PageAbout from "./pages/Frontend/About";
import PageHome from "./pages/Frontend/Home";
import PageContact from "./pages/Frontend/Contact";
import PageNotFound from "./pages/Frontend/NotFound";

function AppBK() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<LayoutDefault />}>
          <Route index element={<PageHome />} />
          <Route path="about" element={<PageAbout />} />
          <Route path="contact" element={<PageContact />} />
          <Route path="*" element={<PageNotFound />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default AppBK;
