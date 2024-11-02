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
  const [headerTopView, setHeaderTopView] = useState([]);
  const [headerBottomView, setHeaderBottomView] = useState([]);

  const [contentLeftView, setContentLeftView] = useState([]);
  const [contentRightView, setContentRightView] = useState([]);

  const [footerTopView, setFooterTopView] = useState([]);
  const [footerBottomView, setFooterBottomView] = useState([]);

  useEffect(() => {
    async function LoadViews(component, position) {
      if (component && component !== undefined) {
        const componentPromises = component.map(async (data) => {
          const View = await importView(data.subreddit);
          return <View key={data.key} {...data.data} />;
        });

        switch(position) {
          case 'header_top':
            Promise.all(componentPromises).then(setHeaderTopView);
            break;
          case 'header_bottom':
            Promise.all(componentPromises).then(setHeaderBottomView);
            break;
          case 'content_left':
            Promise.all(componentPromises).then(setContentLeftView);
            break;
          case 'content_right':
            Promise.all(componentPromises).then(setContentRightView);
            break;
          case 'footer_top':
            console.log(component);
            Promise.all(componentPromises).then(setFooterTopView);
            break;
          case 'footer_bottom':
            console.log(component);
            Promise.all(componentPromises).then(setFooterBottomView);
            break;
        }
      } else {
        console.log(position + " is empty");
      }
    }

    LoadViews(header_top, "header_top");
    LoadViews(header_bottom, "header_bottom");
    
    LoadViews(content_left, "content_left");
    LoadViews(content_right, "content_right");

    LoadViews(footer_top, "footer_top");
    LoadViews(footer_bottom, "footer_bottom");

  }, [header_top, header_bottom, content_left, content_right, footer_top, footer_bottom]);

  return (
    <>
      <div className="body">
        {headerTopView && (
          <Suspense fallback={<LoadingHeader />}>{headerTopView}</Suspense>
        )}
        
        {headerBottomView && (
          <Suspense fallback={<LoadingHeader />}>{headerBottomView}</Suspense>
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
             
              {contentRightView && (
                <Col
                  as="aside"
                  xs={{ order: 2 }}
                  id="content_right"
                  className="d-none d-md-block col-3"
                >
                  <Suspense fallback={<LoadingHeader />}>{contentRightView}</Suspense>
                </Col>
              )}

            </Row>
          </Container>
        </div>

        {footerTopView && (
          <Suspense fallback={<LoadingHeader />}>{footerTopView}</Suspense>
        )}

        {footerBottomView && (
          <Suspense fallback={<LoadingHeader />}>{footerBottomView}</Suspense>
        )}
      </div>
    </>
  );
};

export default LayoutDefault;
