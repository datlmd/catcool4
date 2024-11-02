import { lazy, useEffect, useState, Suspense } from "react";
import { Outlet, Link } from "react-router-dom";
import { Container, Row, Col } from "react-bootstrap";
import LoadingHeader from "../../components/Loading/Header.jsx";

const importView = (subreddit) =>
  lazy(() =>
    import(`../${subreddit}.jsx`).catch(() => import(`../Common/NullView.jsx`))
  );

const LayoutDefault = ({
  header_top,
  header_bottom,
  column_left,
  column_right,
  content_top,
  content_bottom,
  footer_top,
  footer_bottom,
}) => {
  const [headerTopView, setHeaderTopView] = useState([]);
  const [headerBottomView, setHeaderBottomView] = useState([]);
  const [columnLeftView, setColumnLeftView] = useState([]);
  const [columnRightView, setColumnRightView] = useState([]);
  const [contentTopView, setContentTopView] = useState([]);
  const [contentBottomView, setContentBottomView] = useState([]);
  const [footerTopView, setFooterTopView] = useState([]);
  const [footerBottomView, setFooterBottomView] = useState([]);

  useEffect(() => {
    async function LoadViews(component, position) {
      if (Array.isArray(component) && component !== undefined) {
        
        const componentPromises = component.map(async (data) => {
          const View = await importView(data.subreddit);
          return <View key={data.key} {...data.data} />;
        });

        switch (position) {
          case "header_top":
            Promise.all(componentPromises).then(setHeaderTopView);
            break;
          case "header_bottom":
            Promise.all(componentPromises).then(setHeaderBottomView);
            break;
          case "column_left":
            Promise.all(componentPromises).then(setColumnLeftView);
            break;
          case "column_right":
            Promise.all(componentPromises).then(setColumnRightView);
            break;
          case "content_top":
            Promise.all(componentPromises).then(setContentTopView);
            break;
          case "content_bottom":
            Promise.all(componentPromises).then(setContentBottomView);
            break;
          case "footer_top":
            Promise.all(componentPromises).then(setFooterTopView);
            break;
          case "footer_bottom":
            Promise.all(componentPromises).then(setFooterBottomView);
            break;
        }
      }
      // else {
      //   console.log(position + " is empty");
      // }
    }

    LoadViews(header_top, "header_top");
    LoadViews(header_bottom, "header_bottom");
    LoadViews(column_left, "column_left");
    LoadViews(column_right, "column_right");
    LoadViews(content_top, "content_top");
    LoadViews(content_bottom, "content_bottom");
    LoadViews(footer_top, "footer_top");
    LoadViews(footer_bottom, "footer_bottom");
  }, [
    header_top,
    header_bottom,
    column_left,
    column_right,
    content_top,
    content_bottom,
    footer_top,
    footer_bottom,
  ]);

  return (
    <>
      <div className="body">
        {headerTopView.length > 0 && (
          <Suspense fallback={<LoadingHeader />}>{headerTopView}</Suspense>
        )}

        {headerBottomView.length > 0 && (
          <Suspense fallback={<LoadingHeader />}>{headerBottomView}</Suspense>
        )}

        <div role="main" className="main">
          <Container fluid="xxl">
            <Row>
              {columnLeftView.length > 0 && (
                <Col
                  as="aside"
                  id="column_left"
                  className="d-none d-md-block col-3"
                >
                  <Suspense fallback={<LoadingHeader />}>
                    {columnLeftView}
                  </Suspense>
                </Col>
              )}
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
              <Col id="content">
                {contentTopView.length > 0 && (
                  <Suspense fallback={<LoadingHeader />}>
                    {contentTopView}
                  </Suspense>
                )}

                <Outlet />

                {contentBottomView.length > 0 && (
                  <Suspense fallback={<LoadingHeader />}>
                    {contentBottomView}
                  </Suspense>
                )}
              </Col>

              {columnRightView.length > 0 && (
                <Col
                  as="aside"
                  id="column_right"
                  className="d-none d-md-block col-3"
                >
                  <Suspense fallback={<LoadingHeader />}>
                    {columnRightView}
                  </Suspense>
                </Col>
              )}
            </Row>
          </Container>
        </div>

        {footerTopView.length > 0 && (
          <Suspense fallback={<LoadingHeader />}>{footerTopView}</Suspense>
        )}

        {footerBottomView.length > 0&& (
          <Suspense fallback={<LoadingHeader />}>{footerBottomView}</Suspense>
        )}
      </div>
    </>
  );
};

export default LayoutDefault;
