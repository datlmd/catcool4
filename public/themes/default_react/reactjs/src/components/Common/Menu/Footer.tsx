import { Link } from "react-router-dom";
import Accordion from "react-bootstrap/Accordion";

const MenuFooter = (props) => {
  if (!props.menu_footer || props.menu_footer === undefined) {
    return <></>;
  }

  let menuKeys = Object.keys(props.menu_footer);

  function ChildrenItem(childrens) {
    return childrens.map((menu) => {
      return (
        <li key={"mn_footer_sub_li_" + menu.menu_id}>
          <Link
            key={"mn_footer_sub_link_" + menu.menu_id}
            to={menu.slug}
            className="nav-item"
          >
            <span>{menu.name}</span>
          </Link>
          {menu.subs && (
            <>
              <ul
                key={"mn_footer_sub_ul_" + menu.menu_id}
                className="list-unstyled"
              >
                Children(menu.subs)
              </ul>
            </>
          )}
        </li>
      );
    });
  }

  const menuItem = props.menu_footer.map((item, index) => {
    return (
      <Accordion.Item
        key={"footer_accordion_item_" + index}
        eventKey={index.toString()}
        className="col-12 col-md-6 col-lg-3"
      >
        <h5 className="d-none d-md-block">
          <span>{item.name}</span>
        </h5>
        <Accordion.Header as="h5" className="d-block d-md-none">
          <span>{item.name}</span>
        </Accordion.Header>

        {item.subs && (
          <Accordion.Body
            as="ul"
            className="list-unstyled collapse show p-0"
          >
            {ChildrenItem(item.subs)}
          </Accordion.Body>
        )}
      </Accordion.Item>
    );
  });

  return (
    <>
      <Accordion
        key={"fdsfdsfds"}
        defaultActiveKey={menuKeys}
        id="accordion_menu_footer"
        className="row"
      >
        {menuItem}
      </Accordion>
    </>
  );
};

export default MenuFooter;
