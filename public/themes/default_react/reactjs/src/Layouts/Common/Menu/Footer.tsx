import { Link } from '@inertiajs/react'
import Accordion from 'react-bootstrap/Accordion'

import { ILayout, IMenuInfo } from '../../../types/index'

const MenuFooter = ({ data }: ILayout) => {
    if (!data.menu_footer || data.menu_footer === undefined) {
        return <></>
    }

    const menuKeys = Object.keys(data.menu_footer)

    function ChildrenItem(childrens: IMenuInfo[]) {
        return childrens.map((menu: IMenuInfo) => {
            return (
                <li key={'mn_footer_sub_li_' + menu.menu_id}>
                    <Link key={'mn_footer_sub_link_' + menu.menu_id} href={menu.slug} className='nav-item'>
                        <span>{menu.name}</span>
                    </Link>
                    {menu.subs && (
                        <>
                            <ul key={'mn_footer_sub_ul_' + menu.menu_id} className='list-unstyled'>
                                Children(menu.subs)
                            </ul>
                        </>
                    )}
                </li>
            )
        })
    }

    const menuItem = data.menu_footer.map((item: IMenuInfo, index: number) => {
        return (
            <Accordion.Item
                key={'footer_accordion_item_' + index}
                eventKey={index.toString()}
                className='col-12 col-md-6 col-lg-3'
            >
                <h5 className='d-none d-md-block'>
                    <span>{item.name}</span>
                </h5>
                <Accordion.Header as='h5' className='d-block d-md-none'>
                    <span>{item.name}</span>
                </Accordion.Header>

                {item.subs && (
                    <Accordion.Body as='ul' className='list-unstyled collapse show p-0'>
                        {ChildrenItem(item.subs)}
                    </Accordion.Body>
                )}
            </Accordion.Item>
        )
    })

    return (
        <>
            <Accordion key={'fdsfdsfds'} defaultActiveKey={menuKeys} id='accordion_menu_footer' className='row'>
                {menuItem}
            </Accordion>
        </>
    )
}

export default MenuFooter
