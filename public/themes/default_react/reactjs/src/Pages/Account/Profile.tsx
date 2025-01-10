'use strict'

import { useEffect } from 'react'
import DefaultLayout from '../../Layouts/DefaultLayout'
// import { Link } from '@inertiajs/inertia-react'

const Profile = ({ contents, alert }: { contents?: any; alert?: string }) => {
    useEffect(() => {}, [])

    return (
        <DefaultLayout>
            <div className='row'>
                <div className='col-sm-3'>
                    <div className='text-center'>
                        <img
                            src={contents.customer_avatar}
                            alt={contents.customer_name}
                            className='rounded-circle w-100'
                        />
                    </div>
                    <h3 className='text-uppercase text-center my-3'>{contents.customer_name}</h3>
                </div>

                <div className='col-sm-9'>
                    {alert && (
                        <div id='profile_alert' className='mb-4' dangerouslySetInnerHTML={{ __html: alert }}></div>
                    )}

                    <h2 className='mb-2'>{contents.text_my_account}</h2>
                    <ul className='list-unstyled'>
                        <li className='pb-2'>
                            <a href={contents.edit}>{contents.text_profile_edit}</a>
                        </li>
                        <li className='pb-2'>
                            <a href={contents.password}>{contents.text_profile_password}</a>
                        </li>
                        <li className='pb-2'>
                            <a href={contents.address}>{contents.text_profile_address}</a>
                        </li>
                        <li className='pb-2'>
                            <a href={contents.wishlist}>{contents.text_profile_wishlist}</a>
                        </li>
                    </ul>
                    <h2 className='mt-3 mb-2'>{contents.text_my_orders}</h2>
                    <ul className='list-unstyled'>
                        <li className='pb-2'>
                            <a href={contents.order}>{contents.text_profile_order}</a>
                        </li>
                        <li className='pb-2'>
                            <a href={contents.subscription}>{contents.text_profile_subscription}</a>
                        </li>
                        <li className='pb-2'>
                            <a href={contents.download}>{contents.text_profile_download}</a>
                        </li>
                        {contents.reward && (
                            <li className='pb-2'>
                                <a href={contents.reward}>{contents.text_profile_reward}</a>
                            </li>
                        )}
                        <li className='pb-2'>
                            <a href={contents.return}>{contents.text_profile_return}</a>
                        </li>
                        <li className='pb-2'>
                            <a href={contents.transaction}>{contents.text_profile_transaction}</a>
                        </li>
                    </ul>

                    <h2 className='mt-3 mb-2'>{contents.text_newsletter}</h2>
                    <ul className='list-unstyled'>
                        <li className='pb-2'>
                            <a href={contents.newsletter}>{contents.text_profile_newsletter}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </DefaultLayout>
    )
}

export default Profile
