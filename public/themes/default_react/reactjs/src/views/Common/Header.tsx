import HeaderInfo from "../../components/Common/Header/Info";
import HeaderLogo from "../../components/Common/Header/Logo";
import HeaderMain from "../../components/Common/Header/Main";
import HeaderMobile from "../../components/Common/Header/Mobile";
import HeaderSearch from "../../components/Common/Header/Search";
import MenuMain from "../../components/Common/Menu/Main";

import { ILayout } from "src/store/types";

const Header = ({data}: ILayout) => {
  return (
    <>
      <header id="header_main_pc" className="d-none d-lg-inline">
        <div className="container-fluid header-top">
          <div className="container-xxl d-flex justify-content-between">
            <div className="header-top-contact">
              <HeaderInfo data={data} />
            </div>
            <div className="header-top-account">
              <HeaderMain data={data} />
            </div>
          </div>
        </div>
        {/* {* phan header logo và tim kiem *} */}
        <div className="container-fluid header-center">
          <div className="container-xxl d-flex justify-content-between">
            <HeaderLogo data={data} />
            <HeaderSearch data={data} />
          </div>
        </div>
        {/* {* phan header menu chinh *} */}
        <div className="header-bottom-scroll" style={{ display: "none" }}></div>

        <div className="container-fluid header-bottom">
          <div className="container-xxl header-menu">
            <div className="header-menu-content">
              <MenuMain menuMain={data.menu_main} />
            </div>
          </div>
        </div>
      </header>

      {/* Mobile Menu */}
      <header id="header_main_mobile" className="d-block d-lg-none">
        <HeaderMobile data={data} />
      </header>
    </>
  );
};

export default Header;
