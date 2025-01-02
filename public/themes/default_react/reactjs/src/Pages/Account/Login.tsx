'use strict'

import { useEffect, useState, FormEventHandler } from 'react'
import { Col, Form, Row, Button } from 'react-bootstrap'
import DefaultLayout from '../../Layouts/DefaultLayout'
import { usePage, Link } from '@inertiajs/inertia-react'
import { API, getRequestToken } from '../../utils/callApi'
import Message from '../../Components/UI/Message'

const Login = () => {
    const lang = usePage().props.lang
    const crsf_token = usePage().props.crsf_token
    const [data, setData] = useState({
        identity: '',
        password: '',
        remember: false,
        [crsf_token.name]: crsf_token.value
    })
    const [errors, setErrors] = useState({
        identity: '',
        password: ''
    })
    const [isShowError, setIsShowError] = useState<boolean>(false)

    useEffect(() => {}, [])

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, checked } = e.target
        setData((prevState) => ({
            ...prevState,
            [name]: name === 'remember' ? checked : value
        }))
    }

    const submit: FormEventHandler = async (e) => {
        e.preventDefault()
        try {
            const response = await API.post('account/login', data, getRequestToken())

            if (response.data.errors && response.data.errors !== undefined) {
                setErrors(response.data.errors)
                setIsShowError(true)
            }

            if (response.data.redirect !== undefined && response.data.redirect != '') {
                window.location = response.data.redirect
            }
        } catch (error) {
            setErrors(error)
            setIsShowError(true)
            console.log(error)
        }
    }

    return (
        <DefaultLayout>
            <h1 className='text-uppercase mb-4 text-center'>{lang.text_login}</h1>
            <div className='mx-auto' style={{ maxWidth: '500px' }}>
                <form onSubmit={submit}>
                    <Message message={errors} isShow={isShowError} type='danger' />

                    <Form.Floating className='mb-3'>
                        <Form.Control
                            name='identity'
                            id='input_identity'
                            type='text'
                            placeholder=''
                            value={data.identity}
                            onChange={handleChange}
                            isInvalid={!!errors.identity}
                        />
                        <label htmlFor='input_identity'>{lang.text_login_identity}</label>
                        <Form.Control.Feedback type='invalid'>{errors.identity}</Form.Control.Feedback>
                    </Form.Floating>

                    <Form.Floating className='mb-3'>
                        <Form.Control
                            name='password'
                            id='input_password'
                            type='password'
                            placeholder=''
                            value={data.password}
                            onChange={handleChange}
                            isInvalid={!!errors.password}
                        />
                        <label htmlFor='input_password'>{lang.text_password}</label>
                        <Form.Control.Feedback type='invalid'>{errors.password}</Form.Control.Feedback>
                    </Form.Floating>

                    <Form.Group as={Row} className='mb-3' controlId='input_remember'>
                        <Col sm={{ span: 12 }}>
                            <Form.Check
                                name='remember'
                                id='input_remember'
                                label={lang.text_remember}
                                checked={data.remember}
                                onChange={handleChange}
                            />
                        </Col>
                    </Form.Group>

                    <Form.Group as={Row} className='mb-3'>
                        <Col sm={{ span: 6 }}>
                            <Button type='submit'>{lang.button_login}</Button>
                        </Col>
                        <Col sm={{ span: 6 }} className='text-end'>
                            <Link href={lang.forgotten}>{lang.text_lost_password}</Link>
                        </Col>
                    </Form.Group>
                </form>
            </div>
        </DefaultLayout>
    )
}

export default Login
