import { decodeHtml } from "../../utils/String";

function Breadcrumb(props) {
  return (
    <>
      <div className="container-fluid breadcumb-content mb-4">
        <div className="container-xxl">
          <nav
            aria-label="breadcrumb"
            dangerouslySetInnerHTML={{ __html: decodeHtml(props.breadcrumb) }}
          ></nav>
          {/* {props.breadcrumb_title} */}
        </div>
      </div>
    </>
  );
}

export default Breadcrumb;
