import { Link } from '@inertiajs/inertia-react'
import { ILayout } from '../../types/index'

const Account = ({ data }: ILayout) => {
    return (
        <>
            <div className='list-group mb-3'>
                {!data.logged && (
                    <>
                        <Link href={data.login} className='list-group-item'>
                            {data.text_login}
                        </Link>
                        <Link href={data.register} className='list-group-item'>
                            {data.text_register}
                        </Link>
                        <Link href={data.logforgottenin} className='list-group-item'>
                            {data.text_forgotten}
                        </Link>
                    </>
                )}
                <Link href={data.profile} className='list-group-item'>
                    {data.text_profile}
                </Link>
                {data.logged && (
                    <>
                        <Link href={data.edit} className='list-group-item'>
                            {data.text_account_edit}
                        </Link>
                        <Link href={data.password} className='list-group-item'>
                            {data.text_password}
                        </Link>
                    </>
                )}
                <Link href={data.address} className='list-group-item'>
                    {data.text_address}
                </Link>
                <Link href={data.wishlist} className='list-group-item'>
                    {data.text_wishlist}
                </Link>
                <Link href={data.order} className='list-group-item'>
                    {data.text_order}
                </Link>
                <Link href={data.download} className='list-group-item'>
                    {data.text_download}
                </Link>
                <Link href={data.reward} className='list-group-item'>
                    {data.text_reward}
                </Link>
                <Link href={data.return} className='list-group-item'>
                    {data.text_return}
                </Link>
                <Link href={data.transaction} className='list-group-item'>
                    {data.text_transaction}
                </Link>
                <Link href={data.newsletter} className='list-group-item'>
                    {data.text_newsletter}
                </Link>
                <Link href={data.subscription} className='list-group-item'>
                    {data.text_subscription}
                </Link>
                {!data.logged && (
                    <Link href={data.logout} className='list-group-item'>
                        {data.text_logout}
                    </Link>
                )}
            </div>
        </>
    )
}

export default Account
