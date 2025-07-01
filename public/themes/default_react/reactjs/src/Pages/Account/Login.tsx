'use strict'

import { useEffect, useState, FormEventHandler } from 'react'
import { Col, Form, Row, Button } from 'react-bootstrap'
import DefaultLayout from '../../Layouts/DefaultLayout'
import { usePage, Link, router } from '@inertiajs/react'
import Message from '../../Components/UI/Message'

const Login = ({
    contents,
    alert,
    lang
}: {
    contents: { [key: string]: string }
    lang?: { [key: string]: string }
    alert?: string
}) => {
    const { errors, crsf_token } = usePage().props
    const [data, setData] = useState({
        identity: '',
        password: '',
        remember: false,
        [crsf_token?.name ?? 'csrf_token']: crsf_token?.value ?? ''
    })

    useEffect(() => {}, [])

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, checked } = e.target
        setData((prevState) => ({
            ...prevState,
            [name]: name === 'remember' ? checked : value
        }))
    }

    const submitLogin: FormEventHandler = async (e) => {
        e.preventDefault()
        await router.post('login', data)
    }

    return (
        <DefaultLayout>
            <h1 className='text-uppercase mb-4 text-center'>{lang?.text_login}</h1>
            <div className='mx-auto' style={{ maxWidth: '500px' }}>
                {alert && <div id='profile_alert' className='mb-4' dangerouslySetInnerHTML={{ __html: alert }}></div>}
                <form onSubmit={submitLogin}>
                    <Message message={errors} isShow={!!errors} type='danger' />
                    <Form.Floating className='mb-3'>
                        <Form.Control
                            name='identity'
                            id='input_identity'
                            type='text'
                            placeholder=''
                            value={data.identity}
                            onChange={handleChange}
                            isInvalid={!!errors?.identity}
                        />
                        <label htmlFor='input_identity'>{lang?.text_login_identity}</label>
                        <Form.Control.Feedback type='invalid'>{errors?.identity}</Form.Control.Feedback>
                    </Form.Floating>

                    <Form.Floating className='mb-3'>
                        <Form.Control
                            name='password'
                            id='input_password'
                            type='password'
                            placeholder=''
                            value={data.password}
                            onChange={handleChange}
                            isInvalid={!!errors?.password}
                        />
                        <label htmlFor='input_password'>{lang?.text_password}</label>
                        <Form.Control.Feedback type='invalid'>{errors?.password}</Form.Control.Feedback>
                    </Form.Floating>

                    <Form.Group as={Row} className='mb-3' controlId='input_remember'>
                        <Col sm={{ span: 12 }}>
                            <Form.Check
                                name='remember'
                                id='input_remember'
                                label={lang?.text_remember}
                                checked={data.remember}
                                onChange={handleChange}
                            />
                        </Col>
                    </Form.Group>

                    <Form.Group as={Row} className='mb-3'>
                        <Col sm={{ span: 6 }}>
                            <Button type='submit'>{lang?.button_login}</Button>
                        </Col>
                        <Col sm={{ span: 6 }} className='text-end'>
                            <Link href={contents.forgotten}>{lang?.text_lost_password}</Link>
                        </Col>
                    </Form.Group>
                </form>
            </div>
        </DefaultLayout>
    )
}

export default Login
