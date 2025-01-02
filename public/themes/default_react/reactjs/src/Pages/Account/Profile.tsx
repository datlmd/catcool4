'use strict'

import { useEffect, useState, FormEventHandler } from 'react'
import { Col, Form, Row, Button } from 'react-bootstrap'
import DefaultLayout from '../../Layouts/DefaultLayout'
import { usePage, Link } from '@inertiajs/inertia-react'
import { API, getRequestToken } from '../../utils/callApi'
import Message from '../../Components/UI/Message'

const Profile = () => {
    const lang = usePage().props.lang
    const crsf_token = usePage().props.crsf_token
  

    useEffect(() => {}, [])

    

    return (
        <DefaultLayout>
            <h1 className='text-uppercase mb-4 text-center'>{lang.text_profile}</h1>
            
        </DefaultLayout>
    )
}

export default Profile
