import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";

import Currency from "../Currency.tsx";
import Language from "../Language.tsx";
import MenuTop from "../Menu/Top.tsx";
import HeaderAccount from "./Account.tsx";

const HeaderMain = (props) => {
  return (
    <>
      <Navbar className="bg-body-tertiary p-0">
        <Container>
          <Navbar.Toggle aria-controls="header-main-navbar-nav" />
          <Navbar.Collapse id="header-main-navbar-nav">
            <Nav className="me-auto">
              <Currency currency={props.currency} />

              <MenuTop menuTop={props.menu_top} />

              <Nav.Link href={props.wishlist}>
                <i className="far fa-heart"></i>
                <span className="d-none d-md-inline ms-1">
                  {props.text_wishlist}
                </span>
                <span className="ms-1">(0)</span>
              </Nav.Link>
              <Nav.Link href={props.shopping_cart}>
                <i className="fas fa-shopping-cart"></i>
                <span className="d-none d-md-inline ms-1">
                  {props.text_shopping_cart}
                </span>
                <span className="ms-1">(0)</span>
              </Nav.Link>

              <HeaderAccount {...props} />

              <Language language={props.language} />
            </Nav>
          </Navbar.Collapse>
        </Container>
      </Navbar>
    </>
  );
};

export default HeaderMain;
