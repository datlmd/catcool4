import { Link } from "react-router-dom";

// Vi du fix map is not a function
// menuTop = {
//   course: 'JavaScript for beginners',
//   language: 'JavaScript',
//   creator: 'decodingweb.dev'
// }

const MenuTop = ({ menuTop }) => {
  let dataKeys = Object.keys(menuTop);
  //let dataKeys = Object.values(data) - Array.isArray(menuTop)

  const menuItem = dataKeys.map((key) => {
    let item = menuTop[key];
    return (
      <Link key={item.slug} to={item.slug} className="nav-link">
        {item.name}
      </Link>
    );
  });

  return <>{menuItem}</>;
};

export default MenuTop;
