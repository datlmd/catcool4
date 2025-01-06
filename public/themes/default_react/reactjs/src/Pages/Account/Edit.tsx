'use strict'

import { useEffect } from 'react'
import DefaultLayout from '../../Layouts/DefaultLayout'

const Profile = ({ contents, alert }: { contents?: any; alert?: string }) => {
    useEffect(() => {}, [])

    return (
        <DefaultLayout>
            <div className='row'>
                {contents.text_account_edit_title}
            </div>
        </DefaultLayout>
    )
}

export default Profile
