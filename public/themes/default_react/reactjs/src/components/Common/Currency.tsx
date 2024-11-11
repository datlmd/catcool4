import { useState } from 'react'
import { Dropdown, Collapse } from 'react-bootstrap'
import { Link } from 'react-router-dom'
import { ICurrency, ICurrencyInfo } from 'src/store/types'

const Currency = ({ currency, type }: { currency: ICurrency; type?: string }) => {
  const [open, setOpen] = useState(false)

  const currencyItem =
    currency.list &&
    currency.list.map((value: ICurrencyInfo) => {
      if (type == 'collapse') {
        return (
          <li key={value.code}>
            <a key={value.code} href={value.href}>
              {value.symbol_left}
              {value.name}
              {value.symbol_right}
            </a>
          </li>
        )
      } else {
        return (
          <Dropdown.Item key={value.code} href={value.href}>
            {value.symbol_left}
            {value.name}
            {value.symbol_right}
          </Dropdown.Item>
        )
      }
    })

  if (type == 'collapse') {
    return (
      <>
        <Link
          to='#'
          onClick={() => setOpen(!open)}
          aria-controls='nav-collapse-currency-top'
          aria-expanded={open}
          className='nav-item icon-collapse collapsed'
        >
          {currency.info.symbol_left}
          {currency.info.code}
          {currency.info.symbol_right}
          <span></span>
        </Link>
        <Collapse in={open}>
          <div id='nav-collapse-currency-top' className='collapse multi-collapse'>
            <ul className='list-unstyled'>{currencyItem}</ul>
          </div>
        </Collapse>
      </>
    )
  } else {
    return (
      <>
        <Dropdown align='end'>
          <Dropdown.Toggle as='a' className='nav-link dropdown-toggle' id='nav-currency-account-top'>
            {currency.info.symbol_left}
            <span className='d-none d-md-inline'>{currency.info.code}</span>
            {currency.info.symbol_right}
          </Dropdown.Toggle>
          <Dropdown.Menu>{currencyItem}</Dropdown.Menu>
        </Dropdown>
      </>
    )
  }
}

export default Currency
