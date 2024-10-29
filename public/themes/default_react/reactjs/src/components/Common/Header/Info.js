const HeaderInfo = (props) => {
  return (
    <>
      <ul className="nav nav-pills">
        {props.store_address && (
          <li className="nav-item d-none d-md-inline">
            <a className="nav-link disabled">
              <i className="far fa-dot-circle me-1"></i>
              {props.store_address}
            </a>
          </li>
        )}
        {props.store_phone && (
          <li className="nav-item contact-phone">
            <a href={"tel:" + props.store_phone} className="nav-link">
              <i className="fas fa-phone me-1"></i>
              {props.store_phone}
            </a>
          </li>
        )}
        {props.store_email && (
          <li className="nav-item">
            <a href={"mailto:" + props.store_email} className="nav-link">
              <i className="far fa-envelope me-1"></i>
              {props.store_email}
            </a>
          </li>
        )}
      </ul>
    </>
  );
};

export default HeaderInfo;
