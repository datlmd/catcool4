import Copyright from "../../components/Common/Footer/Copyright.tsx";
import NewsLetter from "../../components/Common/Footer/NewsLetter.tsx";
import Social from "../../components/Common/Footer/Social.tsx";
import MenuFooter from "../../components/Common/Menu/Footer.tsx";

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
