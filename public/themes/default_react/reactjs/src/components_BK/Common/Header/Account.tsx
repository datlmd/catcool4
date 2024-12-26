import Dropdown from 'react-bootstrap/Dropdown'

import { ILayout } from 'src/store/types'

const HeaderAccount = ({ data }: ILayout) => {
  if (data.logged) {
    return (
      <>
        <Dropdown align='end'>
          <Dropdown.Toggle as='a' className='nav-link dropdown-toggle' id='dropdown-account-top'>
            <img src={data.customer_avatar} alt={data.customer_name} className='rounded-circle customer-avatar' />
            <span className='d-none d-lg-inline ms-1'>{data.customer_name}</span>
          </Dropdown.Toggle>

          <Dropdown.Menu>
            <Dropdown.Item href={data.account}>{data.text_account}</Dropdown.Item>
            <Dropdown.Item href={data.order}>{data.text_order}</Dropdown.Item>
            <Dropdown.Item href={data.transaction}>{data.text_transaction}</Dropdown.Item>
            <Dropdown.Divider />
            <Dropdown.Item href={data.logout}>{data.text_logout}</Dropdown.Item>
          </Dropdown.Menu>
        </Dropdown>
      </>
    )
  } else {
    return (
      <>
        <Dropdown align='end'>
          <Dropdown.Toggle as='a' className='nav-link dropdown-toggle' id='dropdown-account-top'>
            <i className='fas fa-user'></i>
            <span className='d-none d-lg-inline ms-1'>{data.text_my_account}</span>
          </Dropdown.Toggle>

          <Dropdown.Menu>
            <Dropdown.Item href={data.login}>{data.text_login}</Dropdown.Item>
            <Dropdown.Item href={data.register}>{data.text_register}</Dropdown.Item>
          </Dropdown.Menu>
        </Dropdown>
      </>
    )
  }
}

export default HeaderAccount
