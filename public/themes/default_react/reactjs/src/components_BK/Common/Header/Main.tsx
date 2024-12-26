import Container from 'react-bootstrap/Container'
import Nav from 'react-bootstrap/Nav'
import Navbar from 'react-bootstrap/Navbar'

import Currency from '../Currency'
import Language from '../Language'
import MenuTop from '../Menu/Top'
import HeaderAccount from './Account'

import { ILayout } from 'src/store/types'

const HeaderMain = ({ data }: ILayout) => {
  return (
    <>
      <Navbar className='bg-body-tertiary p-0'>
        <Container>
          <Navbar.Toggle aria-controls='header-main-navbar-nav' />
          <Navbar.Collapse id='header-main-navbar-nav'>
            <Nav className='me-auto'>
              <Currency currency={data.currency} />

              <MenuTop menuTop={data.menu_top} />

              <Nav.Link href={data.wishlist}>
                <i className='far fa-heart'></i>
                <span className='d-none d-md-inline ms-1'>{data.text_wishlist}</span>
                <span className='ms-1'>(0)</span>
              </Nav.Link>
              <Nav.Link href={data.shopping_cart}>
                <i className='fas fa-shopping-cart'></i>
                <span className='d-none d-md-inline ms-1'>{data.text_shopping_cart}</span>
                <span className='ms-1'>(0)</span>
              </Nav.Link>

              <HeaderAccount data={data} />

              <Language language={data.language} />
            </Nav>
          </Navbar.Collapse>
        </Container>
      </Navbar>
    </>
  )
}

export default HeaderMain
