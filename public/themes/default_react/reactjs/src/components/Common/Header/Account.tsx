import Dropdown from "react-bootstrap/Dropdown";

const HeaderAccount = (props) => {
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
            <span className="d-none d-lg-inline ms-1">
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
            <span className="d-none d-lg-inline ms-1">
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

export default HeaderAccount;
