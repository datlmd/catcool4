import { Outlet, Link } from "react-router-dom";

import { Container, Row, Col } from "react-bootstrap";

const Header = (props) => {
  return (
    <>
      <div className="body">
        header df
        {props.data.login}
      </div>
    </>
  );
};

export default Header;
