import { Link } from 'react-router-dom'
import Nav from 'react-bootstrap/Nav'

import { IMenuInfo } from 'src/store/types'

// Vi du fix map is not a function
// menuTop = {
//   course: 'JavaScript for beginners',
//   language: 'JavaScript',
//   creator: 'decodingweb.dev'
// }

function Children(childrens: IMenuInfo[]) {
  // let childrenKeys = Object.keys(childrens)
  // if (!Array.isArray(childrenKeys)) {
  //   return <></>
  // }

  const childrenItem = Object.values(childrens).map((item) => {
    return (
      <li key={'mn_main_sub_li_' + item.menu_id}>
        <Link key={'mn_main_sub_link_' + item.menu_id} to={item.slug} className='nav-item'>
          <span>{item.name}</span>
        </Link>
        {item.subs && Children(item.subs)}
      </li>
    )
  })

  return (
    <>
      <div className='dropdown-menu'>
        <ul className='list-unstyled'>{childrenItem}</ul>
      </div>
    </>
  )
}

const MenuMain = ({ menuMain }: { menuMain: IMenuInfo[] }) => {
  const menuItem = Object.values(menuMain).map((item: IMenuInfo) => {
    return (
      <Nav.Item key={'mn_main_li_' + item.menu_id} as='li' className='dropdown'>
        <Link key={'mn_main_link_' + item.menu_id} to={item.slug} className='dropdown-item'>
          <span>{item.name}</span>
        </Link>
        {item.subs && Children(item.subs)}
      </Nav.Item>
    )
  })

  return (
    <>
      <Nav as='ul'>{menuItem}</Nav>
    </>
  )
}

export default MenuMain
