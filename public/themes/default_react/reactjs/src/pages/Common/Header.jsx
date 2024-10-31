import HeaderInfo from "../../components/Common/Header/Info.jsx";
import HeaderLogo from "../../components/Common/Header/Logo.jsx";
import HeaderMain from "../../components/Common/Header/Main.jsx";
import HeaderSearch from "../../components/Common/Header/Search.jsx";
import MenuMain from "../../components/Common/Menu/Main.jsx";

const Header = (props) => {
  return (
    <>
      <header id="header_main_pc" className="d-none d-lg-inline">
        <div className="container-fluid header-top">
          <div className="container-xxl d-flex justify-content-between">
            <div className="header-top-contact">
              <HeaderInfo {...props} />
            </div>
            <div className="header-top-account">
              <HeaderMain {...props} />
            </div>
          </div>
        </div>
        {/* {* phan header logo và tim kiem *} */}
        <div className="container-fluid header-center">
          <div className="container-xxl d-flex justify-content-between">
            <HeaderLogo {...props} />
            <HeaderSearch {...props} />
          </div>
        </div>
        {/* {* phan header menu chinh *} */}
        <div className="header-bottom-scroll" style={{ display: "none" }}></div>

        <div className="container-fluid header-bottom">
          <div className="container-xxl header-menu">
            <div className="header-menu-content">
              <MenuMain menuMain={props.menu_main} />
            </div>
          </div>
        </div>
      </header>
    </>
  );
};

export default Header;
