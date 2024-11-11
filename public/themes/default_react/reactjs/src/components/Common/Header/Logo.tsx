import { Link } from 'react-router-dom'
import { ILayout } from 'src/store/types'

const HeaderLogo = ({ data }: ILayout) => {
  return (
    <>
      <div className='header-logo'>
        <Link key='logo-site' to={data.site_url}>
          <img alt={data.site_name} src={data.logo} />
        </Link>
      </div>
    </>
  )
}

export default HeaderLogo
