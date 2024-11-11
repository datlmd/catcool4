import { useState } from 'react'
import { Dropdown, Collapse } from 'react-bootstrap'
import { Link } from 'react-router-dom'
import { ILanguage, ILanguageInfo } from 'src/store/types'

const Language = ({ language, type }: { language: ILanguage; type?: string }) => {
  const [open, setOpen] = useState(false)

  const languageItem =
    language.list &&
    language.list.map((value: ILanguageInfo) => {
      if (type && type == 'collapse') {
        return (
          <li key={value.code}>
            <a href={value.href}>
              <i className={value.icon}></i> {value.text_language}
            </a>
          </li>
        )
      } else {
        return (
          <Dropdown.Item key={value.code} href={value.href}>
            <i className={value.icon}></i> {value.text_language}
          </Dropdown.Item>
        )
      }
    })

  if (type && type == 'collapse') {
    return (
      <>
        <Link
          to='#'
          onClick={() => setOpen(!open)}
          aria-controls='nav-collapse-account-top'
          aria-expanded={open}
          className='nav-item icon-collapse collapsed'
        >
          <i className={language.info.icon + ' me-1'}></i>
          {language.info.text_language}
          <span></span>
        </Link>
        <Collapse in={open}>
          <div id='nav-collapse-account-top' className='collapse multi-collapse'>
            <ul className='list-unstyled'>{languageItem}</ul>
          </div>
        </Collapse>
      </>
    )
  } else {
    return (
      <>
        <Dropdown align='end'>
          <Dropdown.Toggle as='a' className='nav-link dropdown-toggle' id='nav-dropdown-account-top'>
            <i className={language.info.icon}></i>{' '}
            <span className='d-none d-md-inline'>{language.info.text_language}</span>
          </Dropdown.Toggle>
          <Dropdown.Menu>{languageItem}</Dropdown.Menu>
        </Dropdown>
      </>
    )
  }
}

export default Language
