import Dropdown from "react-bootstrap/Dropdown";
import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";

import Currency from "../Currency.jsx";
import Language from "../Language.jsx";
import MenuTop from "../Menu/Top.jsx";

const HeaderMain = (props) => {
  const linkAccount = (props) => {
    if (props.logged) {
      return (
        <>
          <Dropdown align="end">
            <Dropdown.Toggle
              as="a"
              className="nav-link dropdown-toggle"
              id="dropdown-account-top">
              <img
                src={props.customer_avatar}
                alt={props.customer_name}
                className="rounded-circle customer-avatar"
              />
              <span className="d-none d-md-inline ms-1">
                {props.customer_name}
              </span>
            </Dropdown.Toggle>

            <Dropdown.Menu>
              <Dropdown.Item href={props.account}>
                {props.text_account}
              </Dropdown.Item>
              <Dropdown.Item href={props.order}>
                {props.text_order}
              </Dropdown.Item>
              <Dropdown.Item href={props.transaction}>
                {props.text_transaction}
              </Dropdown.Item>
              <Dropdown.Divider />
              <Dropdown.Item href={props.logout}>
                {props.text_logout}
              </Dropdown.Item>
            </Dropdown.Menu>
          </Dropdown>
        </>
      );
    } else {
      return (
        <>
          <Dropdown align="end">
            <Dropdown.Toggle
              as="a"
              className="nav-link dropdown-toggle"
              id="dropdown-account-top">
              <i className="fas fa-user"></i>
              <span className="d-none d-md-inline ms-1">
                {props.text_my_account}
              </span>
            </Dropdown.Toggle>

            <Dropdown.Menu>
              <Dropdown.Item href={props.login}>
                {props.text_login}
              </Dropdown.Item>
              <Dropdown.Item href={props.register}>
                {props.text_register}
              </Dropdown.Item>
            </Dropdown.Menu>
          </Dropdown>
        </>
      );
    }
  };

  return (
    <>
      <Navbar className="bg-body-tertiary p-0">
        <Container>
          <Navbar.Toggle aria-controls="basic-navbar-nav" />
          <Navbar.Collapse id="basic-navbar-nav">
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

              {linkAccount(props)}

              <Language language={props.language} />
            </Nav>
          </Navbar.Collapse>
        </Container>
      </Navbar>
    </>
  );
};

export default HeaderMain;
