import { Link } from "react-router-dom";
import { ILayout } from "src/store/types";

const HeaderInfo = ({ data }: ILayout) => {
  return (
    <>
      <ul className="nav nav-pills">
        {data.store_address && (
          <li className="nav-item d-none d-md-inline">
            <Link to="#" className="nav-link disabled">
              <i className="far fa-dot-circle me-1"></i>
              {data.store_address}
            </Link>
          </li>
        )}
        {data.store_phone && (
          <li className="nav-item contact-phone">
            <Link to={"tel:" + data.store_phone} className="nav-link">
              <i className="fas fa-phone me-1"></i>
              {data.store_phone}
            </Link>
          </li>
        )}
        {data.store_email && (
          <li className="nav-item">
            <Link to={"mailto:" + data.store_email} className="nav-link">
              <i className="far fa-envelope me-1"></i>
              {data.store_email}
            </Link>
          </li>
        )}
      </ul>
    </>
  );
};

export default HeaderInfo;
