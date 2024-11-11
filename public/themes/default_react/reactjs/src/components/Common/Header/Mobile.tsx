import { useState } from 'react'
import { Container, Nav, Navbar, Offcanvas } from 'react-bootstrap'

import Currency from '../Currency'
import Language from '../Language'
import HeaderAccount from './Account'
import HeaderLogo from './Logo'
import MenuMain from '../Menu/Main'
import HeaderSearch from './Search'

import { ILayout } from 'src/store/types'

const HeaderMobile = ({ data }: ILayout) => {
  const [show, setShow] = useState(false)
  const [showSearch, setShowSearch] = useState(false)

  const handleClose = () => setShow(false)
  const handleShow = () => setShow(true)

  const handleSearchClose = () => setShowSearch(false)
  const handleSearchShow = () => setShowSearch(true)

  return (
    <>
      <div className='header-mobile-scroll' style={{ display: 'none' }}></div>

      <div className='header-mobile-content container-fluid border-bottom'>
        <div className='d-flex justify-content-between'>
          <HeaderLogo data={data} />

          <div className='header-mobile-menu-icon'>
            <Navbar className='nav p-0'>
              <Container>
                <Navbar.Toggle aria-controls='header-mobile-navbar-nav' />
                <Navbar.Collapse id='header-mobile-navbar-nav'>
                  <Nav className='me-auto'>
                    <Nav.Link onClick={handleSearchShow} className='header-menu-icon-search'>
                      <i className='fas fa-search'></i>
                    </Nav.Link>

                    <Nav.Link href={data.wishlist} className='position-relative' title={data.text_wishlist}>
                      <i className='far fa-heart'></i>
                      <span className='position-absolute top-1 translate-middle badge rounded-pill bg-danger'>0</span>
                    </Nav.Link>

                    <Nav.Link href={data.shopping_cart} className='position-relative' title={data.text_shopping_cart}>
                      <i className='fas fa-shopping-cart'></i>
                      <span className='position-absolute top-1 translate-middle badge rounded-pill bg-danger'>0</span>
                    </Nav.Link>

                    <HeaderAccount data={data} />

                    <Nav.Link onClick={handleShow} className='position-relative' title={data.text_shopping_cart}>
                      <i className='fas fa-bars'></i>
                    </Nav.Link>
                  </Nav>
                </Navbar.Collapse>
              </Container>
            </Navbar>
          </div>
        </div>
      </div>

      {/* ---Khu vuc tim kiem mobile--- */}
      <Offcanvas show={showSearch} onHide={handleSearchClose} placement='top'>
        <Offcanvas.Header closeButton>
          <Offcanvas.Title>{data.text_search_title}</Offcanvas.Title>
        </Offcanvas.Header>
        <Offcanvas.Body>
          <HeaderSearch data={data} />
        </Offcanvas.Body>
      </Offcanvas>

      {/* ---Khu vuc hien thi menu mobile--- */}
      <Offcanvas show={show} onHide={handleClose} className='offcanvas-start header-mobile-offcanvas'>
        <Offcanvas.Header closeButton className='border-bottom'>
          <Offcanvas.Title>{data.text_menu}</Offcanvas.Title>
        </Offcanvas.Header>
        <Offcanvas.Body>
          <div className='d-flex align-items-start flex-column h-100'>
            <div className='mb-auto overflow-auto header-mobile-menu-main'>
              <MenuMain menuMain={data.menu_main} />
            </div>
            <div className='header-mobile-menu-bottom'>
              <ul className='nav header-mobile-menu-main'>
                <li className='nav-item'>
                  <Language language={data.language} type='collapse' />
                </li>
                <li className='nav-item'>
                  <Currency currency={data.currency} type='collapse' />
                </li>
              </ul>
            </div>
          </div>
        </Offcanvas.Body>
      </Offcanvas>
    </>
  )
}

export default HeaderMobile
