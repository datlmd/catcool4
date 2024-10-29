import { Link } from "react-router-dom";
import Nav from "react-bootstrap/Nav";

// Vi du fix map is not a function
// menuTop = {
//   course: 'JavaScript for beginners',
//   language: 'JavaScript',
//   creator: 'decodingweb.dev'
// }

function Children(childrens) {
  let childrenKeys = Object.keys(childrens);
  if (!Array.isArray(childrenKeys)) {
    return <></>;
  }

  const childrenItem = childrenKeys.map((key) => {
    let item = childrens[key];
    return (
      <li key={"mn_main_sub_li_" + item.menu_id}>
        <Link
          key={"mn_main_sub_link_" + item.menu_id}
          to={item.slug}
          className="nav-item">
          <span>{item.name}</span>
        </Link>
        {item.subs && Children(item.subs)}
      </li>
    );
  });

  return (
    <>
      <div className="dropdown-menu">
        <ul className="list-unstyled">{childrenItem}</ul>
      </div>
    </>
  );
}

const MenuMain = ({ menuMain }) => {
  let dataKeys = Object.keys(menuMain);
  //let dataKeys = Object.values(data) - Array.isArray(menuTop)

  const menuItem = dataKeys.map((key) => {
    let item = menuMain[key];
    return (
      <Nav.Item key={"mn_main_li_" + item.menu_id} as="li" className="dropdown">
        <Link
          key={"mn_main_link_" + item.menu_id}
          to={item.slug}
          className="dropdown-item">
          <span>{item.name}</span>
        </Link>
        {item.subs && Children(item.subs)}
      </Nav.Item>
    );
  });

  return (
    <>
      <Nav as="ul">{menuItem}</Nav>
    </>
  );
};

export default MenuMain;
