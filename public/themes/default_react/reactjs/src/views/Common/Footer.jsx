import Copyright from "../../components/Common/Footer/Copyright.jsx";
import NewsLetter from "../../components/Common/Footer/NewsLetter.jsx";
import Social from "../../components/Common/Footer/Social.jsx";
import MenuFooter from "../../components/Common/Menu/Footer.jsx";

const Footer = (props) => {
  return (
    <>
      <footer id="footer">
        
        <div className="footer-newsletter container-fluid">
          <div className="container-xxl">
            <div className="row">
              <div className="col-md-6 col-lg-8 mb-3">
                <NewsLetter {...props} />
              </div>

              <div className="col-md-6 col-lg-4 text-center">
                <Social {...props} />
              </div>
            </div>
          </div>
        </div>

        <div className="container-fluid">
          <div className="container-xxl menu-footer">
            <MenuFooter {...props} />
          </div>
        </div>

        <Copyright {...props} />

      </footer>
    </>
  );
};

export default Footer;
