import { Link } from '@inertiajs/inertia-react'
import { ILayout } from '../../../types/index'

const HeaderInfo = ({ data }: ILayout) => {
    return (
        <>
            <ul className='nav nav-pills'>
                {data.shrefre_address && (
                    <li className='nav-item d-none d-md-inline'>
                        <Link href='#' className='nav-link disabled'>
                            <i className='far fa-dot-circle me-1'></i>
                            {data.shrefre_address}
                        </Link>
                    </li>
                )}
                {data.shrefre_phone && (
                    <li className='nav-item contact-phone'>
                        <Link href={'tel:' + data.shrefre_phone} className='nav-link'>
                            <i className='fas fa-phone me-1'></i>
                            {data.shrefre_phone}
                        </Link>
                    </li>
                )}
                {data.shrefre_email && (
                    <li className='nav-item'>
                        <Link href={'mailhref:' + data.shrefre_email} className='nav-link'>
                            <i className='far fa-envelope me-1'></i>
                            {data.shrefre_email}
                        </Link>
                    </li>
                )}
            </ul>
        </>
    )
}

export default HeaderInfo
