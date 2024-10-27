import { lazy, useEffect, useState } from "react";
import { Outlet, Link } from "react-router-dom";
import { Container, Row, Col } from "react-bootstrap";

const importView = (subreddit) =>
lazy(() =>
  import(`../${subreddit}`).catch(() =>
    import(`../Common/NullView`)
  )
);

const LayoutDefault = ({
  header_top,
  header_bottom,
  breadcumb,
  content_left,
  content_right,
  footer_top,
  footer_bottom,
}) => {

  const [headerTopViews, setHeaderTopViews] = useState([]);

  const extractData = response =>
    response.map(({ data }) => data);

  useEffect(() => {
    if (header_top) {
      async function loadViews() {
        // const header_top = await searchSubreddit(
        //   'react hooks'
        // ).then(extractData);
        
        const componentPromises = header_top.map(
          async (data) => {
            console.log(data);
            const View = await importView(data.subreddit);
            return (
              <View key={data.key} {...data} />
            );
          }
        );
        Promise.all(componentPromises).then(setHeaderTopViews);
      }
      
      loadViews();
      
    }

    
  }, [header_top]);

  return (
    <>
      <div className="body">
        {headerTopViews && headerTopViews}
        {header_bottom && header_bottom}
        <div role="main" className="main">
          {breadcumb && breadcumb}
          <Container fluid="xxl">
            <Row>
              <Col
                as="aside"
                xs={{ order: 0 }}
                id="content_left"
                className="d-none d-md-block col-3">
                <nav>
                  <ul>
                    <li>
                      <Link to="/">Home</Link>
                    </li>
                    <li>
                      <Link to="/about">About</Link>
                    </li>
                    <li>
                      <Link to="/contact">Contact</Link>
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
                  className="d-none d-md-block col-3">
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
