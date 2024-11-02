import Breadcrumb from "react-bootstrap/Breadcrumb";

function CommonBreadcrumb(props) {
  if (props.breadcrumbs.length <= 0 || props.breadcrumbs === undefined) {
    return <></>;
  }

  const breadcrumbItem = props.breadcrumbs.map((value, index, array) => {
    if (array.length - 1 === index) {
      return (
        <Breadcrumb.Item key={"breadcrumb" + value.title} active>
          {value.title}
        </Breadcrumb.Item>
      );
    } else {
      return (
        <Breadcrumb.Item key={"breadcrumb" + value.title} href={value.href}>
          {value.title}
        </Breadcrumb.Item>
      );
    }
  });
  return (
    <>
      <div className="container-fluid breadcumb-content mb-4">
        <div className="container-xxl">
          <Breadcrumb>{breadcrumbItem}</Breadcrumb>
          {/* {props.breadcrumb_title} */}
        </div>
      </div>
    </>
  );
}

export default CommonBreadcrumb;
