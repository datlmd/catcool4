import { lazy, useEffect, useState, Suspense } from "react";
import { Outlet, Link } from "react-router-dom";
import { Container, Row, Col } from "react-bootstrap";
import LoadingHeader from "../../components/Loading/Header.jsx";
//import Breadcrumb from "../Common/Breadcrumb.jsx";

const importView = (subreddit) =>
  lazy(() =>
    import(`../${subreddit}.jsx`).catch(() => import(`../Common/NullView.jsx`))
  );

const LayoutDefault = ({
  header_top,
  header_bottom,
  content_left,
  content_right,
  content_top,
  content_bottom,
  footer_top,
  footer_bottom,
}) => {
  const [headerTopViews, setHeaderTopViews] = useState([]);
  const [headerBottomViews, setHeaderBottomViews] = useState([]);

  useEffect(() => {
    async function LoadViews(component, position) {
      const componentPromises = component.map(async (data) => {
        const View = await importView(data.subreddit);
        return <View key={data.key} {...data.data} />;
      });

      if (position == "header_top") {
        Promise.all(componentPromises).then(setHeaderTopViews);
      } else if (position == "header_bottom") {
        Promise.all(componentPromises).then(setHeaderBottomViews);
      }
    }

    if (header_top && header_top !== undefined) {
      LoadViews(header_top, "header_top");
    } else {
      console.log("header_top is empty");
    }

    if (header_bottom && header_bottom !== undefined) {
      LoadViews(header_bottom, "header_bottom");
    } else {
      console.log("header_bottom is empty");
    }
  }, [header_top, header_bottom]);

  return (
    <>
      <div className="body">
        {headerTopViews && (
          <Suspense fallback={<LoadingHeader />}>{headerTopViews}</Suspense>
        )}
        
        {headerBottomViews && (
          <Suspense fallback={<LoadingHeader />}>{headerBottomViews}</Suspense>
        )}
      
        <div role="main" className="main">
          
          <Container fluid="xxl">
            <Row>
              <Col
                as="aside"
                xs={{ order: 0 }}
                id="content_left"
                className="d-none d-md-block col-3"
              >
                <nav>
                  <ul>
                    <li>
                      <Link to="/dev/catcool4/public/">Home</Link>
                    </li>
                    <li>
                      <Link to="/dev/catcool4/public/about">About</Link>
                    </li>
                    <li>
                      <Link to="https://localhost:8443/dev/catcool4/public/contact">
                        Contact
                      </Link>
                    </li>
                  </ul>
                </nav>
              </Col>
              <Col xs={{ order: 1 }}>
                <Outlet />
              </Col>
              {content_right && (
                <Col
                  as="aside"
                  xs={{ order: 2 }}
                  id="content_right"
                  className="d-none d-md-block col-3"
                >
                  {content_right}
                </Col>
              )}
            </Row>
          </Container>
        </div>
        {footer_top && footer_top}
        {footer_bottom && footer_bottom}
      </div>
    </>
  );
};

export default LayoutDefault;
