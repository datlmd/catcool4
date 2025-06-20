import { Link } from '@inertiajs/react'
import { ILayout } from '../../../types/index'

const HeaderLogo = ({ data }: ILayout) => {
    return (
        <>
            <div className='header-logo'>
                <Link key='logo-site' href={data.site_url}>
                    <img alt={data.site_name} src={data.logo} />
                </Link>
            </div>
        </>
    )
}

export default HeaderLogo
