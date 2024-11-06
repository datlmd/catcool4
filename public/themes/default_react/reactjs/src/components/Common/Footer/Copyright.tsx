const Copyright = (props) => {
  return (
    <>
      <div className="footer-copyright container-fluid">
        <div className="container-xxl">
          {props.store_open && (
            <>
              <span className="text-opentime_title">
                {props.text_business_hours}
              </span>
              <span className="text-opentime_value">{props.store_open}</span>
              <br />
            </>
          )}

          <img
            src={props.payment_icon}
            alt="Payment icons"
            className="img-fluid mb-2"
          />
          <br />
          <span
            className="text-copyright"
            data-type="lang"
            data-key="Frontend.text_copyright"
            dangerouslySetInnerHTML={{ __html: props.text_copyright }}
          ></span>
        </div>
      </div>
    </>
  );
};

export default Copyright;
