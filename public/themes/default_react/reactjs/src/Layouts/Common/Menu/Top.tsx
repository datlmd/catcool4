import { Link } from '@inertiajs/inertia-react'

import { IMenuInfo } from '../../../types/index'

const MenuTop = ({ menuTop }: { menuTop: IMenuInfo[] }) => {
    const menuItem = Object.values(menuTop).map((item) => {
        return (
            <Link key={item.slug} href={item.slug} className='nav-link'>
                {item.name}
            </Link>
        )
    })

    return <>{menuItem}</>
}

export default MenuTop
