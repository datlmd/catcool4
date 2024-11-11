import { Link } from "react-router-dom";

import { IMenuInfo } from "src/store/types";

const MenuTop = ({ menuTop }: { menuTop: IMenuInfo[] }) => {

  const menuItem = Object.values(menuTop).map((item) => {
    return (
      <Link key={item.slug} to={item.slug} className="nav-link">
        {item.name}
      </Link>
    );
  });

  return <>{menuItem}</>;
};

export default MenuTop;
