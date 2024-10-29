import { Link } from "react-router-dom";

const HeaderLogo = (props) => {
  return (
    <>
      <div className="header-logo">
        <Link key="logo-site" href={props.site_url}>
          <img alt={props.site_name} src={props.logo} />
        </Link>
      </div>
    </>
  );
};

export default HeaderLogo;
